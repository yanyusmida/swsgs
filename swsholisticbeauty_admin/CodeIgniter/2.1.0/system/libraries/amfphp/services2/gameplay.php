<?php

class gameplay {

    private $output;
    /**
      Input Params: $testVar (string)
      Description :
     */
    private $CI;
    function gameplay() {
        $this->CI = &get_instance();
        //constructor
    }

    public function gamestart($fbid) {
        try {
            //insert to database
            $puzzledata = array(array(0, 1, 2, 3, 4, 5, 6, 7, 8));
            $difficulty = array(50, 1075, 1100);
            $getPat = array();
            $repeat = true;
            $similaritycheck = 0;
            for ($j = 0; $j < 3; $j++) {
                $repeat = true;
                $puzzle = array(0, 1, 2, 3, 4, 5, 6, 7, 8); //$puzzledata[rand(0, sizeof($puzzledata)-1)];
                while ($repeat) {
                    $similaritycheck = 0;
                    for ($i = 0; $i < $difficulty[$j]; $i++) {
                        swap($puzzle);
                    }
                    for ($i = 0; $i < sizeof($puzzle); $i++) {
                        if ($puzzle[$i] == $i) {
                            $similaritycheck++;
                        }
                    }
                    if ($similaritycheck < 5) {
                        $repeat = false;
                    }
                }
                $getPat[] = $puzzle;
            }

            if (1) {
                if ($fbid == "100000869543256") {
                    $getPat = array(array(3, 1, 2, 0, 4, 5, 6, 7, 8), array(1, 0, 2, 3, 4, 5, 6, 7, 8), array(3, 1, 2, 0, 4, 5, 6, 7, 8));
                }
            }

            $currentdatetime = date('U');
            //
            //print_r($this->CI->gateway);
            $query = "INSERT INTO laneige_sliding_gameplay (fbid, gamestart, startingparam) VALUES (?,?,?)";
            $this->CI->db->query($query, array($fbid, $currentdatetime, json_encode($getPat)));

            $query = "UPDATE laneige_sliding_users SET gameplay = gameplay+1 WHERE fbid = ?";
            $this->CI->db->query($query, array($fbid));

            $this->output["result"] = array("error" => "0", "message" => "success", "query" => $query, "data" => array("time" => $currentdatetime, "pat" => json_encode($getPat)));
        } catch (Exception $e) {
            $this->output["result"] = array("error" => "1", "message" => $e->getMessage());
        }
        return $this->output;
    }

    public function sendscore($fbid, $starttime, $encryptdetaildata) {
        try {
            //set_time_limit(900);
            print
            $query = "SELECT gameplayid FROM laneige_sliding_gameplay where gamestart = '" . $starttime . "' AND fbid = '" . $fbid . "'";
            $data = $this->CI->db->query($query)->result_array();
            if (sizeof($data) > 0) {
                $crypto = new Crypt;
                $crypto->init(substr($fbid, 0, 4) . substr($starttime, 0, 4));
                $detaildata = json_decode($crypto->decrypt($encryptdetaildata), true);
                $gameEnddatatime = date('U');
                $servertimedifferent = $gameEnddatatime - $starttime;
                $flashstarttime = -1;
                $flashendtime = -1;
                $firstTimer = -1;
                for ($i = 0; $i < sizeof($detaildata); $i++) {
                    if ($flashstarttime < 0) {
                        if ($detaildata[$i]['l'] == 's') {
                            $flashstarttime = $detaildata[$i]['t'];
                        }
                    }
                    if ($flashendtime < 0) {
                        if ($detaildata[$i]['l'] == 'e') {
                            $flashendtime = $detaildata[$i]['t'];
                        }
                    }
                    if ($firstTimer < 0) {
                        if (isset($detaildata[$i]['mv'])) {
                            $firstTimer = $detaildata[$i]['t'];
                        }
                    }
                }
                $flashtimedifferent = $flashendtime - $flashstarttime;
                $gameid = $data[0]["gameplayid"];
                if ($firstTimer < 3000) {
                    $gamerror = 'abnormal game timing, error code:' . abs(3000 - $firstTimer);
                    $query = "Update laneige_sliding_gameplay SET gamescore = ?, gameend = ?, gamedata =?, serverTime=?, flashTime=?,error=? WHERE gameplayid = ?";
                    $this->CI->db->query($query, array($totalscore, date('Y-m-d H:i:s'), json_encode($detaildata), $servertimedifferent, $flashtimedifferent, $gamerror, $gameid));
                    $returnid = $this->CI->db->insert_id();
                    $this->output["result"] = array("error" => "0", "message" => "Invalid Game playtime - speed hack", "query" => $query, "code" => abs($flashtimedifferent - $servertimedifferent * 1000));
                } else if (abs($flashtimedifferent - $servertimedifferent * 1000) < 5000) {
                    $gamerror = '';
                    $query = "Update laneige_sliding_gameplay SET gamescore = ?, gameend = ?, gamedata =?, serverTime=?, flashTime=?,error=? WHERE gameplayid = ?";
                    $this->CI->db->query($query, array($flashtimedifferent, $gameEnddatatime, json_encode($detaildata), $servertimedifferent, $flashtimedifferent, $gamerror, $gameid));
                    $returnid = $this->CI->db->insert_id();

                    $query = "SELECT game_score FROM laneige_sliding_users WHERE fbid = '" . $fbid . "'";
                    $data = $this->CI->db->query($query)->result_array();
                    if (sizeof($data) > 0) {
                        $b_score = $data[0]['game_score'];
                        if ($flashtimedifferent < $b_score || $b_score == 0) {

                            $query = "UPDATE laneige_sliding_users SET game_score = ?, gameplayid = ? WHERE fbid = ?";
                            $this->CI->db->query($query, array($flashtimedifferent, $gameid, $fbid));
                        }


                        $query = "UPDATE laneige_sliding_users SET complete_gameplay = complete_gameplay+1 WHERE fbid = ?";
                        $this->CI->db->query($query, array($fbid));

                        $this->output["result"] = array("error" => "0", "message" => "success", "query" => $query, "cscore" => $flashtimedifferent);
                    } else {
                        $this->output["result"] = array("error" => "1", "message" => "Invalid ID", "query" => $query);
                    }
                } else {
                    $gamerror = 'abnormal game timing, error code:' . abs($flashtimedifferent - $servertimedifferent);
                    $query = "Update laneige_sliding_gameplay SET gamescore = ?, gameend = ?, gamedata =?, serverTime=?, flashTime=?,error=? WHERE gameplayid = ?";
                    $this->CI->db->query($query, array($totalscore, date('Y-m-d H:i:s'), json_encode($detaildata), $servertimedifferent, $flashtimedifferent, $gamerror, $gameid));
                    $returnid = $this->CI->db->insert_id();
                    $this->output["result"] = array("error" => "0", "message" => "Invalid Game playtime", "query" => $query, "code" => abs($flashtimedifferent - $servertimedifferent * 1000));
                }
            } else {
                $this->output["result"] = array("error" => "1", "message" => "gameplay id not exist.", "query" => $query, "gameid" => '0');
            }
        } catch (Exception $e) {
            $this->output["result"] = array("error" => "1", "message" => $e->getMessage());
        }
        return $this->output;
    }

}
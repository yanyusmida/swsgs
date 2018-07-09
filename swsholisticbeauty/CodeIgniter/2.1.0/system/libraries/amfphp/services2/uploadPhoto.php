<?php
class uploadPhoto{
		private $output;
		
		/**
		Input Params: $testVar (string)
		Description : 
		 */		
		function uploadPhoto(){
			//constructor
		}
				
		public function savePhoto($fbid, $size, $raw_ba){
			try{
				set_time_limit(900);
				$filename = $fbid.time();
				//insert to database
				$resu = file_put_contents("../../photo/720/".$filename.".jpg", $raw_ba->data);
				$filesize = filesize("../../photo/720/".$filename.".jpg");
				if($size != $filesize){			
					//filesize not match upload failed.
					$this->output["result"] = array("error"=>"1","message"=>"size different");
				}else if($resu == "failure" || $resu == false){
					$this->output["result"] = array("error"=>"1","message"=>"error is ".$resu." !");
				}else{
					$this->createthumbnail("../../photo/720/".$filename.".jpg", $filename, 424, 424, "../../photo/424/");
					$this->createthumbnail("../../photo/720/".$filename.".jpg", $filename, 117, 117, "../../photo/117/");					
					$this->output["result"] = array("error"=>"0","message"=>"success","query"=>$query,"photourl"=>$filename);
				}
			}catch(Exception $e){
				$this->output["result"] = array("error"=>"1","message"=>$e->getMessage());
			}
			return $this->output;
		}
		
		/*public function savePhoto3($caption, $fbid, $ctoken){
			try{
				set_time_limit(900);
				$conn = getConnection();
				$query = "INSERT INTO pre_entry (fbid, ctoken, photoname, entry_time, caption) VALUES (?, ?, ?, ?, ?)";
				$conn->execute($query,array($fbid,$ctoken,'',date("Y-m-d H:i:s"),$caption));
				$returnid = $conn->Insert_ID();
				$this->output["result"] = array("error"=>"0","message"=>"success","query"=>$query,"thumbpath"=>"","bigpath"=>"","photoID"=>$returnid,"flashsize"=>"0","filesize"=>"0");
			}catch(Exception $e){
				$this->output["result"] = array("error"=>"1","message"=>$e->getMessage());
			}
			return $this->output;
		}*/

		private function createthumbnail($path_to_image, $imagename, $thumbnail_width, $thumbnail_height, $destination_thumb){
			
			$keeping_ratio = true;
			//------------------------------------------------------------------------------------
			// Resize image
			//------------------------------------------------------------------------------------
			$image=new Resize_Image;
			
			$image->new_width=$thumbnail_width;
			$image->new_height=$thumbnail_height;
			
			// Full Path to the file
			$image->image_to_resize=$path_to_image;
			
			// Keep Aspect Ratio?
			$image->ratio=$keeping_ratio;
			
			// Name of the new image (optional) - If it's not set a new will be added automatically
			$image->new_image_name=$imagename;
			
			// Path where the new image should be saved. If it's not set the script will output the image without saving it 
			$image->save_folder=$destination_thumb; //should be something like upload/thumbnail/
			
			$process=$image->resize();
			
		
			if ($process['result'])
			{
				return true;
			}
			return false;
		}
}
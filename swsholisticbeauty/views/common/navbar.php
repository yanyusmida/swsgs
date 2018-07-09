        		<header id="header">
                <nav class="navbar navbar-default navbar-fixed-top">
                    <div class="container">
                        <div class="nav-con">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation" aria-expanded="false">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <img src="<?= $this->config->item('base_url') ?>images/logo.png" width="145" alt="Sulwhasoo" class="logo">
                            </div>
                            <div class="navbar-collapse collapse" id="navigation" aria-expanded="false">
                                <div class="nav navbar-nav navbar-right">
                                    <ul>
                                    <?php 
                                        // var_dump($view_data);
                                     ?>

                                     
                                        <li <?=($view_name == "about")? "class='current'":"";?>>
                                            <a href="<?= $this->config->item('base_url') ?>about">
                                                <img src="<?= $this->config->item('base_url') ?>images/icon-star.png" width="12" alt="">
                                                <span>About Us</span>
                                            </a>
                                        </li>
                                    
                                    <!-- 干掉preorder -->
                                    <?php if (1==2):?>
                                        <li <?=($view_name == "preorder")? "class='current'":"";?>>
                                            <a href="<?= $this->config->item('base_url') ?>preorder">
                                                <img src="<?= $this->config->item('base_url') ?>images/icon-star.png" width="12" alt="">
                                                <span>Pre-Order</span>
                                            </a>
                                        </li>
                                    <?php endif;?>

                                        <li <?=($view_name == "workshop")? "class='current'":"";?>>
                                            <a href="<?= $this->config->item('base_url') ?>workshop">
                                                <img src="<?= $this->config->item('base_url') ?>images/icon-star.png" width="12" alt="">
                                                <span>Activities</span>
                                            </a>
                                        </li>
                                        <?php	if(!empty($view_data['sampling'])){ ?>
                                        <li <?=($view_name == "sampling")? "class='current'":"";?>>
                                            <a href="<?= $this->config->item('base_url') ?>trialkit">
                                                <img src="images/icon-star.png" width="12" alt="">
                                                <span>Complimentary Trial Kit</span>
                                            </a>
                                        </li>
                                      <?php	}	?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
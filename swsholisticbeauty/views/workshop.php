                <div class="container">
                    <div class="page-dis text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="img-product">
                                        <img src="<?=$this->config->item('base_url');?>uploads/<?=$view_data['copies']['workshop_header_img'];?>" alt="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="pagedis-text">
                                        <h1><?=$view_data['copies']['workshop_header_title'];?></h1>
                                        <div>
                                        	<?=$view_data['copies']['workshop_header_text'];?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="workshop-list">
                    	<?php if(!empty($view_data['workshops'])){ ?>
												<?php foreach (array_reverse($view_data['workshops']) as $workshop) {	 ?> 
                            <?php if (isset($workshop) && $workshop['id'] == '10'): ?>
                                <div class="workshop-item">
                                    <div class="workshop-img" style="background-image:url(<?= $this->config->item('base_url') ?>uploads/<?=$workshop['banner_img'];?>)">
                                        <img src="<?= $this->config->item('base_url') ?>images/img-holder-01.png" alt="" class="hidden-xs">
                                        <img src="<?= $this->config->item('base_url') ?>images/img-holder-02.png" alt="" class="visible-xs">
                                    </div>
                                    <div class="workshop-caption">
                                        <div class="workshop-caption-con row">
                                            <div class="col-sm-10 col-sm-push-1">
                                                <h3 class="workshop-title"><?=$workshop['title'];?></h3>
                                                <div class="workshop-dis fontNoto"><?=$workshop['description'];?></div>
                                                <a href="<?= $this->config->item('base_url') ?>preorder" class="button btn-hollow ">Book Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                        <div class="workshop-item">
                            <div class="workshop-img" style="background-image:url(<?= $this->config->item('base_url') ?>uploads/<?=$workshop['banner_img'];?>)">
                                <img src="<?= $this->config->item('base_url') ?>images/img-holder-01.png" alt="" class="hidden-xs">
                                <img src="<?= $this->config->item('base_url') ?>images/img-holder-02.png" alt="" class="visible-xs">
                            </div>
                            <div class="workshop-caption">
                                <div class="workshop-caption-con row">
                                    <div class="col-sm-10 col-sm-push-1">
                                        <h3 class="workshop-title"><?=$workshop['title'];?></h3>
                                        <div class="workshop-dis fontNoto"><?=$workshop['description'];?></div>
                                        <a href="#" class="button btn-hollow btn-workshop-pop" data-workshop_id="<?=$workshop['id'];?>">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>

                        <?php	}	?>
                      <?php	}	?>
                    </div>
                </div>
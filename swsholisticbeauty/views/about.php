                <div class="container">
                    <div class="story-banner hidden-xs">
                        <div id="flipbook">
                            <div>
                                <img src="<?= $this->config->item('base_url') ?>images/banner-story-01.jpg" alt="">
                            </div>
                            <div>
                                <img src="<?= $this->config->item('base_url') ?>images/banner-story-01.jpg" alt="">
                            </div>
                            <div>
                                <div class="banner-disc">
                                    <div class="bnd-con">
                                        <h3 class="bold">Harmony of Human and Nature</h3>
                                        <p>Nature is our source and inspiration of true beauty and we are one with it.</p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <img src="<?= $this->config->item('base_url') ?>images/banner-story-02.jpg" alt="">
                            </div>
                            <div>
                                <div class="banner-disc">
                                    <div class="bnd-con">
                                        <h3 class="bold">Harmony and Balance</h3>
                                        <p>Sulwhasoo believes in harmonizing our natural beauty with ancient Asian wisdom to restore the delicate equilibrium between body and mind.</p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <img src="<?= $this->config->item('base_url') ?>images/banner-story-03.jpg" alt="" class="video-thum">
                                <div id="videothum"><img src="<?= $this->config->item('base_url') ?>images/img-holder-02.png" alt=""></div>
                                <div class="flipvideo" id="flipvideo" style="display:none">
                                    <div class="flipvideo-con">
                                        <div class="embed-responsive embed-responsive-4by3" id="storyvideo"></div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="banner-disc">
                                    <div class="bnd-con">
                                        <h3 class="bold">Holistic Beauty</h3>
                                        <p>True beauty flows from a clear and positive mind. Sulwhasoo pursues a holistic beauty that carefully treats our inner and outer beauty.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="story-banner story-banner-mobile visible-xs">
                        <!-- Swiper -->
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="<?= $this->config->item('base_url') ?>images/banner-story-01.jpg" alt="" class="img-responsive">
                                    <div class="banner-disc">
                                        <div class="bnd-con">
                                            <h3 class="bold">Harmony of Human and Nature</h3>
                                            <p>Nature is our source and inspiration of true beauty and we are one with it.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <img src="<?= $this->config->item('base_url') ?>images/banner-story-02.jpg" alt="" class="img-responsive">
                                    <div class="banner-disc">
                                        <div class="bnd-con">
                                            <h3 class="bold">Harmony and Balance</h3>
                                            <p>Sulwhasoo believes in harmonizing our natural beauty with ancient Asian wisdom to restore the delicate equilibrium between body and mind.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div style="position:relative">
                                        <img src="<?= $this->config->item('base_url') ?>images/banner-story-03.jpg" alt="" class="img-responsive">
                                        <div class="flipvideo" id="flipvideomobile" style="display:none">
                                            <div class="flipvideo-con">
                                                <div class="embed-responsive embed-responsive-4by3" id="storyvideomobile">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="banner-disc">
                                        <div class="bnd-con">
                                            <h3 class="bold">Holistic Beauty</h3>
                                            <p>True beauty flows from a clear and positive mind. Sulwhasoo pursues a holistic beauty that carefully treats our inner and outer beauty.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Add Pagination -->
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <!-- 故事发展 -->
                    <!-- <div class="story-timeline clearfix hidden-xs" id="timeline-wrapper">
                        <div class="timeline-axis">
                            <div class="icon-tla icon-tla-05 wow rubberBand" data-wow-delay="1s">
                                <img src="<?= $this->config->item('base_url') ?>images/icon-tl-today.png" alt="" id="icon-tla-05">
                            </div>
                            <div class="tla-line wow linedown" id="tla-line"></div>
                        </div>
                        <div class="timeline-left">
                            <div class="timeline-item tli-01">
                                <div class="trigger-item" id="trigger-tli-01"></div>
                                <div class="icon-tla icon-tla-01 wow rubberBand">
                                    <div class="trigger-icon" id="trigger-con-01"></div>
                                    <img src="<?= $this->config->item('base_url') ?>images/icon-tl-01.png" alt="" id="icon-tla-01">
                                </div>
                                <div class="overhidden">
                                    <div class="hidden-inner wow fadeInRight" id="tli-01">
                                        <div class="tl-time wow fadeInDown" data-wow-delay="0.6s" id="tl-time-01">
                                            <img src="<?= $this->config->item('base_url') ?>images/img-time-1966.png" alt="1966">
                                        </div>
                                        <div class="tl-disc">
                                            <img src="<?= $this->config->item('base_url') ?>images/img-timeline-01.jpg" width="160" alt="" class="img-tl-prod">
                                            <h4 class="tld-tit">ABC Ginseng Cream (1966): Origin of Sulwhasoo</h4>
                                            <p>Chairman and founder Suh Sung-Whan spent his childhood in Gaesung, a district where ginseng was commonly harvested. Growing up in such an environment, he was made aware of the valuable benefits of ginseng. His interest brought him to research further on the various cosmetic uses of ginseng and his commitment came to fruition with the release of the ABC Ginseng Cream in 1966.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item tli-03">
                                <div class="trigger-item" id="trigger-tli-03"></div>
                                <div class="icon-tla icon-tla-03 wow rubberBand" data-wow-delay="1s">
                                    <div class="trigger-icon" id="trigger-con-03"></div>
                                    <img src="<?= $this->config->item('base_url') ?>images/icon-tl-03.png" alt="" id="icon-tla-03">
                                </div>
                                <div class="overhidden">
                                    <div class="hidden-inner wow fadeInRight" data-wow-delay="1s" id="tli-03">
                                        <div class="tl-time wow fadeInDown" data-wow-delay="1.6s" id="tl-time-03">
                                            <img src="<?= $this->config->item('base_url') ?>images/img-time-1987.png" alt="1987">
                                        </div>
                                        <div class="tl-disc">
                                            <img src="<?= $this->config->item('base_url') ?>images/img-timeline-03.jpg" width="160" alt="" class="img-tl-prod">
                                            <h4 class="tld-tit">Sulwha (1987): Combining ginseng technologies with medicinal herb ingredients</h4>
                                            <p>The global success of ginseng-based cosmetic products prompted an expansion of the research to go beyond ginseng and to include other Asian botanical ingredients and beauty rituals. Sulwha (雪花) was created in 1987 with a focus on combining ginseng technologies with medicinal herb ingredients and acupuncture-inspired beauty rituals.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item tli-05">
                                <div class="trigger-item" id="trigger-tli-05"></div>
                                <div class="icon-tla icon-tla-03 wow rubberBand" data-wow-delay="1s">
                                    <div class="trigger-icon" id="trigger-con-03"></div>
                                    <img src="<?= $this->config->item('base_url') ?>images/icon-tl-05.png" alt="" id="icon-tla-03">
                                </div>
                                <div class="overhidden">
                                    <div class="hidden-inner wow fadeInRight" data-wow-delay="1s" id="tli-05">
                                        <div class="tl-time wow fadeInDown" data-wow-delay="1.6s" id="tl-time-05">
                                            <img src="<?= $this->config->item('base_url') ?>images/img-time-2016.png" alt="2016">
                                        </div>
                                        <div class="tl-disc">
                                            <img src="<?= $this->config->item('base_url') ?>images/img-timeline-05.jpg" width="160" alt="" class="img-tl-prod">
                                            <h4 class="tld-tit">Sulwhasoo (2016): Concentrated Ginseng Renewing Cream EX</h4>
                                            <p>In 2016, Sulwhasoo launched the upgraded version of its signature Concentrated Ginseng Renewing Cream EX. Applying Sulwhasoo's latest breakthroughs in ginseng research, the new Concentrated Ginseng Renewing Cream EX delivers anti-aging ingredients from ginseng root and ginseng flower deep into skin layers for Image Anti-Aging - Sulwhasoo's new standard for anti-aging which younger, softer complexion is achieved by firmer-looking skin from within around the face's aging indicators. </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-right">
                            <div class="timeline-item tli-02">
                                <div class="trigger-item" id="trigger-tli-02"></div>
                                <div class="icon-tla icon-tla-02 wow rubberBand" data-wow-delay="1s">
                                    <div class="trigger-icon" id="trigger-con-02"></div>
                                    <img src="<?= $this->config->item('base_url') ?>images/icon-tl-02.png" alt="" id="icon-tla-02">
                                </div>
                                <div class="overhidden">
                                    <div class="hidden-inner wow fadeInLeft" data-wow-delay="1s" id="tli-02">
                                        <div class="tl-time wow fadeInDown" data-wow-delay="1.6s" id="tl-time-02">
                                            <img src="<?= $this->config->item('base_url') ?>images/img-time-1973.png" alt="1973">
                                        </div>
                                        <div class="tl-disc">
                                            <img src="<?= $this->config->item('base_url') ?>images/img-timeline-02.jpg" width="160" alt="" class="img-tl-prod">
                                            <h4 class="tld-tit">Ginseng SAMMI (1973): Introducing the world to the efficacy of ginseng-based cosmetics</h4>
                                            <p>Continuous innovation and research led to the discovery of saponin extraction from ginseng leaves and flowers. This culminated in the birth of the ginseng saponin based product, Ginseng SAMMI in 1973. The release of Ginseng SAMMI marked the first phase of Sulwhasoo. Since its first export to Hawaii in September 1973, Ginseng SAMMI has since extended its market reach to Japan, Canada, Europe, South America and the Middle East.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item tli-04">
                                <div class="trigger-item" id="trigger-tli-04"></div>
                                <div class="icon-tla icon-tla-04 wow rubberBand" data-wow-delay="1s">
                                    <div class="trigger-icon" id="trigger-con-04"></div>
                                    <img src="<?= $this->config->item('base_url') ?>images/icon-tl-04.png" alt="" id="icon-tla-04">
                                </div>
                                <div class="overhidden">
                                    <div class="hidden-inner wow fadeInLeft" data-wow-delay="1s" id="tli-04">
                                        <div class="tl-time wow fadeInDown" data-wow-delay="1.6s" id="tl-time-04">
                                            <img src="<?= $this->config->item('base_url') ?>images/img-time-1997.png" alt="1997">
                                        </div>
                                        <div class="tl-disc">
                                            <img src="<?= $this->config->item('base_url') ?>images/img-timeline-04.jpg" width="160" alt="" class="img-tl-prod">
                                            <h4 class="tld-tit">Sulwhasoo (1997): Essence of Asian Beauty</h4>
                                            <p>In 1997, the brand name Sulwhasoo was completed by adding "soo (excellent)” to its predecessor’s name Sulwha.Sulwhasoo continued to innovate and their next phase drew on examples from the Korean medical classic Donguibogam. Sulwhasoo looked into the efficacy of natural ingredients and processing methods with the goal in mind to create products with synergized ingredients. Sulwhasoo’s efforts eventually led to the creation of their unique formula, JAUM Balancing Complex
                                                <sup>™</sup>.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="story-timeline story-timeline-mobile visible-xs">
                        <div class="timeline-axis">
                            <div class="icon-tla icon-tla-05 wow rubberBand" data-wow-delay="1s">
                                <div class="trigger-icon" id="trigger-con-05"></div>
                                <img src="<?= $this->config->item('base_url') ?>images/icon-tl-today.png" alt="" id="icon-tla-05">
                            </div>
                            <div class="tla-line wow linedown" id="tla-line"></div>
                        </div>
                        <div class="timeline-item tli-01">
                            <div class="trigger-item" id="trigger-tli-01"></div>
                            <div class="icon-tla icon-tla-01 wow rubberBand">
                                <img src="<?= $this->config->item('base_url') ?>images/icon-tl-01.png" alt="" id="icon-tla-01">
                            </div>
                            <div class="overhidden">
                                <div class="hidden-inner wow fadeInLeft" id="tli-01">
                                    <div class="tl-time wow fadeInDown" data-wow-delay="0.6s" id="tl-time-01">
                                        <img src="<?= $this->config->item('base_url') ?>images/img-time-1966.png" alt="1966">
                                    </div>
                                    <div class="tl-disc">
                                        <img src="<?= $this->config->item('base_url') ?>images/img-timeline-01.jpg" width="160" alt="" class="img-tl-prod">
                                        <h4 class="tld-tit">ABC Ginseng Cream (1966): Origin of Sulwhasoo</h4>
                                        <p>Chairman and founder Suh Sung-Whan spent his childhood in Gaesung, a district where ginseng was commonly harvested. Growing up in such an environment, he was made aware of the valuable benefits of ginseng. His interest brought him to research further on the various cosmetic uses of ginseng and his commitment came to fruition with the release of the ABC Ginseng Cream in 1966.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item tli-02">
                            <div class="trigger-item" id="trigger-tli-02"></div>
                            <div class="icon-tla icon-tla-02 wow rubberBand">
                                <img src="<?= $this->config->item('base_url') ?>images/icon-tl-02.png" alt="" id="icon-tla-02">
                            </div>
                            <div class="overhidden">
                                <div class="hidden-inner wow fadeInLeft" data-wow-delay="1s" id="tli-02">
                                    <div class="tl-time wow fadeInDown" data-wow-delay="1.6s" id="tl-time-02">
                                        <img src="<?= $this->config->item('base_url') ?>images/img-time-1973.png" alt="1973">
                                    </div>
                                    <div class="tl-disc">
                                        <img src="<?= $this->config->item('base_url') ?>images/img-timeline-02.jpg" width="160" alt="" class="img-tl-prod">
                                        <h4 class="tld-tit">Ginseng SAMMI (1973): Introducing the world to the efficacy of ginseng-based cosmetics</h4>
                                        <p>Continuous innovation and research led to the discovery of saponin extraction from ginseng leaves and flowers. This culminated in the birth of the ginseng saponin based product, Ginseng SAMMI in 1973. The release of Ginseng SAMMI marked the first phase of Sulwhasoo. Since its first export to Hawaii in September 1973, Ginseng SAMMI has since extended its market reach to Japan, Canada, Europe, South America and the Middle East.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item tli-03">
                            <div class="trigger-item" id="trigger-tli-03"></div>
                            <div class="icon-tla icon-tla-03 wow rubberBand">
                                <img src="<?= $this->config->item('base_url') ?>images/icon-tl-03.png" alt="" id="icon-tla-03">
                            </div>
                            <div class="overhidden">
                                <div class="hidden-inner wow fadeInLeft" data-wow-delay="1s" id="tli-03">
                                    <div class="tl-time wow fadeInDown" data-wow-delay="1.6s" id="tl-time-03">
                                        <img src="<?= $this->config->item('base_url') ?>images/img-time-1987.png" alt="1987">
                                    </div>
                                    <div class="tl-disc">
                                        <img src="<?= $this->config->item('base_url') ?>images/img-timeline-03.jpg" width="160" alt="" class="img-tl-prod">
                                        <h4 class="tld-tit">Sulwha (1987): Combining ginseng technologies with medicinal herb ingredients</h4>
                                        <p>The global success of ginseng-based cosmetic products prompted an expansion of the research to go beyond ginseng and to include other Asian botanical ingredients and beauty rituals. Sulwha (雪花) was created in 1987 with a focus on combining ginseng technologies with medicinal herb ingredients and acupuncture-inspired beauty rituals.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item tli-04">
                            <div class="trigger-item" id="trigger-tli-04"></div>
                            <div class="icon-tla icon-tla-04 wow rubberBand">
                                <div class="trigger-icon" id="trigger-con-04"></div>
                                <img src="<?= $this->config->item('base_url') ?>images/icon-tl-04.png" alt="" id="icon-tla-04">
                            </div>
                            <div class="overhidden">
                                <div class="hidden-inner wow fadeInLeft" data-wow-delay="1s" id="tli-04">
                                    <div class="tl-time wow fadeInDown" data-wow-delay="1.6s" id="tl-time-04">
                                        <img src="<?= $this->config->item('base_url') ?>images/img-time-1997.png" alt="1997">
                                    </div>
                                    <div class="tl-disc">
                                        <img src="<?= $this->config->item('base_url') ?>images/img-timeline-04.jpg" width="160" alt="" class="img-tl-prod">
                                        <h4 class="tld-tit">Sulwhasoo (1997): Essence of Asian Beauty</h4>
                                        <p>In 1997, the brand name Sulwhasoo was completed by adding "soo (excellent)” to its predecessor’s name Sulwha.Sulwhasoo continued to innovate and their next phase drew on examples from the Korean medical classic Donguibogam. Sulwhasoo looked into the efficacy of natural ingredients and processing methods with the goal in mind to create products with synergized ingredients. Sulwhasoo’s efforts eventually led to the creation of their unique formula, JAUM Balancing Complex
                                            <sup>™</sup>.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item tli-05">
                            <div class="trigger-item" id="trigger-tli-05"></div>
                            <div class="icon-tla icon-tla-03 wow rubberBand" data-wow-delay="1s">
                                <div class="trigger-icon" id="trigger-con-03"></div>
                                <img src="<?= $this->config->item('base_url') ?>images/icon-tl-05.png" alt="" id="icon-tla-03">
                            </div>
                            <div class="overhidden">
                                <div class="hidden-inner wow fadeInLeft" data-wow-delay="1s" id="tli-05">
                                    <div class="tl-time wow fadeInDown" data-wow-delay="1.6s" id="tl-time-05">
                                        <img src="<?= $this->config->item('base_url') ?>images/img-time-2016.png" alt="2016">
                                    </div>
                                    <div class="tl-disc">
                                        <img src="<?= $this->config->item('base_url') ?>images/img-timeline-05.jpg" width="160" alt="" class="img-tl-prod">
                                        <h4 class="tld-tit">Sulwhasoo (2016): Concentrated Ginseng Renewing Cream EX</h4>
                                        <p>In 2016, Sulwhasoo launched the upgraded version of its signature Concentrated Ginseng Renewing Cream EX. Applying Sulwhasoo's latest breakthroughs in ginseng research, the new Concentrated Ginseng Renewing Cream EX delivers anti-aging ingredients from ginseng root and ginseng flower deep into skin layers for Image Anti-Aging - Sulwhasoo's new standard for anti-aging which younger, softer complexion is achieved by firmer-looking skin from within around the face's aging indicators. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <style type="text/css">
                        .box_span{
                            /*border: 1px solid #000;*/
                            width: 80%;
                            margin: 80px auto;
                            text-align: center;
                        }
                    </style>
                    <div class="box_span">
                        <span>Sulwhasoo’s pursuit of true beauty is a journey that begins with Asian wisdom, embodying the harmony and equilibrium with nature. Sulwhasoo has a longstanding commitment to ginseng research and technology development since the release of ABC Ginseng Cream in 1966. With its relentless passion for Asian wisdom and unwavering commitment to skin research, Sulwhasoo continues to acquire wisdom from the laws of nature, refines beauty with the precious ingredients of nature to pursue the beauty that present the beauty from the balance of inside and outside. 
                        </span>
                    </div>
                    <!-- <div class="row today-disc fz14 wow fadeInUp" data-wow-delay="1s"></div> -->
                    <?php	if(!empty($view_data['sampling'])){ ?>
                    <!-- <div class="today-signup">
                        <img src="<?= $this->config->item('base_url') ?>uploads/<?=$view_data['sampling']['banner_img'];?>" alt="" class="wow fadeIn">
                        <div class="tsu-content">
                            <div>
                                <p class="wow fadeInDown" data-wow-delay=".1s"><?=$view_data['sampling']['description'];?></p>
                                <p class="wow fadeInDown" data-wow-delay=".2s"><small><?=$view_data['sampling']['sub_description'];?></small></p>
                                <a href="<?= $this->config->item('base_url') ?>preorder" class="button btn-hollow wow fadeInUp" data-wow-delay=".3s">Sign Up</a>
                            </div>
                        </div>
                    </div> -->
                  	<?php	}	?>
                    <div class="gensing-research wow fadeIn">
                        <!-- Swiper -->
                        <div class="swiper-container gallery-thumbs">
                            <!-- Add Arrows -->
                            <div class="swiper-button-next swiper-button-white"></div>
                            <div class="swiper-button-prev swiper-button-white"></div>
                            <div class="swiper-wrapper">
                                <div class="swiper-slide" style="background-image:url(<?= $this->config->item('base_url') ?>images/thum-today-01.jpg)"></div>
                                <div class="swiper-slide" style="background-image:url(<?= $this->config->item('base_url') ?>images/thum-today-02.jpg)"></div>
                                <div class="swiper-slide" style="background-image:url(<?= $this->config->item('base_url') ?>images/thum-today-03.jpg)"></div>
                                <div class="swiper-slide" style="background-image:url(<?= $this->config->item('base_url') ?>images/thum-today-04.jpg)"></div>
                            </div>
                        </div>
                        <div class="swiper-container gallery-top">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="gsresearch-disc">
                                        <div class="row">
                                            <div class="col-sm-8 col-sm-push-2">
                                                <h3 class="text-center bold">Sulwhasoo brings you Ginsenomics™, the culmination of 50 years of ginseng research.</h3>
                                            </div>
                                        </div>
                                        <p class="text-center">Ginsenomics™ is Sulwhasoo’s brand of extensive research in ginseng. Since the release of the ABC Ginseng Cream in 1966, Sulwhasoo has strived to continuously innovate the various cosmetic uses of ginseng. By researching how the whole ginseng plant can be used to deliver better results for our skin, no part of the ginseng plant is ever wasted. Ginsenomics™ symbolizes Sulwhasoo’s relentless passion for Asian wisdom and unwavering commitment to skin research.</p>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="gsresearch-disc">
                                        <div class="row">
                                            <div class="col-sm-8 col-sm-push-2">
                                                <h3 class="text-center bold">Ginseng roots: Ginseng-derived active ingredients with anti-aging and whitening effects.</h3>
                                            </div>
                                        </div>
                                        <p class="text-center">Sulwhasoo's research on ginseng roots led to the discovery of rare saponin and its efficacy on the skin. Sulwhasoo also successfully developed a proprietary technology to deliver anti-aging and whitening active ingredients in an optimal state to the deeper layers of the skin. </p>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="gsresearch-disc">
                                        <div class="row">
                                            <div class="col-sm-8 col-sm-push-2">
                                                <h3 class="text-center bold">Ginseng leaf and stem: Skin protection by restoring skin elasticity.</h3>
                                            </div>
                                        </div>
                                        <p class="text-center">Ginseng leaves and stems contain active ingredients that shield the skin from external aggressors. The introduction of water culture systems in a high-tech greenhouse has enhanced the concentration of rare saponin in ginseng leaves and stems.</p>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="gsresearch-disc">
                                        <div class="row">
                                            <div class="col-sm-8 col-sm-push-2">
                                                <h3 class="text-center bold">Ginseng flower and fruit: Enhanced skin defense system.</h3>
                                            </div>
                                        </div>
                                        <p class="text-center">Ginsenoside Re is derived from ginseng flowers and fruits. The ginseng flower blooms when it is grown in fertile soil with attentive care of farmers for four years. Ginsenoside Re enhances the skin's defense system in synergy with active ingredients in ginseng roots. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <script type="text/javascript">
        var player;
        var isVideoPlaying;

        function onYouTubeIframeAPIReady() {
            //console.log('onYouTubeIframeAPIReady');

        }

        function onPlayerReady(event) {
            //console.log(event.data);
            event.target.playVideo();
        }

        function onPlayerStateChange(event) {
            //console.log(1, event.data);
            if (event.data == YT.PlayerState.PAUSED) {
                isVideoPlaying = false;
                $("#flipvideo").hide();
                $("#flipvideomobile").hide();
            }
        }

        $('#videothum').on('click', function () {
            $("#flipvideo").show();
            //console.log('videothum');
            isVideoPlaying = true;
            //player.playVideo();
            $("#flipvideo").show();
            if (!player) {
                player = new YT.Player('sulwhasoovideo', {
                    height: '315',
                    width: '560',
                    videoId: '2i-V7CfeIyk',
                    playerVars: {
                        'autoplay': 0,
                        'controls': 0,
                        'rel': 0,
                        'showinfo': 0
                    },
                    events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                    }
                });

            } else {
                player.playVideo();
            }


        });


        $(function () {


            function loadApp() {
                var isMouseover = false;
                var isAutoPlay = false;
                var nextInter = null;
                var prevInter = null;

                var videoObj = '';
                $("#flipbook").turn({
                    width: 1200,
                    height: 475,
                    page: 2,
                    elevation: 50,
                    autoCenter: true,
                    duration: 2100,
                    when: {
                        turning: function (event, page, pageObject) {
                            if (page == 1) {
                                event.preventDefault();
                                clearInterval(nextInter);
                                clearInterval(prevInter);
                                nextInter = setInterval(function () {
                                    if (isMouseover || isVideoPlaying) {
                                        return;
                                    }
                                    isAutoPlay = true;
                                    $("#flipbook").turn("next");
                                }, 5500);
                            }
                        },
                        turned: function (event, page, view) {
                            if (page == 4 || page == 5) {
                                player = null;
                                $('#storyvideo').html('<div id="sulwhasoovideo"></div>');
                            }
                            switch (page) {
                            case 2:
                            case 3:
                                $('.bnd-con').removeClass('animate');
                                $('.p3 .bnd-con').addClass('animate');
                                break;
                            case 4:
                            case 5:
                                $('.bnd-con').removeClass('animate');
                                $('.p5 .bnd-con').addClass('animate');
                                break;
                            case 6:
                                $('.bnd-con').removeClass('animate');
                                $('.p7 .bnd-con').addClass('animate');
                                break;
                            }
                        }
                    }
                });
                nextInter = setInterval(function () {
                    // return;
                    if (isMouseover || isVideoPlaying) {
                        return;
                    }
                    isAutoPlay = true;
                    $("#flipbook").turn("next");
                }, 5500);
                $("#flipbook").bind("last", function (event) {
                    clearInterval(nextInter);
                    clearInterval(prevInter);
                    prevInter = setInterval(function () {
                        if (isMouseover || isVideoPlaying) {
                            return;
                        }
                        isAutoPlay = true;
                        $("#flipbook").turn("previous");
                    }, 5500);
                });

                $('#flipbook').on('mouseenter', function () {
                    isMouseover = true;
                }).on('mouseleave', function () {
                    isMouseover = false;
                });
            }
            if (document.documentElement.clientWidth > 767) {
                /*desktop======*/

                resBanner();
                yepnope({
                    test: Modernizr.csstransforms,
                    yep: ['<?= $this->config->item('base_url') ?>scripts/flipbook/turn.min.js'],
                    nope: ['<?= $this->config->item('base_url') ?>scripts/flipbook/turn.html4.min.js'],
                    complete: loadApp
                });

                /*gensing research*/
                var galleryTop = new Swiper('.gensing-research .gallery-top', {
                    nextButton: '.swiper-button-next',
                    prevButton: '.swiper-button-prev',
                    spaceBetween: 10,
                    effect: 'fade'
                });
                var galleryThumbs = new Swiper('.gensing-research .gallery-thumbs', {
                    spaceBetween: 10,
                    centeredSlides: true,
                    slidesPerView: 'auto',
                    touchRatio: 0.2,
                    slideToClickedSlide: true
                });
                galleryTop.params.control = galleryThumbs;
                galleryThumbs.params.control = galleryTop;


            } else {
                /*mobile=====*/

                var storySwiper = new Swiper('.story-banner-mobile .swiper-container', {
                    pagination: '.story-banner-mobile .swiper-pagination',
                    paginationClickable: true,
                    onSlideChangeEnd: function (swiper) {
                        if (swiper.activeIndex == 2) {
                            isVideoPlaying = true;
                            //player.playVideo();
                            $("#flipvideomobile").show();
                            if (!player) {
                                player = new YT.Player('sulwhasoovideomobile', {
                                    height: '315',
                                    width: '560',
                                    videoId: '2i-V7CfeIyk',
                                    playerVars: {
                                        'rel': 0,
                                        'showinfo': 0
                                    },
                                    events: {
                                        'onReady': onPlayerReady,
                                        'onStateChange': onPlayerStateChange
                                    }
                                });

                            } else {
                                player.playVideo();
                            }
                        } else {
                            player = null;
                            $('#storyvideomobile').html('<div id="sulwhasoovideomobile"></div>');
                        }
                    }
                });


                /*gensing research*/
                var galleryTop = new Swiper('.gensing-research .gallery-top', {
                    nextButton: '.swiper-button-next',
                    prevButton: '.swiper-button-prev',
                    spaceBetween: 10,
                    effect: 'slide'
                });
                var galleryThumbs = new Swiper('.gensing-research .gallery-thumbs', {
                    spaceBetween: 50,
                    centeredSlides: true,
                    slidesPerView: 1,
                    touchRatio: 0.2,
                    slideToClickedSlide: true
                });
                galleryTop.params.control = galleryThumbs;
                galleryThumbs.params.control = galleryTop;

                /*gensing product*/
                var gspSwiper = new Swiper('.gensing-product .swiper-container', {
                    nextButton: '.gensing-product .swiper-button-next',
                    prevButton: '.gensing-product .swiper-button-prev',
                    spaceBetween: 30
                });
            }




            /*banner responsive*/
            $(window).resize(function () {
                if (document.documentElement.clientWidth > 767) {
                    resBanner();
                }
            })


        })

        function resBanner() {
            if (document.documentElement.clientWidth < 1200) {
                var windowWidth = document.body.clientWidth;
                var proportion = 1200 / 475;
                var scale = windowWidth / 1200;
                $('.story-banner').width(windowWidth);
                $('.story-banner').height(windowWidth / proportion);

                $("#flipbook").css({
                    'transform': 'scale(' + scale + ')',
                    '-webkit-transform': 'scale(' + scale + ')',
                    '-moz-transform': 'scale(' + scale + ')',
                    'transform-origin': '0 0',
                    '-webkit-transform-origin': '0 0',
                    '-moz-transform-origin': '0 0'
                });
            } else {
                $('.story-banner').width('auto');
                $('.story-banner').height('auto');
                $("#flipbook").css({
                    'transform': 'none',
                    '-webkit-transform': 'none',
                    '-moz-transform': 'none'
                });
            }
        }
    </script>
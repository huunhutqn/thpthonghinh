<!DOCTYPE html>
<html <?php language_attributes(); ?> >
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" >
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab|Roboto|Yanone+Kaffeesatz" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
        
        <!-- nếu là page hay single như phía dưới sẽ -->
        <?php if (is_page(array('tai-lieu', 'tim-kiem', 'search' )) || is_search() || is_category()) : ?>
        <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jsmain.js"></script>
        <?php endif; ?>
        <?php if (is_single()) : ?>
        <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jsmainsg.js"></script>
        <?php endif; ?>

    </head>

    <body <?php body_class(); ?> > <!--them class tuong trung len body de tuy bien-->
        <!-- <div id="timkiem">
            
        </div> -->
        <!-- <form role="search" method="get" id="searchform" class="searchform" action="http://localhost:1010/caocao/">
                <div>
                    <label class="screen-reader-text" for="s">Search for:</label>
                    <input type="text" value="tkb" name="s" id="s">
                    <input type="submit" id="searchsubmit" value="Search">
                </div>
            </form> -->
     <div id="mySidenav" class="sidenav"><form action="<?php echo get_home_url(); ?>" role="search" id="searchform" method="get">
                    <div id="search-nav"> <img id="search-nav-img" src="<?php echo get_template_directory_uri().'/images/'; ?>magnifying-glass.png"><input required="" type="text" name="s" id="s" placeholder="Tìm kiếm..."></input><button id="search-nav-button" type="submit" form="searchform">Tìm</button></div></form>
                </div>
    <div id="container">
       
        <!-- top: chứa thanh trên cùng và menu -->
        <navautohide>
        <div id="top">
            <div id="top_bar">
                
                
                <div id="top-tell">
                    <span class="txt-top" style="padding-right: 10px">Liên hệ với chúng tôi</span>
                    <i class="fa fa-phone">
                </i>
                    <!-- <img class="img-top" src="<?php echo get_template_directory_uri().'/images/'; ?>telephone-symbol-button.png"> -->

                    <span class="txt-top"><a href="tel:+84123456789">(0123) 456789</a></span>
                </div>
                <div id="top-mail">
                    <i class="fa fa-envelope"></i>
                    <!-- <img class="img-top" src="<?php echo get_template_directory_uri().'/images/'; ?>envelope.png"> -->
                    
                    <span class="txt-top"><a href="mailto:honghinhmail@gmail.com" target="_top">honghinhmail@gmail.com</a></span>
                    <i class="fa fa-facebook-square" style="padding-left: 10px"></i>
                    <i class="fa fa-google-plus-square"></i>
                    <i class="fa fa-youtube"></i>
                </div>
                <div id="top-search">
                    <!-- <img class="img-top" src="<?php echo get_template_directory_uri().'/images/'; ?>magnifying-glass.png"> -->
                    <!-- <div id="" style="width: 20px; background: #fff; border-radius: 7px 0 0 7px; display: inline; color: #aaaaaa; font-family: 'Roboto'; font-size: 13px; font-weight: 550;padding-left: 5px;padding-right: 5px; padding-top: 2px; padding-bottom: 2px;">Tìm kiếm</div>
                    <i class="fa fa-search"></i> -->
                </div>
                <div id="top-social">
                    <!-- <img class="img-top" src="<?php echo get_template_directory_uri().'/images/'; ?>facebook-logo-1.png">
                    <img class="img-top" src="<?php echo get_template_directory_uri().'/images/'; ?>google-plus-symbol.png">
                    <img class="img-top" src="<?php echo get_template_directory_uri().'/images/'; ?>youtube-logo-1.png"> -->
                </div>
                <?php if (is_user_logged_in()) {
                    ?>
                    <!-- code html here -->
                    <div id="top-login">
                        <span class="txt-top"><a href="<?php echo get_home_url().'/wp-admin/index.php'; ?>">Chào
                        <?php $current_user = wp_get_current_user();
                            echo $current_user->display_name;
                         ?>,</span></a>
                        
                        <span class="txt-top"><a href="<?php echo wp_logout_url(get_permalink()); ?>">Đăng xuất</a></span><i class="fa fa-sign-out" style="padding-left: 5px;"></i>
                    </div> 
                    <?php
                } else { ?>
                <!-- code html here -->
                <div id="top-login">
                        <i class="fa fa-sign-in"></i>
                        <span class="txt-top"><a href="
                            <?php 
                                global $wp;  
$current_url = home_url(add_query_arg(array(),$wp->request));
                            echo get_home_url().'/wp-login.php?redirect_to='.$current_url;
                             ?>
                            ">Đăng nhập</a></span>
                    </div>
<?php } ?>
                
                
            </div>
            <div id="menu_top">
                <div id="menu-logo">
                    <img class="img-menu" src="<?php echo get_template_directory_uri().'/images/'; ?>logotrans.png">
                    <div id="txt-logo">CỔNG THÔNG TIN ĐIỆN TỬ<br>TRƯỜNG THPT <span style="font-weight: bold;">HỒ NGHINH</span></div>
                </div>
                <div id="menu">
                      <ul>
                        <li><a href="<?php echo get_home_url(); ?>">TRANG CHỦ</a></li>
                        <li><a href="<?php echo get_home_url().'/gioi-thieu';?>">GIỚI THIỆU</a></li>
                        <li><a href="#">TIN TỨC <i class="fa fa-caret-down"></i></a>
                          <ul class="sub-menu">
                            <li><a class="dropbtn" style="padding-top: 0px; padding-bottom: 0px;" href="<?php echo get_home_url().'/category/tintuc/'; ?>">BẢN TIN TRƯỜNG</a></li>
                            <li><a class="dropbtn" style="padding-top: 0px; padding-bottom: 0px;" href="<?php echo get_home_url().'/category/thongbao/'; ?>">THÔNG BÁO</a></li>
                          </ul>
                        </li>
                        <li class="dropdown"><a href="#">ĐÀO TẠO <i class="fa fa-caret-down"></i></a>
                          <ul class="sub-menu">
                            <!-- tạm thời bỏ phần dưới vì không có nhu cầu -->
                            <!-- <li><a class="dropbtn" style="padding-top: 0px; padding-bottom: 0px;" href="#">MÔN TỰ NHIÊN</a></li>
                            <li><a class="dropbtn" style="padding-top: 0px; padding-bottom: 0px;" href="#">MÔN XÃ HỘI</a></li> -->
                            <li><a class="dropbtn" style="padding-top: 0px; padding-bottom: 0px;" href="<?php echo get_home_url().'/wp-content/uploads/tkb'; ?>">THỜI KHÓA BIỂU</a></li>
                            <li><a class="dropbtn" style="padding-top: 0px; padding-bottom: 0px;" href="<?php echo get_home_url().'/tai-lieu'; ?>">TÀI LIỆU</a></li>
                          </ul>
                        </li>
                        <!-- <li><a href="#">HÀNH CHÍNH<i class="fa fa-caret-down"></i></a>
                          <ul class="sub-menu">
                            <li><a class="dropbtn" style="padding-top: 0px; padding-bottom: 0px;" href="#">VĂN BẢN</a></li>
                            <li><a class="dropbtn" style="padding-top: 0px; padding-bottom: 0px;" href="#">LỊCH CÔNG TÁC</a></li>
                          </ul>
                        </li> -->
                        <li><a href="#">ĐOÀN THỂ <i class="fa fa-caret-down"></i></a>
                          <ul class="sub-menu">
                            <li><a class="dropbtn" style="padding-top: 0px; padding-bottom: 0px;" href="<?php 
                            echo get_home_url().'/category/tintuc/cong-doan/';
                             ?>">CÔNG ĐOÀN</a></li>
                            <li><a class="dropbtn" style="padding-top: 0px; padding-bottom: 0px;" href="<?php 
                            echo get_home_url().'/category/tintuc/doan-tn/';
                             ?>">ĐOÀN THANH NIÊN</a></li>
                          </ul>
                        </li>
                        <li><a href="<?php echo get_home_url().'/lien-he/'; ?>">LIÊN HỆ</a></li>
                      </ul>
                    </div>
                <!-- <div id="menu-nav">
                    <ul id="nav">
                       
                        <li><a href="#">TRANG CHỦ</a></li>
                        <li><a href="#">GIỚI THIỆU</a></li>
                        <li class="dropdown">
                            <a class="dropbtn" href="#">TIN TỨC</a>
                            <div class="dropdown-content">
                                <a href="#">BẢN TIN TRƯỜNG</a>
                                <a href="#">THÔNG BÁO</a>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a class="dropbtn" href="javascript:void(0)">ĐÀO TẠO</a>
                            <div class="dropdown-content">
                                <a href="#">MÔN TỰ NHIÊN</a>
                                <a href="#">MÔN XÃ HỘI</a>
                                <a href="#">THỜI KHÓA BIỂU</a>
                                <a href="#">TÀI LIỆU</a>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a class="dropbtn" href="javascript:void(0)">HÀNH CHÍNH</a>
                            <div class="dropdown-content">
                                <a href="#">VĂN BẢN</a>
                                <a href="#">LỊCH CÔNG TÁC</a>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a class="dropbtn" href="javascript:void(0)">ĐOÀN THỂ</a>
                            <div class="dropdown-content">
                                <a href="#">CÔNG ĐOÀN</a>
                                <a href="#">ĐOÀN THANH NIÊN</a>
                            </div>
                        </li>
                        <li><a href="#">LIÊN HỆ</a></li>
                    </ul>
                </div> -->
            </div>
            
        </div></navautohide>
        <!-- load slider giới thiệu ra -->
        <div id="slider">
            <?php
                    echo do_shortcode('[smartslider3 slider=3]');
            ?>
            <!-- <?php /*include(TEMPLATEPATH.'/slider.php');*/ ?> -->
        </div>
        <!-- <div id="header"> -->
        <!-- <?php honghinh_logo() ?> -->
        <!-- <?php honghinh_menu('primary_menu') ?> -->
        <!-- </div> -->
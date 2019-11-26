
<!-- đóng thẻ div container -->
</div>
<div id="footer">
    <div id="footer-container">
        <!-- ý tưởng, chia footer thành 3 cột, cột 1 chứa thông tin đơn vị, cột 2 chưa thông tin liên hệ, cột 3 chứa menu nhanh sitemap -->
    <div id="foo">
    <div id="footer-left">
        <div id="footer-left-com">
        <img class="footer-left-logo" src="<?php echo get_template_directory_uri().'/images/'; ?>logotrans.png"> 
        <br>
        <span class="footer-left-name">Trường THPT <b>Hồ Nghinh</b></span>
        <br><br>
        <div><i class="fa fa-map-marker"></i><span><b>Địa chỉ</b><br>123 Nguyễn Hoàng, xã Duy Thành, huyện Duy Xuyên, tỉnh Quảng Nam</span><br><br><i class="fa fa-phone"></i><span><b>Điện thoại</b></span><br>Ban giám hiệu: (0123) 456789<br>Ban giám thị: (0123) 121212<br><br><i class="fa fa-envelope"></i><span><b>Email</b></span><br><a href="mailto:honghinhmail@gmail.com" target="_top">honghinhmail@gmail.com</a></div>
        </div>
    </div>
    <div id="footer-mid">
        <div></div>
    </div> 
    <div id="footer-right">
        <div><i class="fa fa-sitemap"></i><span><b>LỐI TẮT</b></span><br><div class="sitemap-title"><span><a href="<?php echo get_home_url(); ?>">Trang chủ</a></span><br><span><a href="<?php echo get_home_url(); ?>/category/tintuc">Tin tức</a></span><br><span><a href="<?php echo get_home_url(); ?>/category/thongbao">Thông báo</a></span><br><span><a href="<?php echo get_home_url(); ?>/gioi-thieu">Giới thiệu</a></span><br><span><a href="">Liên hệ</a></span><br></div><br>
        <i class="fa fa-facebook-square"></i><i class="fa fa-google-plus-square"></i><i class="fa fa-twitter-square"></i>
        </div>
    </div> 
     </div>

    <div class="copyright">
        © <?php echo date('Y'); ?> <?php bloginfo('sitename'); ?>
    </div>
    </div>
</div>

<?php wp_footer(); ?>
<script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
<i class="fa fa-arrow-circle-up" onclick="topFunction()" id="toTop"><br><span><!-- VỀ ĐẦU TRANG --></span></i>

<!-- đóng thẻ body -->
</body>
<!-- đóng thẻ html -->
</html>

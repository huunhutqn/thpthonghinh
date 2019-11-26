<!-- ý tưởng cho phần tiện ích:
    <bên trái>
    -banner sự kiện
    -các lối tắt tiện ích
    -phần giới thiệu ngắn về trường
    -phần giới thiệu ngắn về tiểu sử nhân vật lịch sử

    <bên phải>
    -marque hội khuyến học: đặt cate là khuyến học, mỗi post là 1 năm học, khi có mới sẽ update vào, bên trong sẽ có table, mỗi đơn vị hỗ trợ nằm trên 1 hàng. chỉ hiển thị 1 post mới nhất
    -lối tắt tới fanpage
    -thống kê lượt truy cập fanpage hiện tại và đã
 -->
<div id="tienich">
    <!-- banner sự kiện rộng width 62% 728x210 bằng box news, cao -->
    <div id="tienich-banner">
        <?php
                echo do_shortcode('[smartslider3 slider=4]');
        ?>
    </div>
    <div id="tienich-fb">
        <!-- bị lỗi, chưua thiết lập được cho page của riêng mình -->
        <div id="fb-root"></div>
 
  <!-- <script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-page" data-href="https://www.facebook.com/SaoNamConfessions/" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/SaoNamConfessions/"><a href="https://www.facebook.com/SaoNamConfessions/">Trường THPT Hồ Nghinh</a></blockquote></div></div> -->
    </div>
    <div id="tienich-option">
        <div id="tienich-lable">
                <div id="tienich-lablenamebox">
                    <span id="tienich-lablename">TIỆN ÍCH</span>
                </div>

                <div id="tienich-lableline"> </div>

        </div>

        <div id="tienich-option-box">
            <a href="<?php echo get_home_url().'/wp-content/uploads/tkb';?>"><img class="tienich-option-tkb" src="<?php echo get_template_directory_uri().'/images/'; ?>tien-ich-tkb.png"></a>

            <a href="
            <?php
                echo get_home_url().'/tai-lieu';
                ?>
             "><img class="tienich-option-tailieu" src="<?php echo get_template_directory_uri().'/images/'; ?>tien-ich-tailieu.png"></a>
            
        </div>
        
        
    </div>
    <div id="tienich-gioithieu">
            <div id="tienich-gioithieu-lable">
                <div id="tienich-gioithieu-lablenamebox">
                    <span id="tienich-gioithieu-lablename"><a href="<?php echo get_home_url()."/gioi-thieu"; ?>">GIỚI THIỆU TRƯỜNG</a></span>
                </div>

                <div id="tienich-gioithieu-lableline"> </div>

            </div>
            <div id="tienich-gioithieu-box">
                <div id="tienich-gioithieu-box-thumbnail">
                    <?php
                        $args3 = array(
                            'p' => 1957, // chỉ lấy post id 1957 là bài giới thiệu
                        ); ?>
                        <?php
                        // gán query có lấy pID 1957 vào getpost3
                        $getposts3 = new wp_query($args3);
                        ?>
                        <?php
                        global $wp_query;
                        $wp_query->in_the_loop = true; ?>
                        <?php
                        $getposts3->have_posts();
                        $getposts3->the_post();
                        
                        ?>
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail();
                        } else {
                            echo '<img class="tienich-gioithieu-box-thumbnail-crop" src="'.catch_that_image_tienich();
                            echo '" />';
                        };
                    ?> 
                </div>
                <div id="tienich-gioithieu-box-content">
                        <?php  echo '<a href="'.$post->guid.'"><span id='.'tienich-gioithieu-box-content-link'.'>'.wp_trim_words($post->post_content, 60, '...') .'</span></a>';
                            ?>
                            <a href="<?php echo $post->guid; ?>">
                            <span class="tienich-gioithieu-box-content-xemthem">(Xem thêm)</span></a>
                </div>
                
            </div>
        </div>

        <div id="tienich-tieusu">
            <div id="tienich-tieusu-lable">
                <div id="tienich-tieusu-lablenamebox">
                    <span id="tienich-tieusu-lablename"><a href="<?php echo get_home_url(); ?>/tieu-su-ho-nghinh">TIỂU SỬ HỒ NGHINH</span>
                </div>

                <div id="tienich-tieusu-lableline"> </div>

            </div>
            <div id="tienich-gioithieu-box">
                <div id="tienich-gioithieu-box-thumbnail">
                    <?php
                        $args3 = array(
                            'p' => 1969, // chỉ lấy post id 1957 là bài giới thiệu
                        ); ?>
                        <?php
                        // gán query có lấy pID 1957 vào getpost3
                        $getposts3 = new wp_query($args3);
                        ?>
                        <?php
                        global $wp_query;
                        $wp_query->in_the_loop = true; ?>
                        <?php
                        $getposts3->have_posts();
                        $getposts3->the_post();
                        
                        ?>
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail();
                        } else {
                            echo '<img class="tienich-gioithieu-box-thumbnail-crop" src="'.catch_that_image_tienich();
                            echo '" />';
                        };
                    ?> 
                </div>
                <div id="tienich-gioithieu-box-content">
                        <?php  echo '<a href="'.$post->guid.'"><span id='.'tienich-gioithieu-box-content-link'.'>'.wp_trim_words($post->post_content, 60, '...') .'</span></a>';
                            ?>
                            <a href="<?php echo $post->guid; ?>">
                            <span class="tienich-gioithieu-box-content-xemthem">(Xem thêm)</span></a>
                </div>
                
            </div>
        </div>
</div>

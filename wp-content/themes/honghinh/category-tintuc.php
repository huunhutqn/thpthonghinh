<?php get_header(); ?>

<!-- lấy bài thể loại tin tức -->

<div id="single-container-taileu">
    <!-- cột bên trái chứa thông tin bài -->
    <div id="single-left-tailieu">

    <!-- phần đầu, chứa path category, chứa tiêu đề, tác giả viết, ngày đăng, lượt xem, lượt cmt-->
    <div id="single-top">
        <!-- đường dẫn của chuyên mục -->
        <div id="single-top-path">
        <?php pathcategory(); ?>
        </div>
        <!-- tiêu đề của bài viết -->
        <div id="single-top-title">
    <div id="searchResults">       

        <div class="search-title">
    TIN TỨC
</div>
    </div>
</div> <!-- đóng phần số kết quả tìm kiếm -->

        </div>
        <div id="single-top-postby" style="display: none;">
            <!-- <?php echo 'Đăng bởi: <b>'.get_the_author_meta('display_name', $post->post_author).'</b> - <i class="fa fa-clock-o"></i>'.get_the_date('D d/m/Y', $post->ID); ?> -->
            <!-- <a href="https://www.facebook.com/sharer/sharer.php?kid_directed_site=0&sdk=joey&u=<?php
                global $wp;
                echo home_url($wp->request);
                
                ?>&display=popup&ref=plugin&src=share_button"><div id="single-social"><i class="fa fa-facebook"></i><span>Share</span></div></a> -->
        </div>
    <!-- </div> -->
    
    <!-- phần giữa, chứa nội dung các kết quả tìm thấy -->
    <div id="single-mid">

         <div>
            <?php while (have_posts()) :
                the_post();?>
                <!-- các phần cần lấy ra: thumbnail, title, content, xem thêm-->
                
                <div id="category-items">
                    <?php //các thành phần cần lấy
                    echo '<div id="category-items-box">';
        
        // lấy thumbnail
                    echo '<div id="category-items-box2-thumb">';
                    // nếu hình có kích thước 120,200 thì đưa về 150
                    if (has_post_thumbnail()) {
                        $featured_img_url = get_the_post_thumbnail_url($post->ID, 'full');
                        list($width, $height) = getimagesize($featured_img_url);
                        if ($width == 200 && $height == 200) {
                            cropthum_tintuc1();
                            the_post_thumbnail();
                        } else if ($width == 120 && $height == 120) {
                            echo '<div id="category-items-box2-thumb1">';
                            the_post_thumbnail();
                            echo '</div>';
                        } else {
                            cropthum_tintuc();
                            the_post_thumbnail();
                        }
                    } else { ?>
                    <img class="category-items-box2-thumb-crop"   src="<?php
                    // $catch_image = catch_that_image_tintuc();
                    // list($width, $height) = getimagesize($catch_image);
                    // if ($width == 120 && $height == 120) {
                        
                    // }
                    echo catch_that_image_tintuc();
                    ?>"  alt="<?php the_title(); ?>" />
                    <?php };
                    echo '</div>';
                    echo '<div id="category-items-box2">';
                    
                    // $sinTerm = get_search_query();
                    // post content
                    $sinContent = wp_trim_words($post->post_content, 30, '...');

                    // $sinContent = str_replace($sinTerm, "<mark>{$sinTerm}</mark>", $sinContent);

                    // post title
                    $sinContentT = wp_trim_words($post->post_title, 16, '...');

                    // $sinContentT = str_replace($sinTerm, "<mark>{$sinTerm}</mark>", $sinContentT);
                    echo '<a href="'.$post->guid.'"><span id='.'category-items-box2-title'.'>'.$sinContentT.'</span></a>';
                    echo "<br>";
                    echo '<a href="'.$post->guid.'"><span id='.'category-items-box2-content'.'>'.$sinContent.'</span></a>';
                    echo "<br>";
                    echo '<a href="'.$post->guid.'"><span id="category-items-box2-date">'.get_the_date('D d/m/Y', $post->ID).'</span></a>';
                    
                    echo '</div>';
                    echo '</div>';
        
        ?>
        <?php // code chèn line, ý tưởng: chỉ chèn 3, array chạy từ 0
        // if ($i <= 3) {
        //     // echo '<div id="box_news_leftrline">'.'</div>';
        // }
            ?> 
                </div>

            <?php endwhile; ?>
 
            <?php honghinh_phantrang(); ?>
 
    
        
         </div>
         
    </div>

   
    </div>
    </div> <!-- đóng phần bên trái -->

    <!-- cột bên phải thể hiện các thông tin liên quan đến thể loại, tìm kiếm... | phần này sẽ khóa, chạy dọc theo nội dung bên trái khi cuộn -->
    <div id="single-right-tailieu">
        
    <!-- hộp chứa menu dọc: chuyên mục - các thể loại(tin tức, giới thiệu,...) -->
    <div id="single-right-cat">
        <i class="fa fa-window-minimize fa-rotate-90"></i><span class="single-right-cat-title">CHUYÊN MỤC</span>
        <ul id="single-right-cat-menu">
            <li><a href="<?php echo get_home_url(); ?>">Trang chủ</a></li>
            <li><a href="<?php echo get_home_url(); ?>/category/tintuc">Tin tức</a></li>
            <li><a href="<?php echo get_home_url(); ?>/category/thongbao">Thông báo</a></li>
            <li><a href="<?php echo get_home_url(); ?>/gioi-thieu">Giới thiệu</a></li>
            <li><a href="<?php echo get_home_url(); ?>">Liên hệ</a></li>
        </ul>
    </div>
    <hr style="
    border: 0;
    height: 0;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    border-bottom: 1px solid rgba(255, 255, 255, 0.3);
    margin-top: 20px;
    margin-bottom: 20px;
    ">
    <!-- hộp chứa 3 tin mới nhất -->
    <div id="single-right-last">
        <div id="single-right-last-news">
        <i class="fa fa-window-minimize fa-rotate-90"></i><span class="single-right-news-title">TIN MỚI</span>
        <?php
            $args1 = array(
            'post_status' => 'publish', // Chỉ lấy những bài viết được publish
            'post_type' => 'post', // Lấy những bài viết thuộc post, nếu lấy những bài trong 'trang' thì để là page
            'showposts' => 3, // số lượng bài viết
         // lấy bài viết trong chuyên mục có id là 1
            'category__not_in' => array( 71 ), // loại trừ category id 71 ra: loại 'thông báo'
            'offset' => 1, // loai bo phia truoc 1 bai
            );

?>
<?php $getposts1 = new wp_query($args1); ?>
<?php global $wp_query;
$wp_query->in_the_loop = true; ?>
<?php $i = 0;  // biến i để dùng lại ở chèn line
while ($getposts1->have_posts()) :
    $getposts1->the_post();
    $i++ ; //trong khi mỗi lần kiểm tra còn post, nếu còn thì lấy ra, sau khi lấy ra sẽ tăng i 1 đơn vị ?>
    <?php //các thành phần cần lấy
    echo '<div id="single-right-last-c">';
    
    // lấy thumbnail
    echo '<div id="single-right-last-thum">';
    if (has_post_thumbnail()) {
        cropthum();
        the_post_thumbnail();
    } else { ?>
    <img src="<?php bloginfo('template_directory'); ?>/images/default-image-80x80.png" alt="<?php the_title(); ?>" />
    <?php };
    echo '</div>';
    echo '<div id="single-right-last-title">';
    echo '<a href="'.$post->guid.'"><span id='.'single-right-last-title-link'.'>'.wp_trim_words($post->post_title, 20, '...') .'</span></a>';

    echo '<a href="'.$post->guid.'"><span id="single-right-last-date">'.get_the_date('D d/m/Y', $post->ID).'</span></a>';
    echo '</div>';
    echo '</div>';
    
    ?>
    <?php // code chèn line, ý tưởng: chỉ chèn 3, array chạy từ 0
    if ($i <= 2) {
        echo '<div id="single-right-last-line">'.'</div>';
    }
        ?> 
<?php endwhile;
wp_reset_postdata(); ?>
    </div> <!-- đóng div 3 tin mới nhất -->
    <hr style="
    border: 0;
    height: 0;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    border-bottom: 1px solid rgba(255, 255, 255, 0.3);
    margin-top: 20px;
    margin-bottom: 20px;
    ">
    <!-- chứa 3 thông báo mới nhất -->
    <div id="single-right-last-noti">
        <i class="fa fa-window-minimize fa-rotate-90"></i><span class="single-right-news-title">THÔNG BÁO MỚI</span>
            <?php
            $args2 = array(
            'post_status' => 'publish', // Chỉ lấy những bài viết được publish
            'post_type' => 'post', // Lấy những bài viết thuộc post, nếu lấy những bài trong 'trang' thì để là page
            'showposts' => 3, // số lượng bài viết
         // lấy bài viết trong chuyên mục có id là 71, mục thông báo
            'cat' => 71,
            );

?>
<?php $getposts2 = new wp_query($args2); ?>
<?php global $wp_query2;
$wp_query->in_the_loop = true; ?>
<?php $j=0;
while ($getposts2->have_posts()) :
    $getposts2->the_post();
    $j++;
    ?>
    <?php //các thành phần cần lấy
    ?>
    <div id="single-right-last-noti-c">
        <div id="single-right-last-noti-item">
            <i id="single-right-last-noti-icon" class="fa fa-chevron-circle-right"></i>
    <!-- <img id="single-right-last-noti-icon" src="<?php bloginfo('template_directory'); ?>/images/chevron-sign-to-right.png" alt="<?php the_title(); ?>" /> -->
    <?php
    echo '<a href="'.$post->guid.'"><span id='.'single-right-last-noti-title'.'>'.wp_trim_words($post->post_title, 20, '...') .'</span></a>'. '<br>';
    echo '<span id="single-right-last-noti-date">'.get_the_date('d/m/Y', $post->ID).'</span>';
        ?> 
    </div>
        <?php // code chèn line, ý tưởng: chỉ chèn 2, array chạy từ 0
        if ($j <= 2) {
            echo '<div id="single-right-last-noti-line">'.'</div>';
        }
        echo '</div>';
        ?> 
<?php endwhile;
wp_reset_postdata(); ?>   
    </div>
    </div> <!-- đóng div chứa 3 thông báo mới nhất -->
    </div> <!-- đóng div chứa 3 tin mới và 3 thông báo mới -->
    
    


    </div>

<?php get_footer(); ?>
<!-- <?php
    echo '<pre>';
    print_r($wp_query);
    echo '</pre>';
?> -->
<!-- Is silence golden? -->

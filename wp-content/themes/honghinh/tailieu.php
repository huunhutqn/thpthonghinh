<?php
/* Template Name: Tài Liệu */
?>
<?php get_header(); ?>

<!-- hộp bao trùm phần hiển thị nội dung của bài post -->
<div id="single-container-taileu">
    <!-- cột bên trái chứa thông tin bài -->
    <div id="single-left-tailieu">

    <!-- phần đầu, chứa path category, chứa tiêu đề, tác giả viết, ngày đăng, lượt xem, lượt cmt-->
    <div id="single-top">
        <!-- đường dẫn của chuyên mục -->
        <div id="single-top-path">
        <a href="<?php echo get_home_url(); ?>">Trang chủ</a>
        <i class="fa fa-angle-right"></i>
        <a href="<?php
                echo get_home_url().'/tai-lieu';
                ?>">Tài liệu</a>
        </div>
        <!-- tiêu đề của bài viết -->
        <div id="single-top-title">
            <?php echo $post->post_title; ?>
        </div>
        <div id="single-top-postby">
            <!-- <?php echo 'Đăng bởi: <b>'.get_the_author_meta('display_name', $post->post_author).'</b> - <i class="fa fa-clock-o"></i>'.get_the_date('D d/m/Y', $post->ID); ?> -->
            <!-- <a href="https://www.facebook.com/sharer/sharer.php?kid_directed_site=0&sdk=joey&u=<?php
                global $wp;
                echo home_url($wp->request);
                
                ?>&display=popup&ref=plugin&src=share_button"><div id="single-social"><i class="fa fa-facebook"></i><span>Share</span></div></a> -->
        </div>
    </div>
    
    <!-- phần giữa, chứa nội dung tin bài -->
    <div id="single-mid">
            
        <?php echo do_shortcode('[wpdm_packages template="link-template-calltoaction3.php" order_by="date" order="desc" paging="1" items_per_page="15" cols=1 colsphone=1 colspad=1 desc=""]') ?> 
        <!-- <?php
        // echo $post->post_content;
        // hàm dưới thay cho hàm trên, sẽ lấy được shortcode
        echo apply_filters('the_content', $post->post_content);
        ?> -->
    </div>

    <!-- phần dưới, chứa thông tin tác giả bài viết, phần comment. bài trước đó, bài tiếp theo, phần random tin bài -->
   <!-- <div id="single-bot">
         <a href="<?php global $wp;
                    echo 'https://www.facebook.com/sharer/sharer.php?kid_directed_site=0&sdk=joey&u='.home_url($wp->request).'&display=popup&ref=plugin&src=share_button';
                    ?>"><i class="fa fa-share"></i> 
        </a> 
        <div id="single-bot-av"><?php echo get_avatar($post->post_author, 100); ?></div>
        <div id="single-bot-contain">  block chứa tên người đăng và bio người đăng 
        <div id="single-bot-displayname"><?php echo get_the_author_meta('display_name', $post->post_author); ?></div>
        <div id="single-bot-description"><?php echo get_the_author_meta('description', $post->post_author); ?></div>
    </div> -->
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
    
    


    </div> <!-- đóng phần bên phải -->
    
    <?php get_footer(); ?>
</div>

<!-- <?php
    echo '<pre>';
    print_r($wp_query);
    echo '</pre>';
?> -->

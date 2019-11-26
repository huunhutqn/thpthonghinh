<div id="box_news">
<?php //title_excerpt_length(); ?>
    <div id="box_news_left">
            <div id="box_news_leftlable">
                <div id="box_news_leftlablebr">
                    <span id="box_news_leftlablename"><a href="<?php echo get_home_url().'/category/tintuc/'; ?>">TIN TỨC</a></span>
                </div>
                <div id="box_news_leftlablebrP">
                    <span id="box_news_leftlablenameP" class="tn"><a href="<?php echo get_home_url().'/category/tintuc/doan-tn/'; ?>">ĐOÀN THANH NIÊN</a></span>
                </div>
                <div id="box_news_leftlablebrP">
                    <span id="box_news_leftlablenameP" class="cd"><a href="<?php echo get_home_url().'/category/tintuc/cong-doan/'; ?>">CÔNG ĐOÀN</a></span>
                </div>
                <div id="box_news_leftlableline"> </div>

            </div>
            <div id="box_news_leftl">
            <?php
            $args = array(
            'post_status' => 'publish', // Chỉ lấy những bài viết được publish
            'post_type' => 'post', // Lấy những bài viết thuộc post, nếu lấy những bài trong 'trang' thì để là page
            'showposts' => 1, // số lượng bài viết
             // lấy bài viết trong chuyên mục có id là 1
            'category__not_in' => array( 71 ), // loại trừ category id 71 ra: loại 'thông báo'
            //'offset' => 1, // loai bo phia truoc 1 bai
            );

    ?>
    <?php $getposts = new wp_query($args); ?>
    <?php global $wp_query;
    $wp_query->in_the_loop = true; ?>
    <?php while ($getposts->have_posts()) :
        $getposts->the_post(); ?>
        <?php //các thành phần cần lấy
        echo '<div id="box_news_leftlc">';

        // lấy thumbnail
        
        if (has_post_thumbnail()) {
            $featured_img_url = get_the_post_thumbnail_url($post->ID, 'full');
            list($width, $height) = getimagesize($featured_img_url);

            if (!($width < 450) || !($height < 450)) {
                echo '<div id="box_news_leftlthumLarger450">';
                the_post_thumbnail();
            } else {
                echo '<div id="box_news_leftlthumSmaller450">';
                the_post_thumbnail();
            }
        } else {
                $a = catch_that_image_boxnews();
                // echo $a;
                list($rong, $cao) = getimagesize($a);
                // echo $rong.$cao;
            if (!($rong < 450) || !($cao < 450)) {
                // echo "rộng thấp hơn 450 và cao cũng vậy";
                echo '<div id="box_news_leftlthumLarger450">';
                echo '<img src="'.catch_that_image_boxnews().'" />' ;
            } else {
                echo '<div id="box_news_leftlthumSmaller450">';
                echo '<img src="'.catch_that_image_boxnews().'" />' ;
            }
        }
        
        echo '<div id="box_news_leftlcontainer">';
        echo '<div id="box_news_leftlcontainer1"></div>';
        //wp_trim_excerpt( $text = '' )
        //wp_trim_words( $post->post_title, 20, '...' )
        echo '<a href="'.$post->guid.'"><span id='.'box_news_left_titlel'.'>'.wp_trim_words($post->post_title, 18, '...') .'</span></a>';

        echo '<span id="box_news_left_date1">'.get_the_date('D d/m/Y', $post->ID).'</span>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
            ?>

    <?php endwhile;
    wp_reset_postdata(); ?>
                    <div class="content" style="display: none;">
                <!-- dùng section hoặc div như nhau -->
                 <section id="main-content">
                    <?php if (have_posts()) : // nếu có post thì
                        while (have_posts()) : // trong khi còn post thì
                            the_post(); ?> 
                            <!-- the_post() mới chỉ lấy, chưa show -->
                        <?php get_template_part('content', get_post_format());
                        // load file content-$format.php, trong thư mục theme. $format là loại post như video, audio, image,... nếu post đó ko có format thì load mặc định content.php
                        ?>
                        <?php endwhile; ?>
                        <?php honghinh_phantrang(); ?>
                    <?php else : ?>
                        <!-- Nếu không có post nào thì trả về page thông báo -->
                        <?php get_template_part('content', 'none');
                        // load file content-none.php trong thư mục theme. vd thông báo trang này chưa có nội dung
                        ?>
                    <?php endif; ?>
                </section>
                    </div>
            </div>
            <div id="box_news_leftr">
                <?php
                $args1 = array(
                'post_status' => 'publish', // Chỉ lấy những bài viết được publish
                'post_type' => 'post', // Lấy những bài viết thuộc post, nếu lấy những bài trong 'trang' thì để là page
                'showposts' => 4, // số lượng bài viết
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
        echo '<div id="box_news_leftrc">';
        
        // lấy thumbnail
        echo '<div id="box_news_leftrthum">';
        if (has_post_thumbnail()) {
            cropthumnews();
            the_post_thumbnail();
        } else { ?>
        <img class="box_news_leftrthum-crop" src="<?php echo catch_that_image_boxnewsr(); ?>" alt="<?php the_title(); ?>" />
        <?php };
        echo '</div>';
        echo '<div id="box_news_left_right">';
        echo '<a href="'.$post->guid.'"><span id='.'box_news_left_titler'.'>'.wp_trim_words($post->post_title, 15, '...') .'</span></a>';

        echo '<a href="'.$post->guid.'"><span id="box_news_left_date2">'.get_the_date('D d/m/Y', $post->ID).'</span></a>';
        echo '</div>';
        echo '</div>';
        
        ?>
        <?php // code chèn line, ý tưởng: chỉ chèn 3, array chạy từ 0
        if ($i <= 3) {
            echo '<div id="box_news_leftrline">'.'</div>';
        }
            ?> 
    <?php endwhile;
    wp_reset_postdata(); ?>
            </div>
            <!-- <div id="more_posts">
            <span id="previous"><i id="tinMoi" class="fa fa-angle-double-left" title="Tin mới"></i></span>
            <span id="next"><i id="tinCu" class="fa fa-angle-double-right" title="Tin cũ" onclick="morePostsNext()"></i></span>
            </div> -->
    </div>
    <div id="box_news_right">
        <div id="box_news_rightlable">
            <div id="box_news_rightlablebr">
                <span id="box_news_rightlablename"><a href="<?php echo get_home_url().'/category/thongbao/'; ?>">THÔNG BÁO</a></span>
            </div>

            <div id="box_news_rightlableline"> </div>

        </div>
        <?php
        $args2 = array(
        'post_status' => 'publish', // Chỉ lấy những bài viết được publish
        'post_type' => 'post', // Lấy những bài viết thuộc post, nếu lấy những bài trong 'trang' thì để là page
        'showposts' => 5, // số lượng bài viết
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
    <div id="box_news_rightc">
        <div id="box_news_rightitem">
    <img id="box_news_righticon" src="<?php bloginfo('template_directory'); ?>/images/chevron-sign-to-right.png" alt="<?php the_title(); ?>" />
    <?php
    echo '<a href="'.$post->guid.'"><span id='.'box_news_right_title'.'>'.wp_trim_words($post->post_title, 15, '...') .'</span></a>'. '<br>';
    echo '<span id="box_news_right_date">'.get_the_date('D d/m/Y', $post->ID).'</span>';
        ?> 
    </div>
        <?php // code chèn line, ý tưởng: chỉ chèn 4, array chạy từ 0
        if ($j <= 4) {
            echo '<div id="box_news_rightline">'.'</div>';
        }
        echo '</div>';
        ?> 
<?php endwhile;
wp_reset_postdata(); ?>   
    </div>
</div>
<!-- <?php
    echo '<pre>';
    print_r($wp_query);
    echo '</pre>';
?> -->

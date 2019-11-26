
    <div id="box_news_leftr">

                <?php
                $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
                require_once($parse_uri[0] . 'wp-load.php');
                $offsetPost = '<script language="javascript">document.write(offsetPost);</script>';
                echo $offsetPost;
                // $offsetPost = $_GET['offsetPost'];
                // echo "$offsetPost";
                $args1 = array(
                'post_status' => 'publish', // Chỉ lấy những bài viết được publish
                'post_type' => 'post', // Lấy những bài viết thuộc post, nếu lấy những bài trong 'trang' thì để là page
                'showposts' => 4, // số lượng bài viết
             // lấy bài viết trong chuyên mục có id là 1
                'category__not_in' => array( 71 ), // loại trừ category id 71 ra: loại 'thông báo'
                'offset' => $offsetPost, // loai bo phia truoc 1 bai
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
    <?php $offsetPost = 1; ?>
        <!-- <script type="text/javascript">
            var templateUrl = object_name.templateUrl;
            // templateUrl = templateUrl + '/loadmore.php';
            var offsetPost = 1;
            alert(offsetPost);
            function morePostsNext() {
              //trỏ đến và thay thế một thẻ bằng một thẻ mới
              if (offsetPost <= 1) {
                var q = document.getElementById('tinMoi');
                    if (q.style.display == 'inline-block') 
                    {
                        q.style.display = 'none';
                    } else 
                    {
                        q.style.display = 'inline-block';
                    }
              }
              offsetPost = offsetPost + 4;
              // window.location.href = "http://abc.com/main.php?offsetPost=" + offsetPost;
              $.get( templateUrl , function(data) {
                $( "div#box_news_leftr" ).replaceWith($(data));
            });

            }
        </script> -->
            </div>

<!-- thử -->
<?php
/**
  @ Thiết lập các hằng dữ liệu quan trọng
  @ THEME_URL = get_stylesheet_directory() - đường dẫn tới thư mục theme
  @ CORE = thư mục /core của theme, chứa các file nguồn quan trọng.
  **/
  define('THEME_URL', get_stylesheet_directory());
  // bỏ qua phần core init
  define('CORE', THEME_URL . '/core');

 /**
  @ Load file /core/init.php
  @ Đây là file cấu hình ban đầu của theme mà sẽ không nên được thay đổi sau này.
  **/ /* phân này chưa cần thiết */
  // require_once(CORE . '/init.php');
 /**
  @ Thiết lập $content_width để khai báo kích thước chiều rộng của nội dung
  **/
if (! isset($content_width)) {
      /*
       * Nếu biến $content_width chưa có dữ liệu thì gán giá trị cho nó
       */
      $content_width = 620;
}
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 */
if (! function_exists('honghinh_setup')) {
    // kiểm tra hàm honghinh_setup có chưa, chưa thì thực thi hàm mới bên dưới
    function honghinh_setup()
    {
        load_theme_textdomain('honghinh');
        /*
         * Tự chèn RSS Feed links trong <head>
         */
        add_theme_support('automatic-feed-links');
        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(600, 500, array( 'center', 'center'));
        if (! function_exists('cropthum')) {
            function cropthum()
            {
                set_post_thumbnail_size(120, 120);
            }
        }
        if (! function_exists('cropthumnews')) {
            function cropthumnews()
            {
                set_post_thumbnail_size(80, 80);
            }
        }
        if (! function_exists('cropthum_tintuc')) {
            function cropthum_tintuc()
            {
                set_post_thumbnail_size(200, 200);
            }
        }
        if (! function_exists('cropthum_tintuc1')) {
            function cropthum_tintuc1()
            {
                set_post_thumbnail_size(150, 150);
            }
        }
        /*
         * Thêm chức năng post format
         */
        add_theme_support(
            'post-formats',
            array(
                        'video',
                        'image',
                        'audio',
                        'gallery',
                        'quote',
                        'link'
                )
        );
        /*
         * Thêm chức năng custom background
         */
        $default_background = array(
                'default-color' => '#e8e8e8'// màu xám, màu sẽ đặt mặc định
        );
        add_theme_support('custom-background', $default_background);
        /*
         * Thêm menu
         */
        register_nav_menu('primary-menu', __('Primary Menu', 'honghinh'));
        /*
         * Thêm sidbar
         */
        // tạo biến cho sidebar
        // $sidebar = array(
        //         'name' => __('Main Sidebar', 'honghinh'),
        //         'id' => 'main-sidebar',
        //         'description' => __('Default'),
        //         'class' => 'main-sidebar',
        //         'before_title' => '<h3 class="widgettitle">',
        //         'after_title' => '</h3>'
        // );
        // register_sidebar($sidebar);
        // nếu không dùng init thì có thể dùng after_setup_theme
    } add_action('init', 'honghinh_setup');
} //endif của honghinh_setup
/*
 *  Thiết lập hàm hiển thị logo
 *  honghinh_logo()
 */
if (! function_exists('honghinh_logo')) {

    function honghinh_logo()
    {
?>
        <div class="logo">
        <div class="site-name">
            <?php
            if (is_home()) {
                printf(
                    '<h1><a href="%1$s" title="%2$s">%3$s</a></h1>',
                    get_bloginfo('url'),
                    get_bloginfo('description'),
                    get_bloginfo('sitename')
                );
            } else {
                printf(
                    '<p><a href="%1$s" title="%2$s">%3$s</a></p>',
                    get_bloginfo('url'),
                    get_bloginfo('description'),
                    get_bloginfo('sitename')
                );
            }

                ?>
                </div>
                <div class="site-description"><?php bloginfo('description');?> </div>
                </div>
    <?php }
            
}

/*
 * Thiết lập menu
 */
if (!function_exists('honghinh_menu')) {
    function honghinh_menu($menu)
    {
        $menu = array (
            'theme_location' => $menu,
            'container' => 'nav',
            'container_class' => $menu
        );
        wp_nav_menu($menu);
    }
}

/*
 * tạo hàm phân trang
 */
if (!function_exists('honghinh_phantrang')) {
    function honghinh_phantrang()
    {
        // không hiển trị phân trang nếu trang đó ít hơn 2 trang
        if ($GLOBALS['wp_query']->max_num_pages < 2) {
            return '';
        }
        ?>
            <nav class="pagination" role="navigation">
                <?php if (get_next_posts_link()) : ?>
                    <div class="prev"><?php next_posts_link(__('Bài cũ hơn', 'honghinh')); ?></div>
                <?php endif; ?>
                <?php if (get_previous_posts_link()) : ?>
                    <div class="next"><?php previous_posts_link(__('Bài mới hơn', 'honghinh')); ?></div>
                <?php endif; ?>
            </nav>
        <?php
    }
}

/*
 * hàm hiển thị thumbnail của post
 * ảnh thumbnail sẽ không được hiển thị trong trang single
 * nhưng sẽ hiển thị trong single nếu post đó có format là Image
 */
if (!function_exists('honghinh_thumbnail')) {
    function honghinh_thumbnail($size)
    {
        //chỉ hiển thị thumbnail vs post không có mật khẩu
        if (!is_single() && has_post_thumbnail() && !post_password_required() || has_post_format('image')) : ?>
            <figure class="post-thumbnails"><?php the_post_thumbnail($size); ?></figure><?php
        endif;
    }
}

/*
 * hàm hiển thị tiêu đề post trong .entry-header của content.php
 * tiêu đề của post sẽ nằm trong thẻ h1 ở trang single
 * ở các trang chủ hay lưu trữ sẽ là h2
 */
if (!function_exists('honghinh_entry_header')) {
    function honghinh_entry_header()
    {
        if (is_single()) : ?>
            <h1 class="entry-title">
                <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                    <?php the_title(); ?>
                </a>
            </h1>
        <?php else : ?>
            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                    <?php the_title(); ?>
                </a>
            </h2>
        <?php
        endif;
    }
}

/*
 * hàm hiển thị thông tin post như ai đăng, lúc nào,...
 * hiển thị thông tin post (Post Meta)
 */
if (!function_exists('honghinh_entry_meta')) {
    function honghinh_entry_meta()
    {
        if (!is_page()) :
            echo '<div class="entry-meta">';
            // hiển thị tên tác giả, tên category và ngày đăng
            printf(__('<span class="author">Posted by %1$s</span>', 'honghinh'), get_the_author());
            printf(__('<span class="date-published"> at %1$s</span>', 'honghinh'), get_the_date());
            printf(__('<span class="category"> in %1$s</span>', 'honghinh'), get_the_category_list(', '));

            //hiển thị số đếm lượt bình luận
            if (comments_open()) :
                echo '<span class="meta-reply"> ';
                comments_popup_link(
                    __('Leave a comment', 'honghinh'),
                    __('One comment', 'honghinh'),
                    __('% comment', 'honghinh'),
                    __('Read all comments', 'honghinh')
                );
                echo '</span>';
            endif;
            echo '</div>';
        endif;
    }
}

/*
 * thêm chữ Read More và excerpt, đối với các 55từ
 */
function honghinh_readmore()
{
    return '...<a class="read-more" href="'.get_permalink(get_the_ID()).'">'.__('Read More', 'honghinh').'</a>';
}
add_filter('excerpt_more', 'honghinh_readmore');
/*
 * thêm ... vào tiêu đề lấy ra
 */
function title_excerpt_length($length)
{
    return 20;
}
add_filter('excerpt_length', 'title_excerpt_length', 999);

/*
 * hiển thị nội dung của post type
 * hiển thị đoạn rút gọn của post ngoài trang chủ (the_excerpt)
 * nhưng sẽ hiển thị toàn bộ đối với single (the_content)
 */
if (!function_exists('honghinh_entry_content')) {
    function honghinh_entry_content()
    {
        if (!is_single()) :
            the_excerpt();
        else :
            the_content();
            /*
             * code hiển thị phân trang trong post type
             */
            $link_pages = array(
                'before' => __('<p>Page:', 'honghinh'),
                'after' => '</p>',
                'nextpagelink' => __('Next page', 'honghinh'),
                'previouspagelink' => __('Previous page', 'honghinh')
            );
            wp_link_pages($link_pages);
        endif;
    }
}

/*
 *hàm hiển thị tag của post ở cuối post trong content.php
 */
if (!function_exists('honghinh_entry_tag')) {
    function honghinh_entry_tag()
    {
        if (has_tag()) :
            echo '<div class="entry-tag">';
            printf(__('Tagged in %1$s', 'honghinh'), get_the_tag_list('', ', '));
            echo '</div>';
        endif;
    }
}

/*
 * chèn css và js vào theme
 * dùng hook wp_enqueue_scripts() để hiển thị nó ra ngoài front-end
 */
if (!function_exists('honghinh_style')) {
    function honghinh_style()
    {
        /*
         * hàm get_stylesheet_uri() sẽ trả về giá trị dẫn đến file style.css của theme
         * nếu sử dụng child theme, thì file style.css này vẫn load ra từ theme mẹ
         */
        wp_register_style('main-style', get_template_directory_uri().'/style.css', 'all');
        wp_register_style('slider-style', get_template_directory_uri().'/slider.css', 'all');
        wp_enqueue_style('main-style');
        wp_enqueue_style('slider-style');
        wp_register_script('script', get_template_directory_uri() . '/js/js.js', array ( 'jquery' ), 1.1, true);
        // wp_register_script('my-script', get_stylesheet_directory_uri().'/js/js.js');
        // wp_enqueue_script('my-script');
        // $translation_array = array( 'templateUrl' => get_template_directory_uri().'/loadmore.php' );
        //after wp_enqueue_script
        
        // wp_localize_script('my-script', 'object_name', $translation_array, true);
        wp_enqueue_script('script');
    }
    add_action('wp_enqueue_scripts', 'honghinh_style');
}

// hàm gọi ra đường dẫn của thể loại bài viết, vd: home / tin tức ; trang chủ > tin tức > họp phụ huynh
if (!function_exists('pathcategory')) {
    function pathcategory()
    {
        ?>
        <a href="<?php echo get_home_url(); ?>">Trang chủ</a>
        <i class="fa fa-angle-right"></i>
        <?php
        $theloai = get_the_category();
        if (! empty($theloai)) {
            echo '<a href="' . esc_url(get_category_link($theloai[0]->term_id)) . '">' . esc_html($theloai[0]->name) . '</a>';
        } ?>
        <i class="fa fa-angle-right"></i>
        <!-- <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
 -->
        <?php
    }
}

// lấy hình đầu tiên hoặc hình mặc định để làm thumbnail
function catch_that_image_singlepost()
{
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches[1][0];

    if (empty($first_img)) {
        $first_img = bloginfo('template_directory')."/images/default-image-120x120.png";
    }
    return $first_img;
}
function catch_that_image_boxnews()
{
    global $post, $posts;
    $first_img1 = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img1 = $matches[1][0];

    if (empty($first_img1)) {
        $first_img1 = bloginfo('template_directory')."/images/default-image-450x450.png";
    }
    return $first_img1;
}

function catch_that_image_boxnewsr()
{
    global $post, $posts;
    $first_img2 = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img2 = $matches[1][0];//[0] sau [1] nếu lỗi

    if (empty($first_img2)) {
        $first_img2 = bloginfo('template_directory')."/images/default-image-80x80.png";
    }
    return $first_img2;
}
function catch_that_image_tintuc()
{
    global $post, $posts;
    $first_img4 = '';
    ob_start();
    ob_end_clean();
    if (preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches)) {
        $first_img4 = $matches[1][0];//[0] sau [1] nếu lỗi
    } else {
        $first_img4 = bloginfo('template_directory')."/images/default-image-120x120.png";
    }
    return $first_img4;
}

function catch_that_image_tienich()
{
    global $post, $posts;
    $first_img3 = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img3 = $matches[1][0];//[0] sau [1] nếu lỗi

    // if (empty($first_img2)) {
    //     $first_img2 = bloginfo('template_directory')."/images/default-image-80x80.png";
    // }
    return $first_img3;
}
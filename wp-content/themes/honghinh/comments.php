<?php // Do not delete these lines
 
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
    die('Vui lòng không tải lại trang. Cảm ơn!');
}
if (!empty($post->post_password)) { // if there's a password
    if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
?>
 
<h2><?php _e('Đã được bảo vệ bằng mật khẩu'); ?></h2>
<p><?php _e('Nhập mật khẩu để xem bình luận.'); ?></p>
 
<?php return;
    }
}
    /* This variable is for alternating comment background */
 
 
 
$oddcomment = 'alt';
 
 
 
?>
 
<!-- You can start editing here. -->
<div id="cmt-title">PHẦN BÌNH LUẬN</div>
<?php if ($comments) : ?>
    <h3 id="comments"><?php comments_number('Không có bình luận', 'Một bình luận', '% bình luận');?> trong bài &#8220;<?php the_title(); ?>&#8221;</h3>
 
<ol class="commentlist">
<?php foreach ($comments as $comment) : ?>
    <li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
 <div id="author-avatar"><?php echo get_avatar($comment, 64); ?></div>
 <div id="cmt-data">
<div class="commentmetadata">

<strong><?php comment_author_link() ?></strong>,<span class="cmt-metadata"> <?php _e('vào'); ?> <a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('D jS, Y') ?> <?php _e('lúc');?> <?php comment_time() ?></a> <?php _e('đã bình luận&#58;'); ?> <?php edit_comment_link('<span style="font-size: 12px;vertical-align: super;">(Sửa)</span>', '', ''); ?></span>
 
        <?php if ($comment->comment_approved == '0') : ?>
        <em><?php _e('(*)Bình luận của bạn đang chờ quản trị phê duyệt.'); ?></em>
 
        <?php endif; ?>
 
</div>
 

<?php comment_text() ?>
 </div>
    </li>
 
 
 
<?php /* Changes every other comment to a different class */
 
if ('alt' == $oddcomment) {
    $oddcomment = '';
} else {
    $oddcomment = 'alt';
}
 
?>
 
 
 
<?php endforeach; /* end for each comment */ ?>
 
    </ol>
 
 
 
<?php else : // this is displayed if there are no comments so far ?>
<?php if ('open' == $post->comment_status) : ?>
    <!-- If comments are open, but there are no comments. -->
 
<?php else : // comments are closed ?>
    <!-- If comments are closed. -->
 
<p class="nocomments">Bình luận đã bị đóng.</p>
 
 
 
<?php endif; ?>
 
<?php endif; ?>
 
 
 
 
 <!-- <div id="action-before-cmt"> -->
<?php if ('open' == $post->comment_status) : ?>
        <h3 id="respond">Để lại bình luận</h3>
 
 
 
<?php if (get_option('comment_registration') && !$user_ID) : ?>
<p id="commentform-p">Bạn cần phải <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">đăng nhập</a> để viết bình luận.</p>
 
 
 
<?php else : ?>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
 
<?php if ($user_ID) : ?>
<p>Bạn đã đăng nhập với tài khoản <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Đăng xuất &raquo;</a></p>
  
 
 
<?php else : ?>
<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="40" tabindex="1" />
 
<label for="author"><small>Name <?php if ($req) {
    echo "(required)";
                                } ?></small></label></p>
 
 
 
<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="40" tabindex="2" />
 
<label for="email"><small>Mail (will not be published) <?php if ($req) {
    echo "(required)";
                                                       } ?></small></label></p>
 
 
 
<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="40" tabindex="3" />
 
<label for="url"><small>Website</small></label></p>
 
 
 
<?php endif; ?>
 
 
 
<!--<p><small><strong>XHTML:</strong> <?php _e('You can use these tags&#58;'); ?> <?php echo allowed_tags(); ?></small></p>-->
 
 
 
<p><textarea name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea></p>
 
 
 
<p><input name="submit" type="submit" id="submit" tabindex="5" value="Gửi bình luận" />
 
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
 
</p>
 
 
 
<?php do_action('comment_form', $post->ID); ?>
 
 
 
</form>
 
 
 
<?php endif; // If registration required and not logged in ?>
 
 
 
<?php endif; // if you delete this the sky will fall on your head ?>
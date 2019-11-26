<article id="post-<?php the_ID(); ?>" <?php /*tạo class tượng trung cho post*/post_class(); ?>>
    <div class="entry-thumbnail">
        <?php honghinh_thumbnail('thumbnail'); ?>
    </div>
    <header class="entry-header">
        <?php honghinh_entry_header(); ?>
        <?php honghinh_entry_meta(); ?>
    </header>
    <div class="entry-content">
        <?php honghinh_entry_content(); ?>
        <?php (is_single() ? honghinh_entry_tag() : ''); ?>
    </div>
</article>

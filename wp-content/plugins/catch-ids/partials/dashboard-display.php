<?php

/**
 * Provide a admin area dashboard view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://catchthemes.com
 * @since      1.0.0
 *
 * @package    Generate_Child_Theme
 * @subpackage Generate_Child_Theme/admin/partials
 */
?>

<div id="catch-ids" class="catchids-main" aria-label="Main Content">
    <?php
        //Add header
        require_once plugin_dir_path( dirname( __FILE__ ) ) . '/partials/header.php';
    ?>

    <div id="dashboard">
        <div class="container">
            <div id="plugin-description">
                <p><?php esc_html_e( 'Catch IDs is a simple and light weight plugin to show the Post ID, Page ID, Media ID, Links ID, Category ID, Tag ID and User ID in the Admin Section Table.', 'generate-child-theme' ); ?></p>
            </div>
            <div class="module-container">
                <?php 
                    $options = catchids_get_options();
                    $post_types = catchids_get_all_post_types(); 
                    foreach ( $post_types as $key => $value ) :
                ?>
                <!-- Custom Post Types -->
                <div id="module-<?php echo $key; ?>" class="catch-modules">
                    <div class="module-header <?php echo $options[$key] ? 'active' : 'inactive'; ?>">
                        <h3 class="module-title"><?php esc_html_e( $value, 'catch-ids' ); ?></h3>
                        <div class="switch">
                            <input type="checkbox" id="catchids_options[<?php echo $key; ?>]" class="catchids-input-switch" rel="<?php echo $key; ?>" <?php checked( true, $options[$key] ); ?> >
                            <label for="catchids_options[<?php echo $key; ?>]"></label>
                        </div>
                        <div class="loader"></div>
                    </div><!-- .module-header -->
                </div><!-- .catch-modules -->
                <?php endforeach; ?>

                <!-- Media -->
                <div id="module-<?php echo 'media'; ?>" class="catch-modules">
                    <div class="module-header <?php echo $options['media'] ? 'active' : 'inactive'; ?>">
                        <h3 class="module-title"><?php esc_html_e( 'Media', 'catch-ids' ); ?></h3>
                        <div class="switch">
                            <input type="checkbox" id="catchids_options[media]" class="catchids-input-switch" rel="media" <?php checked( true, $options['media'] ); ?> >
                            <label for="catchids_options[media]"></label>
                        </div>
                        <div class="loader"></div>
                    </div><!-- .module-header -->
                </div><!-- .catch-modules -->

                <!-- Categories -->
                <div id="module-<?php echo 'category'; ?>" class="catch-modules">
                    <div class="module-header <?php echo $options['category'] ? 'active' : 'inactive'; ?>">
                        <h3 class="module-title"><?php esc_html_e( 'Categories', 'catch-ids' ); ?></h3>
                        <div class="switch">
                            <input type="checkbox" id="catchids_options[category]" class="catchids-input-switch" rel="category" <?php checked( true, $options['category'] ); ?> >
                            <label for="catchids_options[category]"></label>
                        </div>
                        <div class="loader"></div>
                    </div><!-- .module-header -->
                </div><!-- .catch-modules -->

                <!-- Users -->
                <div id="module-<?php echo 'user'; ?>" class="catch-modules">
                    <div class="module-header <?php echo $options['user'] ? 'active' : 'inactive'; ?>">
                        <h3 class="module-title"><?php esc_html_e( 'Users', 'catch-ids' ); ?></h3>
                        <div class="switch">
                            <input type="checkbox" id="catchids_options[user]" class="catchids-input-switch" rel="user" <?php checked( true, $options['user'] ); ?> >
                            <label for="catchids_options[user]"></label>
                        </div>
                        <div class="loader"></div>
                    </div><!-- .module-header -->
                </div><!-- .catch-modules -->

                <!-- Comments -->
                <div id="module-<?php echo 'comment'; ?>" class="catch-modules">
                    <div class="module-header <?php echo $options['comment'] ? 'active' : 'inactive'; ?>">
                        <h3 class="module-title"><?php esc_html_e( 'Comments', 'catch-ids' ); ?></h3>
                        <div class="switch">
                            <input type="checkbox" id="catchids_options[comment]" class="catchids-input-switch" rel="comment" <?php checked( true, $options['comment'] ); ?> >
                            <label for="catchids_options[comment]"></label>
                        </div>
                        <div class="loader"></div>
                    </div><!-- .module-header -->
                </div><!-- .catch-modules -->

            </div><!-- .module-container -->

        </div><!-- .container -->
    </div> <!-- #dashboard -->

    <?php
        //Add footer
        require_once plugin_dir_path( dirname( __FILE__ ) ) . '/partials/footer.php';
    ?>
</div> <!-- Main Content-->
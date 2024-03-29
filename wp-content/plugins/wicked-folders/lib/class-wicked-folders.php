<?php

// Disable direct load
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

final class Wicked_Folders {

    private static $instance;

    private function __construct() {

		// Register autoload function
        spl_autoload_register( array( $this, 'autoload' ) );

		// Increased priority to 15 to accomodate Pods plugin which registers
		// it's custom post types at priority 11
        add_action( 'init',				array( $this, 'init' ), 15 );
		add_action( 'pre_get_posts', 	array( $this, 'pre_get_posts' ), 20 ); // Must be called after pre_get_posts action in Wicked_Folders_Admin

		// Initalize admin singleton
		Wicked_Folders_Admin::get_instance();

		// Initalize AJAX singleton
		Wicked_Folders_Ajax::get_instance();

    }

    /**
	 * Plugin activation hook.
	 */
	public static function activate() {

		// Check for multisite
		if ( is_multisite() && is_plugin_active_for_network( dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'wicked-folders.php' ) ) {
			$sites = get_sites( array( 'fields' => 'ids' ) );
			foreach ( $sites as $id ) {
				switch_to_blog( $id );
				Wicked_Folders::activate_site();
				restore_current_blog();
			}
		} else {
			Wicked_Folders::activate_site();
		}

    }

	/**
	 * Activates/initalizes settings for a single site.
	 */
	public static function activate_site() {

		$post_types = get_option( 'wicked_folders_post_types', false );
		$taxonomies = get_option( 'wicked_folders_taxonomies', false );
		$state 		= get_user_meta( get_current_user_id(), 'wicked_folders_plugin_state', true );
		$enable_folder_pages = get_option( 'wicked_folders_enable_folder_pages', null );

		// Enable folders for pages by default
		if ( ! $post_types ) {
			$post_types = array( 'page' );
			update_option( 'wicked_folders_post_types', $post_types );
			update_option( 'wicked_folders_dynamic_folder_post_types', $post_types );
		}

		if ( ! $taxonomies ) {
			$taxonomies = array( 'wicked_page_folders' );
			update_option( 'wicked_folders_taxonomies', $taxonomies );
		}

		if ( ! $state ) {
			$state = array();
			update_user_meta( get_current_user_id(), 'wicked_folders_plugin_state', $state );
		}

		if ( null === $enable_folder_pages ) {
			// Note: Set to zero instead of false due to WP bug.  See
			// https://core.trac.wordpress.org/ticket/40007
			update_option( 'wicked_folders_enable_folder_pages', 0 );
		}

    }

    public static function autoload( $class ) {

        $file 	= false;
        $files  = array(
			'Wicked_Folders_Screen_State' 				=> 'lib/class-wicked-folders-screen-state.php',
			'Wicked_Folders_Ajax' 						=> 'lib/class-wicked-folders-ajax.php',
			'Wicked_Folders_Admin' 						=> 'lib/class-wicked-folders-admin.php',
			'Wicked_Folders_WP_List_Table' 				=> 'lib/class-wicked-folders-wp-list-table.php',
			'Wicked_Folders_WP_Posts_List_Table' 		=> 'lib/class-wicked-folders-wp-posts-list-table.php',
			'Wicked_Folders_Posts_List_Table' 			=> 'lib/class-wicked-folders-posts-list-table.php',
			'Wicked_Folders_Folder' 					=> 'lib/class-wicked-folders-folder.php',
			'Wicked_Folders_Tree_View' 					=> 'lib/class-wicked-folders-tree-view.php',
			'Wicked_Folders_Term_Folder' 				=> 'lib/class-wicked-folders-term-folder.php',
			'Wicked_Folders_Dynamic_Folder'   			=> 'lib/class-wicked-folders-dynamic-folder.php',
			'Wicked_Folders_Author_Dynamic_Folder'  	=> 'lib/class-wicked-folders-author-dynamic-folder.php',
			'Wicked_Folders_Date_Dynamic_Folder'   		=> 'lib/class-wicked-folders-date-dynamic-folder.php',
			'Wicked_Folders_Term_Dynamic_Folder'   		=> 'lib/class-wicked-folders-term-dynamic-folder.php',
			'Wicked_Common' 							=> 'lib/class-wicked-common.php',
			'Wicked_Folders_Unassigned_Dynamic_Folder' 	=> 'lib/class-wicked-folders-unassigned-dynamic-folder.php',
        );

		if ( version_compare( get_bloginfo( 'version' ), '4.7.0', '<' ) ) {
			$files['Wicked_Folders_WP_List_Table'] = 'lib/compat/class-wicked-folders-wp-list-table.php';
		}

        if ( array_key_exists( $class, $files ) ) {
            $file = dirname( dirname( __FILE__ ) ) . '/' . $files[ $class ];
        }

        if ( $file ) {
            $file = str_replace( '/', DIRECTORY_SEPARATOR, $file );
            include_once( $file );
        }

	}

    public static function get_instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new Wicked_Folders();
		}
		return self::$instance;
	}

    public function init() {

        $this->register_taxonomies();

		Wicked_Folders_Admin::get_instance()->save_settings();

		// Update existing installs that don't have the dynamic folders option set yet
		$post_types = get_option( 'wicked_folders_dynamic_folder_post_types', false );

		if ( false === $post_types ) {
			update_option( 'wicked_folders_dynamic_folder_post_types', $this->post_types() );
		}

    }

    private function register_taxonomies() {

        $post_types = Wicked_Folders::post_type_objects();

        // Create a folder taxonomy for each post type
        foreach ( $post_types as $post_type ) {

            $tax_name = 'wicked_' . $post_type->name . '_folders';

            $labels = array(
                'name'			=> sprintf( _x( '%1$s Folders', 'Taxonomy plural name', 'wicked-folders' ), $post_type->labels->singular_name ),
                'singular_name' => sprintf( _x( '%1$s Folder', 'Taxonomy singular name', 'wicked-folders' ), $post_type->labels->singular_name ),
                'all_items'		=> sprintf( __( 'All %1$s Folders', 'wicked-folders' ), $post_type->labels->singular_name ),
                'edit_item'		=> __( 'Edit Folder', 'wicked-folders' ),
                'update_item'	=> __( 'Update Folder', 'wicked-folders' ),
                'add_new_item'	=> __( 'Add New Folder', 'wicked-folders' ),
                'new_item_name' => __( 'Add Folder Name', 'wicked-folders' ),
                'menu_name'     => sprintf( __( 'Manage %1$s Folders', 'wicked-folders' ), $post_type->labels->singular_name ),
                'search_items'  => __( 'Search Folders', 'wicked-folders' ),
				'parent_item' 	=> __( 'Parent Folder', 'wicked-folders' ),
            );

            $args = array(
                'label'				=> _x( 'Folders', 'Taxonomy plural name', 'wicked-folders' ),
                'labels'			=> $labels,
                'show_tagcloud' 	=> false,
                'hierarchical'		=> true,
                'public'        	=> false,
                'show_ui'       	=> true,
                'show_in_menu'  	=> false,
                'show_admin_column' => true,
                'rewrite'			=> false,
            );

			if ( 'attachment' == $post_type->name && get_option( 'wicked_folders_enable_taxonomy_pages', false ) ) {
				$args['show_in_menu'] 	= true;
				$args['labels']['menu_name'] = __( 'Manage Folders', 'wicked-folders' );
			}

			register_taxonomy( $tax_name, $post_type->name, $args );

        }

    }

	/**
	 * Gets the posts types that folders are enabled for.
	 *
	 * @return array
	 *  Array of post types.
	 */
	public static function post_types() {
		$post_types = get_option( 'wicked_folders_post_types', array() );
		return apply_filters( 'wicked_folders_post_types', $post_types );
	}

	/**
	 * Gets the posts type objects that folders are enabled for.
	 *
	 * @return array
	 *  Array of WP_Post_Type Object objects.
	 */
	public static function post_type_objects() {
		$post_types 		= array();
		$enabled_post_types = Wicked_Folders::post_types();
		$all_post_types 	= get_post_types( array(
			'show_ui' => true,
		), 'objects' );
		foreach ( $all_post_types as $post_type ) {
			if ( in_array( $post_type->name, $enabled_post_types ) ) {
				$post_types[] = $post_type;
			}
		}
		return apply_filters( 'wicked_folders_post_type_objects', $post_types );
	}

	/**
	 * Gets the posts types that dynamic folders are enabled for.
	 *
	 * @return array
	 *  Array of post types.
	 */
	public static function dynamic_folder_post_types() {
		$post_types = get_option( 'wicked_folders_dynamic_folder_post_types', array() );
		return apply_filters( 'wicked_folders_dynamic_folder_post_types', $post_types );
	}

	/**
	 * Gets the taxonomies that folders are enabled for.
	 *
	 * @return array
	 *  Array of taxonomy system names.
	 */
	public static function taxonomies() {
		$taxonomies = get_option( 'wicked_folders_taxonomies', array() );
		return apply_filters( 'wicked_folders_taxonomies', $taxonomies );
	}

	/**
	 * Moves an object to the specified folder.
	 *
	 * TODO: maybe change to two functions...move folder and move post?
	 *
	 * @param string $object_type
	 *  'folder' or 'post' for all other objects
	 *
	 * @param int $object_id
	 *  The ID of the object being moved.
	 *
	 * @param int $destination_folder_id
	 *  The ID of the folder that the object is being moved to.
	 *
	 * @param int $source_folder_id
	 *  For post object types, the folder ID the object is being moved from.
	 *
	 * @return bool
	 *  True on success, false on failure.
	 */
	public static function move_object( $object_type, $object_id, $destination_folder_id, $source_folder_id = false ) {

		if ( 'folder' == $object_type ) {
			$object = get_term( $object_id );
			$result = wp_update_term( $object->term_id, $object->taxonomy, array(
				'parent' => $destination_folder_id,
			) );
			return !! is_wp_error( $result );
		}

		if ( 'post' == $object_type ) {
			// Get the folder term
			$folder = get_term( $destination_folder_id );
			// Get the folders that the post is currently assigned to
			$terms 	= wp_get_object_terms( $object_id, $folder->taxonomy, array(
				'fields' => 'ids',
			) );
			// Add the destination folder
			if ( 0 !== $destination_folder_id ) {
				$terms[] = $destination_folder_id;
			}
			$terms = array_unique( $terms );
			// Remove the object from the source folder
			if ( false !== $source_folder_id && $source_folder_id != $destination_folder_id ) {
				$source_folder_index = array_search( $source_folder_id, $terms );
				if ( false !== $source_folder_index ) {
					unset( $terms[ $source_folder_index ] );
				}
			}
			$result = wp_set_object_terms( $object_id, $terms, $folder->taxonomy );
		}

	}

	/**
	 * Gets a folder.
	 *
	 * @param string $id
	 *  The folder's ID.
	 *
	 * @param string $post_type
	 *  The post type name that the folder is registered with.
	 *
	 * @param string $taxonomy
	 *  The taxonomy name to get folders from.  If not specified,
	 *  wicked_{$post_type}_folders will be used.
	 *
	 * @return Wicked_Folders_Folder|bool
	 *  A Wicked_Folders_Folder object or false if the folder doesn't exist.
	 */
	public static function get_folder( $id, $post_type, $taxonomy = false ) {

		if ( ! $taxonomy ) $taxonomy = "wicked_{$post_type}_folders";

		$term = get_term( ( int ) $id, $taxonomy );

		if ( ! $term || is_wp_error( $term ) ) {
			$folder = false;
		} else {
			$folder = new Wicked_Folders_Term_Folder( array(
				'id' 		=> $term->term_id,
				'name' 		=> $term->name,
				'parent' 	=> $term->parent,
				'taxonomy' 	=> $term->taxonomy,
				'post_type' => $post_type,
			) );
		}

		$filter_args = array(
			'id' 		=> $id,
			'post_type' => $post_type,
			'taxonomy' 	=> $taxonomy,
		);

		return apply_filters( 'wicked_folders_get_folder', $folder, $filter_args );

	}

	/**
     * Gets the folder objects for the specified post type and taxonomy.
     *
	 * @param string $post_type
	 *  The post type name.
	 *
	 * @param string $taxonomy
	 *  The taxonomy name to get folders from.  If not specified,
	 *  wicked_{$post_type}_folders will be used.
	 *
     * @return array
     *  Array of Wicked_Folders_Folder objects.
     */
    public static function get_folders( $post_type, $taxonomy = false ) {

		$cache_key 			= array();
		$post_type_object 	= get_post_type_object( $post_type );

		if ( ! $taxonomy ) $taxonomy = "wicked_{$post_type}_folders";

        $filter_args = array(
			'post_type' => $post_type,
            'taxonomy' 	=> $taxonomy,
        );

        $folders = array(
            new Wicked_Folders_Folder( array(
				'id' 		=> 0,
				//'name' => sprintf( __( 'All %1$s', 'wicked-folders' ), $post_type_object->label ),
				'name' 		=> __( 'All Folders', 'wicked-folders' ),
				'parent' 	=> 'root',
				'post_type' => $post_type,
				'taxonomy' 	=> $taxonomy,
			) ),
        );

		if ( version_compare( get_bloginfo( 'version' ), '4.5.0', '<' ) ) {
			$terms = get_terms( $taxonomy, array(
				'hide_empty' 	=> false,
			) );
		} else {
			$terms = get_terms( array(
				'taxonomy' 		=> $taxonomy,
				'hide_empty' 	=> false,
			) );
		}

		if ( ! is_wp_error( $terms ) ) {
			// Check cache
			foreach ( $terms as $term ) {
				$cache_key[] = $term->term_id . '-' . $term->parent;
			}

			$cache_key = "wicked_folders_{$post_type}_folder_cache_" . md5( join( '_', $cache_key ) );

			if ( false !== ( $cached_folders = get_transient( $cache_key ) ) ) {
				$folders = $cached_folders;
			} else {
				foreach ( $terms as $term ) {
					$folders[] = new Wicked_Folders_Term_Folder( array(
						'id' 		=> $term->term_id,
						'name' 		=> $term->name,
						'parent' 	=> $term->parent,
						'post_type' => $post_type,
						'taxonomy' 	=> $taxonomy,
					) );
				}
				set_transient( $cache_key, $folders, DAY_IN_SECONDS );
			}

		}

		// Check if dynamic folders are enabled for this post type
		if ( self::dynamic_folders_enabled_for( $post_type ) ) {

			$dynamic_folders = array(
				new Wicked_Folders_Folder( array(
					'id' 		=> 'dynamic_root',
					'name' 		=> __( 'Dynamic Folders', 'wicked-folders' ),
					'parent' 	=> 'root',
					'post_type' => $post_type,
					'taxonomy' 	=> $taxonomy,
				) ),
			);

			$date_folders 	= self::get_instance()->get_date_dynamic_folders( $post_type, $taxonomy );
			$author_folders = self::get_instance()->get_author_dynamic_folders( $post_type, $taxonomy );
			$term_folders 	= self::get_instance()->get_term_dynamic_folders( $post_type, $taxonomy );
			$unassigned 	= array( new Wicked_Folders_Unassigned_Dynamic_Folder( array(
				'id' 		=> 'unassigned_dynamic_folder',
				'name' 		=> __( 'Unassigned Items', 'wicked-folders' ),
				'parent' 	=> 'dynamic_root',
				'post_type' => $post_type,
				'taxonomy' 	=> $taxonomy,
			) ) );

			$dynamic_folders = array_merge( $dynamic_folders, $unassigned, $author_folders, $date_folders, $term_folders );

			$dynamic_folders = ( array ) apply_filters( 'wicked_folders_get_dynamic_folders', $dynamic_folders, $filter_args );

			$folders = array_merge( $dynamic_folders, $folders );

		}

		foreach ( $folders as &$folder ) {
			$folder->type = get_class( $folder );
		}

        return ( array ) apply_filters( 'wicked_folders_get_folders', $folders, $filter_args );

    }

	/**
	 * Returns true if folders are enabled for the specified post type, false
	 * if not.
	 *
	 * @param string $post_type
	 *  The post type name to check.
	 *
	 * @return bool
	 */
	public static function enabled_for( $post_type ) {

		$post_types = Wicked_Folders::post_types();

		return in_array( $post_type, $post_types );

	}

	/**
	 * Returns true if dynamic folders are enabled for the specified post type,
	 * false if not.
	 *
	 * @param string $post_type
	 *  The post type name to check.
	 *
	 * @return bool
	 */
	public static function dynamic_folders_enabled_for( $post_type ) {

		$post_types = Wicked_Folders::dynamic_folder_post_types();

		return in_array( $post_type, $post_types );

	}

	/**
	 * Returns the plugin's version.
	 */
	public static function plugin_version() {

		static $version = false;

		if ( ! $version && function_exists( 'get_plugin_data' ) ) {
			$plugin_data 	= get_plugin_data( dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'wicked-folders.php' );
			$version 		= $plugin_data['Version'];
		}

		return $version;

	}

	/**
	 * The timezone string set on the site's General Settings page.
	 *
	 * Thanks to this article on SkyVerge for handling UTC offsets:
	 * https://www.skyverge.com/blog/down-the-rabbit-hole-wordpress-and-timezones/
	 *
	 * @return string
	 *  A string that can be used to instantiate a DateTimeZone object.
	 */
	public static function timezone_identifier() {

		// If site timezone string exists, return it
		if ( $timezone = get_option( 'timezone_string' ) ) {
			return $timezone;
		}

		// Get UTC offset, if it isn't set then return UTC
		if ( 0 === ( $utc_offset = get_option( 'gmt_offset', 0 ) ) ) {
			return 'UTC';
		}

		// Round offsets like 7.5 down to 7
		// TODO: explore if this is the right approach
		$utc_offset = round( $utc_offset, 0, PHP_ROUND_HALF_DOWN );

		// Adjust UTC offset from hours to seconds
		$utc_offset *= 3600;

		// Attempt to guess the timezone string from the UTC offset
		if ( $timezone = timezone_name_from_abbr( '', $utc_offset, 0 ) ) {
			return $timezone;
		}

		// Last try, guess timezone string manually
		$is_dst = date( 'I' );

		foreach ( timezone_abbreviations_list() as $abbr ) {
			foreach ( $abbr as $city ) {
				if ( $city['dst'] == $is_dst && $city['offset'] == $utc_offset ) {
					return $city['timezone_id'];
				}
			}
		}

		// Fallback to UTC
		return 'UTC';

	}

	/**
	 * Returns a dynamically generated collection of date folders.
	 *
	 * @param string $post_type
	 *  The post type to generate folders for.
	 *
	 * @return array
	 *  Array of Wicked_Folders_Date_Dynamic_Folder objects.
	 */
	public function get_date_dynamic_folders( $post_type, $taxonomy ) {
		global $wpdb;

		$cache_key 	= array();
		$years 		= array();
		$folders 	= array();

		// Fetch post dates
		if ( 'attachment' == $post_type ) {
			$results = $wpdb->get_results( "SELECT post_date FROM {$wpdb->prefix}posts WHERE post_type = 'attachment' ORDER BY post_date ASC" );
		} else {
			$results = $wpdb->get_results( $wpdb->prepare( "SELECT post_date FROM {$wpdb->prefix}posts WHERE post_type = %s AND post_status NOT IN ('trash', 'inherit', 'auto-draft') ORDER BY post_date ASC", $post_type ) );
		}

		// Check for cache
		foreach ( $results as $row ) {
			// Skip blank dates
			if ( '0000-00-00 00:00:00' == $row->post_date ) continue;

			$timezone = new DateTimeZone( Wicked_Folders::timezone_identifier() );

			$date = new DateTime( $row->post_date, $timezone );

			$cache_key[] = $date->format( 'Ymd' );

		}

		$cache_key = 'wicked_folders_dynamic_date_cache_' . md5( 'dynamic_date_' . join( '_', $cache_key ) );

		if ( false !== ( $cached_folders = get_transient( $cache_key ) ) ) {
			return $cached_folders;
		}

		// Organize dates into an array that will be easy to loop through
		foreach ( $results as $row ) {

			// Skip blank dates
			if ( '0000-00-00 00:00:00' == $row->post_date ) continue;

			$timezone = new DateTimeZone( Wicked_Folders::timezone_identifier() );

			$date = new DateTime( $row->post_date, $timezone );

			$year 	= $date->format( 'Y' );
			$month 	= $date->format( 'm' );
			$day 	= $date->format( 'd' );

			//$dates[ $year ][ $month ][ $day ] = array();
			if ( ! isset( $years[ $year ] ) ) {
				$years[ $year ] = array(
					'year' 		=> $year,
					'name' 		=> $year,
					'months' 	=> array(),
				);
			}

			if ( ! isset( $years[ $year ]['months'][ $month ] ) ) {
				$years[ $year ]['months'][ $month ] = array(
					'month' => $month,
					'name' 	=> $date->format( 'F' ),
					'days' 	=> array(),
				);
			}

			if ( ! isset( $years[ $year ]['months'][ $month ]['days'][ $day ] ) ) {
				$years[ $year ]['months'][ $month ]['days'][ $day ] = array(
					'day' 	=> $day,
					'name' 	=> $date->format( 'j' ),
				);
			}

		}

		$folders[] = new Wicked_Folders_Date_Dynamic_Folder( array(
				'id' 		=> 'dynamic_date',
				'name' 		=> __( 'All Dates', 'wicked-folders' ),
				'parent' 	=> 'dynamic_root',
				'post_type' => $post_type,
				'taxonomy' 	=> $taxonomy,
			)
		);

		// Create our folders
		foreach ( $years as $year ) {

			$year_id = 'dynamic_date_' . $year['year'];

			$folders[] = new Wicked_Folders_Date_Dynamic_Folder( array(
					'id' 		=> $year_id,
					'name' 		=> $year['name'],
					'parent' 	=> 'dynamic_date',
					'post_type' => $post_type,
					'taxonomy' 	=> $taxonomy,
				)
			);

			foreach ( $year['months'] as $month ) {

				$month_id = 'dynamic_date_' . $year['year'] . '_' . $month['month'];

				$folders[] = new Wicked_Folders_Date_Dynamic_Folder( array(
						'id' 		=> $month_id,
						'name' 		=> $month['name'],
						'parent' 	=> $year_id,
						'post_type' => $post_type,
						'taxonomy' 	=> $taxonomy,
					)
				);

				foreach ( $month['days'] as $day ) {

					$day_id = 'dynamic_date_' . $year['year'] . '_' . $month['month'] . '_' . $day['day'];

					$folders[] = new Wicked_Folders_Date_Dynamic_Folder( array(
							'id' 		=> $day_id,
							'name' 		=> $day['name'],
							'parent' 	=> $month_id,
							'post_type' => $post_type,
							'taxonomy' 	=> $taxonomy,
						)
					);

				}
			}
		}

		set_transient( $cache_key, $folders, DAY_IN_SECONDS );

		return $folders;

	}

	/**
	 * Returns a dynamically generated collection of author folders.
	 *
	 * @param string $post_type
	 *  The post type to generate folders for.
	 *
	 * @return array
	 *  Array of Wicked_Folders_Author_Dynamic_Folder objects.
	 */
	public function get_author_dynamic_folders( $post_type, $taxonomy ) {

		// TODO: possibly cache

		global $wpdb;

		$folders = array();

		// Fetch authors
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT u.ID, u.display_name FROM {$wpdb->prefix}posts p INNER JOIN {$wpdb->prefix}users u ON p.post_author = u.ID AND post_status NOT IN ('trash', 'auto-draft') WHERE post_type = %s ORDER BY u.display_name ASC", $post_type ) );

		$folders[] = new Wicked_Folders_Author_Dynamic_Folder( array(
				'id' 		=> 'dynamic_author',
				'name' 		=> __( 'All Authors', 'wicked-folders' ),
				'parent' 	=> 'dynamic_root',
				'post_type' => $post_type,
				'taxonomy' 	=> $taxonomy,
			)
		);

		foreach ( $results as $row ) {

			$folders[] = new Wicked_Folders_Author_Dynamic_Folder( array(
					'id' 		=> 'dynamic_author_' . $row->ID,
					'name' 		=> $row->display_name,
					'parent' 	=> 'dynamic_author',
					'post_type' => $post_type,
					'taxonomy' 	=> $taxonomy,
				)
			);

		}

		return $folders;

	}

	public function get_term_dynamic_folders( $post_type, $taxonomy ) {

		$cache_key 			= array();
		$folders 			= array();
		$original_taxonomy 	= $taxonomy;
		$taxonomies 		= get_taxonomies( array(
			'object_type' 	=> array( $post_type ),
			'hierarchical' 	=> true,
			'show_ui' 		=> true,
		), 'objects' );

		if ( is_array( $taxonomies ) ) {
			foreach ( $taxonomies as $taxonomy ) {

				// Skip folders taxonomy
				if ( "wicked_{$post_type}_folders" == $taxonomy->name ) continue;

				$terms 		= array();
				$cache_key 	= array();

				if ( version_compare( get_bloginfo( 'version' ), '4.5.0', '<' ) ) {
					$terms = get_terms( $taxonomy->name, array(
						'hide_empty' 	=> true,
					) );
				} else {
					$terms = get_terms( array(
						'taxonomy' 		=> $taxonomy->name,
						'hide_empty' 	=> true,
					) );
				}

				if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {

					foreach ( $terms as $term ) {
						$cache_key[] = $term->term_id . '-' . $term->parent;
					}

					$cache_key = 'wicked_folders_dynamic_term_' . $taxonomy->name . '_cache_' . md5( 'dynamic_term_' . $taxonomy->name . '_' . join( '_', $cache_key ) );

					if ( false !== ( $cached_folders = get_transient( $cache_key ) ) ) {
						$folders = array_merge( $folders, $cached_folders );
					} else {
						$folders[] = new Wicked_Folders_Term_Dynamic_Folder( array(
								'id' 		=> 'dynamic_term_' . $taxonomy->name,
								'name' 		=> $taxonomy->labels->name,
								'parent' 	=> 'dynamic_root',
								'post_type' => $post_type,
								'taxonomy' 	=> $original_taxonomy,
							)
						);

						foreach ( $terms as $term ) {
							$id 	= 'dynamic_term_' . $taxonomy->name . '__id__' . $term->term_id;
							$parent = 'dynamic_term_' . $taxonomy->name;

							if ( $term->parent ) {
								$parent .=  '__id__' . $term->parent;
							}

							$folders[] = new Wicked_Folders_Term_Dynamic_Folder( array(
								'id' 		=> $id,
								'name' 		=> $term->name,
								'parent' 	=> $parent,
								'post_type' => $post_type,
								'taxonomy' 	=> $original_taxonomy,
							) );
						}

						set_transient( $cache_key, $folders, DAY_IN_SECONDS );
					}
				}
			}
		}

		return $folders;

	}

	/**
	 * Returns an instance of a dynamic folder or false if the item is not a
	 * dynamic folder.
	 *
	 * @param string $class
	 *  The class name of the dynamic folder to get.
	 *
	 * @return Wicked_Folders_Dynamic_Folder|bool
	 *  A dynamic folder instance or false.
	 */
	public static function get_dynamic_folder( $class, $id, $post_type, $taxonomy = false ) {

		if ( ! class_exists( $class ) ) return;

		if ( ! $taxonomy ) $taxonomy = "wicked_{$post_type}_folders";

		$folder = new $class( array(
			'id' 		=> $id,
			'post_type' => $post_type,
			'taxonomy' 	=> $taxonomy,
		) );

		if ( is_a( $folder, 'Wicked_Folders_Dynamic_Folder' ) ) {
			return $folder;
		} else {
			return false;
		}

	}

	/**
	 * Utility function that removes queries for the specified taxonomy from
	 * the query.
	 *
	 * @param WP_Query_Object $query
	 *  The query to remove the tax query from.
	 *
	 * @param string $taxonomy
	 *  The name of the taxonomy to remove
	 */
	public static function remove_tax_query( $query, $taxonomy ) {
		$tax_queries = $query->get( 'tax_query' );
		if ( is_array( $tax_queries ) ) {
			for ( $i = count( $tax_queries ); $i > -1; $i-- ) {
				// Make sure index exists (index could be something non-numeric
				// like 'operator')
				if ( isset( $tax_queries[ $i ]['taxonomy'] ) ) {
					if ( $taxonomy == $tax_queries[ $i ]['taxonomy'] ) {
						unset( $tax_queries[ $i ] );
					}
				}
			}
			$query->set( 'tax_query', $tax_queries );
		}
	}

	/**
	 * Checks if upselling is enabled.
	 */
	public static function is_upsell_enabled() {
		$upsell = true;
		if ( defined( 'WICKED_PLUGINS_ENABLE_UPSELL' ) ) {
			$upsell = WICKED_PLUGINS_ENABLE_UPSELL;
		}
		return apply_filters( 'wicked_plugins_enable_upsell', $upsell );
	}

	/**
	 * Checks the query and determines if the query is being ordered by a
	 * folder's sort order.
	 *
	 * @return bool
	 */
	public static function is_folder_order_query( WP_Query $query ) {
		$orderby = $query->get( 'orderby' );
		if ( is_array( $orderby ) ) {
			return array_key_exists( 'wicked_folder_order', $orderby );
		} else {
			if ( false !== strpos( $orderby, 'wicked_folder_order' ) ) {
				return true;
			}
		}
		return false;
		/*
		$is_folder_sorted_query = false;
		$meta_key 				= $query->get( 'meta_key' );
		// Folder sort meta key must be present to sort by folder
		if ( 0 === strpos( $meta_key, '_wicked_folders_sort_' ) ) {
			// Only worry about queries that are ordered by meta value
			if ( is_array( $query->query_vars['orderby'] ) ) {
				foreach ( $query->query_vars['orderby'] as $orderby => $order ) {
					if ( 'meta_value' == $orderby || 'meta_value_num' == $orderby ) {
						$is_folder_sorted_query = true;
					}
				}
			} else {
				if ( false !== strpos( $query->query_vars['orderby'], 'meta_value' ) ) {
					$is_folder_sorted_query = true;
				}
			}
		}
		return $is_folder_sorted_query;
		*/
	}

	public function pre_get_posts( $query ) {

		$this->apply_folder_order( $query );

	}

	/**
	 * Alters queries that are ordered by wicked_folder_order to order by the
	 * folder order meta key.
	 *
	 * @param WP_Query $query
	 *  The query to alter.
	 */
	private function apply_folder_order( WP_Query $query ) {

		// Skip queries that aren't being sorted by folder order
		if ( ! $this->is_folder_order_query( $query ) ) return;

		$meta_key 	= false;
		$folder_id 	= false;
		$taxonomy 	= false;
		$orderby 	= $query->get( 'orderby' );
		$tax_queries= $query->get( 'tax_query' );

		// Convert orderby to array format
		if ( ! is_array( $orderby ) ) {
			$fields 	= explode( ' ', $orderby );
			$orderby 	= array();
			foreach ( $fields as $field ) {
				$orderby[ $field ] = $query->get( 'order' );
			}
		}

		// Determine the meta key to sort by from the folder tax query
		if ( is_array( $tax_queries ) ) {
			foreach ( $tax_queries as $tax_query ) {
				if ( preg_match( '/^wicked_(.*)_folders$/', $tax_query['taxonomy'] ) ) {
					$taxonomy = $tax_query['taxonomy'];
					// Only queries for a specific (i.e. one) folder can be ordered
					// by folder order
					if ( is_array( $tax_query['terms'] ) && 1 == count( $tax_query['terms'] ) ) {
						$folder_id = reset( $tax_query['terms'] );
					} elseif ( is_numeric( $tax_query['terms'] ) ) {
						$folder_id = ( int ) $tax_query['terms'];
					}
					if ( false !== $folder_id ) {
						$meta_key = '_wicked_folder_order__' . $taxonomy . '__' . $folder_id;
					}
				}
			}
		}

		if ( $meta_key ) {
			$this->initalize_folder_order( $folder_id, $taxonomy );
			// Create a new order by clause
			$a = array( 'meta_value_num' => $orderby[ 'wicked_folder_order'] );
			// Add the new order by clause
			Wicked_Common::array_insert_after_key( $orderby, 'wicked_folder_order', $a );
			// Remove folder order clause
			unset( $orderby[ 'wicked_folder_order'] );
			// If a secondary orderby isn't specified, order by title
			$orderby['title'] = 'ASC';
			// Update the query
			$query->set( 'orderby', $orderby );
			$query->set( 'meta_key', $meta_key );
		}

	}

	/**
	 * Inserts a folder order meta key for each post in the folder that doesn't
	 * already have a folder order meta key.
	 */
	public static function initalize_folder_order( $folder_id, $taxonomy ) {
		global $wpdb;

		$meta_key = '_wicked_folder_order__' . $taxonomy . '__' . $folder_id;

		$wpdb->query( "
			INSERT INTO
				{$wpdb->prefix}postmeta (post_id, meta_key, meta_value)
			SELECT
				p.ID, '{$meta_key}', 0
			FROM
				{$wpdb->prefix}posts p
			INNER JOIN
				{$wpdb->prefix}term_relationships tr ON p.ID = tr.object_id
			WHERE
				tr.term_taxonomy_id = {$folder_id} AND p.ID NOT IN (SELECT post_Id FROM {$wpdb->prefix}postmeta WHERE meta_key = '{$meta_key}')
		" );

	}
}

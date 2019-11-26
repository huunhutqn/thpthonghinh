<?php
/**
Plugin Name: Physical Custom Upload Dir for Real Media Library
Plugin URI: http://matthias-web.de
Description: When uploading files to your media library folder the files will be placed to the given physical folder.
Author: Matthias Günter
Version: 1.0.4
Author URI: http://matthias-web.de
Licence: GPLv2
*/

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('upload_dir_real_media_library') ) :

class upload_dir_real_media_library {
    /**
     * @see wp_die
     * @see delete_attachment
     */
    private $deleteDirs = array();
    
    private $mkdirPath = "";
    
    /**
     * C'tor
     */
	function __construct() {
	    add_action('init',                              array($this, 'init'));
        //$this->delete_folder("/home/ubuntu/workspace/wp-content/uploads/documents");
	}
	
	public function init() {
        if ( !defined('RML_VERSION') || version_compare(RML_VERSION, "2.8", "<")) {
            if ( is_admin() ) {
                add_action( 'admin_notices', array( $this, 'admin_notices' ), 10, 3 );
            }
        }else{
    	    // Actions and filters
    		add_filter('wp_handle_upload_prefilter',        array($this, 'handle_pre_upload'));
            add_filter('wp_handle_upload',                  array($this, 'handle_upload'));
            add_filter('delete_attachment',                 array($this, 'delete_attachment'));
            add_filter('wp_die_ajax_handler',               array($this, 'wp_die'));
            add_filter('wp_die_handler',                    array($this, 'wp_die'));
        }
	}
	
	public function admin_notices() {
?>
<div class="notice notice-error is-dismissible">
    <p>The plugin <a href="https://codecanyon.net/item/wordpress-real-media-library-media-categories-folders/13155134" target="_blank"><b>Real Media Library</b></a> is not active (maybe not installed neither) or the version of Real Media Library is < 2.8 (please update).</p>
</div>
<?php
	}
	
	/**
	 * Delete folder at the end of wp_die
	 */
	public function delete_attachment($postId) {
	     $this->deleteDirs[] = dirname(get_attached_file($postId));
	}
	
	/**
	 * At the end of the delete process, delete the given folders if they are empty
	 */
	public function wp_die($str) {
	    $delete = array_unique($this->deleteDirs);
	    foreach ($delete as $value) {
	        $this->delete_folder($value);
	    }
	    $this->deleteDirs = array();
	    return $str;
	}
	
	/**
     * This is called before the upload progress is started so the
     * real upload dir filter can be set.
     * 
     * @see this::real_upload_dir
     */
    public function handle_pre_upload($file){
        add_filter('upload_dir', array($this, 'real_upload_dir'));
        return $file;
    }
    
    /**
     * This is called just before the upload progress so the
     * real upload dir filter can be removed.
     * 
     * @see this::real_upload_dir
     */
    public function handle_upload($fileinfo){
        remove_filter('upload_dir', array($this, 'real_upload_dir'));
        return $fileinfo;
    }
    
    /**
     * This sets the sub dir for the given folder.
     * 
     * @hooked upload_dir
     */
    public function real_upload_dir($path){
        $folder = $this->getFolderFromRequest();
        if ($folder !== null) {
            // Get path depending RML version
            if (version_compare(RML_VERSION, "3.3", "<")) {
                $customdir = '/' . $folder->getAbsolutePath();
            }else{
                $customdir = '/' . $folder->getPath("/", "_wp_rml_sanitize_filename");
            }
            
            // Modify pathes
            $path['path']    = str_replace($path['subdir'], '', $path['path']); // remove default subdir (year/month)
            $path['url']     = str_replace($path['subdir'], '', $path['url']);      
            $path['subdir']  = $customdir;
            $path['path']   .= $customdir;
            $path['url']    .= $customdir;
        }
        return $path;
    }
    
    /**
     * Get the folder id from the upload request.
     * 
     * @return null or Folder object
     */
    private function getFolderFromRequest() {
        if (isset($_REQUEST["rmlFolder"])) {
            return wp_rml_get_object_by_id($_REQUEST["rmlFolder"]);
        }else if (isset($_REQUEST["__rml_folder_id"])) {
            return wp_rml_get_object_by_id($_REQUEST["__rml_folder_id"]);
        }else{
            return null;
        }
    }
    
    /**
     * @see http://stackoverflow.com/questions/1833518/remove-empty-subfolders-with-php
     */
    private function removeEmptyDirs($path) {
        $empty=true;
        foreach (glob($path.DIRECTORY_SEPARATOR."*") as $file) {
            $empty &= is_dir($file) && $this->removeEmptyDirs($file);
        }
        return $empty && rmdir($path);
    }
    
    /**
     * Delete subfolders and then the given folder.
     */
    private function delete_folder($folder) {
        $upload_dir = wp_upload_dir();
        if (0 !== strpos($folder, $upload_dir["basedir"])) {
            return;
        }
        
        if (is_dir($folder) && $this->removeEmptyDirs($folder)) {
            $next = str_replace("/", DIRECTORY_SEPARATOR, $folder);
            $next = str_replace("\\", DIRECTORY_SEPARATOR, $next);
            $next = explode(DIRECTORY_SEPARATOR, $next);
            array_pop($next);
            $next = implode(DIRECTORY_SEPARATOR, $next);
    	    $this->delete_folder($next);
        }
	}
}


// initialize
new upload_dir_real_media_library();


// class_exists check 
endif;
	
?>
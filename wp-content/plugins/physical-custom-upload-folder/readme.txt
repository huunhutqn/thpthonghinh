=== Physical Custom Upload Folder ===
Contributors: mguenter
Tags: media library folders, folders, media categories, media folders, media category, media folder, rml, media library, real media library, files, media, organize, upload, ftp, uploads, wp-content
Stable tag: trunk
Requires at least: 4.0
Tested up to: 4.9
License: GPLv2

Physically organize your media library uploads (Real Media Library extension).

== Description ==

Do you know the **wp-content/uploads** folder? There, the files are stored in year/month based folders. This can be a very complicated and mass process, especially when you are working with a FTP client like FileZilla.

With this plugin you can determine where to store your uploads. This can also have some **SEO benefits**.

This plugin is an extension for the [WP Real Media Library](https://codecanyon.net/item/wordpress-real-media-library-media-categories-folders/13155134) plugin that allows you to create folders in media library.
This plugin needs version >= 2.8 of the WP Real Media Library plugin.

**Create thumbnails folders**: As you can see in the header screenshot above, there is also a folder with the thumbnails in it (of each image). This feature is not coming with this plugin, you need to install [WP Real Thumbnail Generator](https://codecanyon.net/item/wordpress-real-thumbnail-generator-bulk-regenerate-upload-folder/18937507).

**Moving already uploaded files**: This plugin does not allow to move the files physically when you move a file in the Real Media Library because WordPress uses the URL's in different places. It is very hard to maintain such a process. So this only works for new uploads.

== Installation ==

1. Goto your wordpress backend
2. Navigate to Plugins > Add new
3. Search for "Physical Custom Upload Folder"
4. "Install"

OR 

1. Copy the `upload_dir-real_media_library` folder into your `wp-content/plugins` folder
2. Activate the Real Media Library plugin via the plugins admin page
3. Upload a file to a folder and see what happens in your wp-content/uploads folder

== Changelog ==
= 1.0.4 =
* Fixed bug with pathes generation
* Removed unnecessery code blocks

= 1.0.3 =
* Fixed incompatibility with RML version 2.8.2

= 1.0.1 & 1.0.2 =
* Failure version commits

= 1.0.0 =
* Initial Release.
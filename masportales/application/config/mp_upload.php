<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$options = array(
	'articles' => array(
		'script_url' => _reg('site_url') .'upload',
  	'upload_dir' => _reg('base_path') . 'usrs/blog/',
  	'upload_url' => _reg('site_url') . 'usrs/blog/',
  	'param_name' => 'files',
  	// The php.ini settings upload_max_filesize and post_max_size
  	// take precedence over the following max_file_size setting:
  	'max_file_size' => null,
  	'min_file_size' => 1,
  	'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i',
  	'max_number_of_files' => null,
  	// Set the following option to false to enable non-multipart uploads:
  	'discard_aborted_uploads' => true,
  	// Set to true to rotate images based on EXIF meta data, if available:
  	'_orient_image' => false,
  	'image_versions' => array(
  		// Uncomment the following version to restrict the size of
  		// uploaded images. You can also add additional versions with
  		// their own upload directories:
  		'210x210' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/blog/',
  			'upload_url' => _reg('site_url') . 'usrs/blog/',
  			'max_width' => 210,
  			'max_height' => 210
  		),
  		'96x96' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/blog/',
  			'upload_url' => _reg('site_url') . 'usrs/blog/',
  			'max_width' => 96,
  			'max_height' => 96
  		),
  		'75x75' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/blog/',
  			'upload_url' => _reg('site_url') . 'usrs/blog/',
  			'max_width' => 75,
  			'max_height' => 75
  		)
  	)
	),'events' => array(
		'script_url' => _reg('site_url') .'upload',
  	'upload_dir' => _reg('base_path') . 'usrs/events/',
  	'upload_url' => _reg('site_url') . 'usrs/events/',
  	'param_name' => 'files',
  	// The php.ini settings upload_max_filesize and post_max_size
  	// take precedence over the following max_file_size setting:
  	'max_file_size' => null,
  	'min_file_size' => 1,
  	'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i',
  	'max_number_of_files' => null,
  	// Set the following option to false to enable non-multipart uploads:
  	'discard_aborted_uploads' => true,
  	// Set to true to rotate images based on EXIF meta data, if available:
  	'_orient_image' => false,
  	'image_versions' => array(
  		// Uncomment the following version to restrict the size of
  		// uploaded images. You can also add additional versions with
  		// their own upload directories:
  		'210x210' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/events/',
  			'upload_url' => _reg('site_url') . 'usrs/events/',
  			'max_width' => 210,
  			'max_height' => 210
  		),
  		'96x96' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/events/',
  			'upload_url' => _reg('site_url') . 'usrs/events/',
  			'max_width' => 96,
  			'max_height' => 96
  		)
  	)
	),
	'productos' => array(
		'script_url' => _reg('site_url') .'upload',
  	'upload_dir' => _reg('base_path') . 'usrs/productos/',
  	'upload_url' => _reg('site_url') . 'usrs/productos/',
  	'param_name' => 'files',
  	// The php.ini settings upload_max_filesize and post_max_size
  	// take precedence over the following max_file_size setting:
  	'max_file_size' => null,
  	'min_file_size' => 1,
  	'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i',
  	'max_number_of_files' => null,
  	// Set the following option to false to enable non-multipart uploads:
  	'discard_aborted_uploads' => true,
  	// Set to true to rotate images based on EXIF meta data, if available:
  	'_orient_image' => false,
  	'image_versions' => array(
  		// Uncomment the following version to restrict the size of
  		// uploaded images. You can also add additional versions with
  		// their own upload directories:
  		'220x220' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/productos/',
  			'upload_url' => _reg('site_url') . 'usrs/productos/',
  			'max_width' => 220,
  			'max_height' => 220
  		),
  		'75x75' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/productos/',
  			'upload_url' => _reg('site_url') . 'usrs/productos/',
  			'max_width' => 75,
  			'max_height' => 75
  		)
  	)
	),
	'basicads' => array(
		'script_url' => _reg('site_url') .'upload',
  	'upload_dir' => _reg('base_path') . 'usrs/clasificados/',
  	'upload_url' => _reg('site_url') . 'usrs/clasificados/',
  	'param_name' => 'files',
  	// The php.ini settings upload_max_filesize and post_max_size
  	// take precedence over the following max_file_size setting:
  	'max_file_size' => null,
  	'min_file_size' => 1,
  	'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i',
  	'max_number_of_files' => null,
  	// Set the following option to false to enable non-multipart uploads:
  	'discard_aborted_uploads' => true,
  	// Set to true to rotate images based on EXIF meta data, if available:
  	'_orient_image' => false,
  	'image_versions' => array(
  		// Uncomment the following version to restrict the size of
  		// uploaded images. You can also add additional versions with
  		// their own upload directories:
  		'210x210' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/clasificados/',
  			'upload_url' => _reg('site_url') . 'usrs/clasificados/',
  			'max_width' => 210,
  			'max_height' => 210
  		),
  		'75x75' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/clasificados/',
  			'upload_url' => _reg('site_url') . 'usrs/clasificados/',
  			'max_width' => 75,
  			'max_height' => 75
  		)
  	)
	),
	'empresas' => array(
		'script_url' => _reg('site_url') .'upload',
  	'upload_dir' => _reg('base_path') . 'usrs/empresas/',
  	'upload_url' => _reg('site_url') . 'usrs/empresas/',
  	'param_name' => 'files',
  	// The php.ini settings upload_max_filesize and post_max_size
  	// take precedence over the following max_file_size setting:
  	'max_file_size' => null,
  	'min_file_size' => 1,
  	'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i',
  	'max_number_of_files' => null,
  	// Set the following option to false to enable non-multipart uploads:
  	'discard_aborted_uploads' => true,
  	// Set to true to rotate images based on EXIF meta data, if available:
  	'_orient_image' => false,
  	'image_versions' => array(
  		// Uncomment the following version to restrict the size of
  		// uploaded images. You can also add additional versions with
  		// their own upload directories:
  		'210x210' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/empresas/',
  			'upload_url' => _reg('site_url') . 'usrs/empresas/',
  			'max_width' => 210,
  			'max_height' => 210
  		),
  		'210x96' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/empresas/',
  			'upload_url' => _reg('site_url') . 'usrs/empresas/',
  			'max_width' => 210,
  			'max_height' => 96
  		),
  		'96x96' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/empresas/',
  			'upload_url' => _reg('site_url') . 'usrs/empresas/',
  			'max_width' => 96,
  			'max_height' => 96
  		)
  	)
	),
	'micrositebanner' => array(
		'script_url' => _reg('site_url') .'upload',
  	'upload_dir' => _reg('base_path') . 'usrs/empresas/',
  	'upload_url' => _reg('site_url') . 'usrs/empresas/',
  	'param_name' => 'files',
  	// The php.ini settings upload_max_filesize and post_max_size
  	// take precedence over the following max_file_size setting:
  	'max_file_size' => null,
  	'min_file_size' => 1,
  	'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i',
  	'max_number_of_files' => null,
  	// Set the following option to false to enable non-multipart uploads:
  	'discard_aborted_uploads' => true,
  	// Set to true to rotate images based on EXIF meta data, if available:
  	'_orient_image' => false,
  	'image_versions' => array(
  		// Uncomment the following version to restrict the size of
  		// uploaded images. You can also add additional versions with
  		// their own upload directories:
  		'960x360' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/empresas/',
  			'upload_url' => _reg('site_url') . 'usrs/empresas/',
  			'max_width' => 960,
  			'max_height' => 360
  		),
  		'96x96' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/empresas/',
  			'upload_url' => _reg('site_url') . 'usrs/empresas/',
  			'max_width' => 96,
  			'max_height' => 96
  		)
  	)
	),
	'leader-board' => array(
		'script_url' => _reg('site_url') .'upload',
  	'upload_dir' => _reg('base_path') . 'usrs/banners/',
  	'upload_url' => _reg('site_url') . 'usrs/banners/',
  	'param_name' => 'files',
  	// The php.ini settings upload_max_filesize and post_max_size
  	// take precedence over the following max_file_size setting:
  	'max_file_size' => null,
  	'min_file_size' => 1,
  	'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i',
  	'max_number_of_files' => null,
  	// Set the following option to false to enable non-multipart uploads:
  	'discard_aborted_uploads' => true,
  	// Set to true to rotate images based on EXIF meta data, if available:
  	'_orient_image' => false,
  	'image_versions' => array(
  		// Uncomment the following version to restrict the size of
  		// uploaded images. You can also add additional versions with
  		// their own upload directories:
  		'leader-board' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/banners/',
  			'upload_url' => _reg('site_url') . 'usrs/banners/',
  			'max_width' => 728,
  			'max_height' => 90
  		),
  		'75x75' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/banners/',
  			'upload_url' => _reg('site_url') . 'usrs/banners/',
  			'max_width' => 75,
  			'max_height' => 75
  		)
  	)
	),
	'full-banner' => array(
		'script_url' => _reg('site_url') .'upload',
  	'upload_dir' => _reg('base_path') . 'usrs/banners/',
  	'upload_url' => _reg('site_url') . 'usrs/banners/',
  	'param_name' => 'files',
  	// The php.ini settings upload_max_filesize and post_max_size
  	// take precedence over the following max_file_size setting:
  	'max_file_size' => null,
  	'min_file_size' => 1,
  	'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i',
  	'max_number_of_files' => null,
  	// Set the following option to false to enable non-multipart uploads:
  	'discard_aborted_uploads' => true,
  	// Set to true to rotate images based on EXIF meta data, if available:
  	'_orient_image' => false,
  	'image_versions' => array(
  		// Uncomment the following version to restrict the size of
  		// uploaded images. You can also add additional versions with
  		// their own upload directories:
  		'full-banner' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/banners/',
  			'upload_url' => _reg('site_url') . 'usrs/banners/',
  			'max_width' => 468,
  			'max_height' => 60
  		),
  		'75x75' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/banners/',
  			'upload_url' => _reg('site_url') . 'usrs/banners/',
  			'max_width' => 75,
  			'max_height' => 75
  		)
  	)
	),
	'half-banner' => array(
		'script_url' => _reg('site_url') .'upload',
  	'upload_dir' => _reg('base_path') . 'usrs/banners/',
  	'upload_url' => _reg('site_url') . 'usrs/banners/',
  	'param_name' => 'files',
  	// The php.ini settings upload_max_filesize and post_max_size
  	// take precedence over the following max_file_size setting:
  	'max_file_size' => null,
  	'min_file_size' => 1,
  	'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i',
  	'max_number_of_files' => null,
  	// Set the following option to false to enable non-multipart uploads:
  	'discard_aborted_uploads' => true,
  	// Set to true to rotate images based on EXIF meta data, if available:
  	'_orient_image' => false,
  	'image_versions' => array(
  		// Uncomment the following version to restrict the size of
  		// uploaded images. You can also add additional versions with
  		// their own upload directories:
  		'half-banner' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/banners/',
  			'upload_url' => _reg('site_url') . 'usrs/banners/',
  			'max_width' => 234,
  			'max_height' => 60
  		),
  		'75x75' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/banners/',
  			'upload_url' => _reg('site_url') . 'usrs/banners/',
  			'max_width' => 75,
  			'max_height' => 75
  		)
  	)
	),
	'default' => array(
		'script_url' => _reg('site_url') .'upload',
  	'upload_dir' => _reg('base_path') . 'usrs/default/',
  	'upload_url' => _reg('site_url') . 'usrs/default/',
  	'param_name' => 'files',
  	// The php.ini settings upload_max_filesize and post_max_size
  	// take precedence over the following max_file_size setting:
  	'max_file_size' => null,
  	'min_file_size' => 1,
  	'accept_file_types' => '/.+$/i',
  	'max_number_of_files' => null,
  	// Set the following option to false to enable non-multipart uploads:
  	'discard_aborted_uploads' => true,
  	// Set to true to rotate images based on EXIF meta data, if available:
  	'_orient_image' => false,
  	'image_versions' => array(
  		// Uncomment the following version to restrict the size of
  		// uploaded images. You can also add additional versions with
  		// their own upload directories:
  		/*
  		'large' => array(
  			'upload_dir' => dirname(__FILE__).'/files/',
  			'upload_url' => dirname($_SERVER['PHP_SELF']).'/files/',
  			'max_width' => 1920,
  			'max_height' => 1200
  		),
  		*/
  		'thumbnail' => array(
  			'upload_dir' => _reg('base_path') . 'usrs/default/',
  			'upload_url' => _reg('site_url') . 'usrs/default/',
  			'max_width' => 80,
  			'max_height' => 80
  		)
  	)
  )
);

?>
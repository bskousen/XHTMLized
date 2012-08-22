<?php
/**
 * Template Name: callback
 *
 * This page will response AJAX callbacks
 *
 * @package WordPress
 * @subpackage Besana
 * @since Besana 1.0
 */
?>
<?php

if (isset($_POST['post_id'])) {
	$post_ID = $_POST['post_id'];
} else {
	$post_ID = '';
}

//$post_ID = '47';
//$post = get_post($post_ID);

global $wpdb;
$result = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE ID = '$post_ID' LIMIT 1");
if ($result) {
	$post_data = $result[0];
} else {
	die('No exite.');
}

/*
echo "<br />----------- blog post -----------<br />";
echo "<pre>";
print_r($post_data);
echo "</pre>";
*/

if (has_post_thumbnail($post_data->ID)) {
	$image = wp_get_attachment_image_src(get_post_thumbnail_id($post_data->ID), 'full');
}

$site_url = site_url();
$image_path = dirname($_SERVER['SCRIPT_NAME']) . str_replace($site_url, '', $image[0]);

/*
echo $image_path;

echo "<br />----------- image -----------<br />";
echo "<pre>";
print_r($image);
echo "</pre>";

echo '<p>dirname SERVER[SCRIPT_NAME]: ' . dirname($_SERVER['SCRIPT_NAME']) . '</p>';

echo "dirname: " . basename($image_path);

echo "<br />----------- SERVER -----------<br />";
echo "<pre>";
print_r($_SERVER);
echo "</pre>";
*/

header('Content-type: application/json');

echo json_encode(array(
	'ID' => $post_data->ID,
	'title' => $post_data->post_title,
	'content' => $post_data->post_content,
	'image_path' => $image_path
));

?>
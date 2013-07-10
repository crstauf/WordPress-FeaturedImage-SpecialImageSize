// 'post_type' => array(width,height)
$featimg_sizes = array(
  'post' => array(50,20)
);

add_action('wp_ajax_set-post-thumbnail','generate_featimg_size',1);
function generate_featimg_size() {
	global $featimg_sizes;

	$thumbnail_id = intval( $_POST['thumbnail_id'] );
	$type = get_post_type(intval( $_POST['post_id'] ));

	if (!isset($thumbnail_id)) return;
	if ('-1' == $thumbnail_id) return;
	if (!array_key_exists($type,$featimg_sizes)) return;

	$meta = wp_get_attachment_metadata($thumbnail_id);
	$path = apply_filters('image_make_intermediate_size',get_attached_file($thumbnail_id));

	if ($newsize = image_make_intermediate_size($path,$featimg_sizes[$type][0],$featimg_sizes[$type][1])) {
		$backupsizes = get_post_meta($thumbnail_id,'_wp_attachment_backup_sizes',true);
		$meta['sizes']['ptfi_'.$type] = $backupsizes['ptfi_'.$type] = $newsize; // ptfi = post type featured image

		update_post_meta($thumbnail_id,'_wp_attachment_metadata',$meta);
		update_post_meta($thumbnail_id,'_wp_attachment_backup_sizes',$backupsizes);
	}
}

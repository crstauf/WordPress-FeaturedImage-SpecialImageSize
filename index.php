// 'post_type' is the array key created in $featimg_sizes of functions.php
// also, using array(width,height) will return correct image

the_post_thumbnail('ptfi_{post_type}'));

wp_get_attachment_image_src($thumbnail_id,'ptfi_{post_type}');

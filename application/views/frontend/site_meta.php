<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?php if($page_name == 'directory_listing'): ?>
	<meta name="keywords" content="<?php echo str_replace(",",", ",$listing_details['seo_meta_tags']); ?>">
	<meta name="description" content="<?php echo $listing_details['meta_description']; ?>">
	<meta property="og:title" content="<?php echo $listing_details['name']; ?>" />
		<meta property="og:image" content="<?= base_url("uploads/listing_thumbnails/".$listing_details['listing_thumbnail']); ?>">
<?php else: ?>
	<meta name="keywords" content="<?php echo get_settings('meta_keyword'); ?>">
	<meta name="description" content="<?php echo get_settings('meta_description'); ?>">
	<meta property="og:title" content="<?php echo get_settings('system_title') ?>" />
		<meta property="og:image" content="<?= base_url("uploads/system/".get_frontend_settings('banner_image')); ?>">
<?php endif; ?>
<meta name="author" content="Creativeitem">
<title><?php echo $title.' | '.get_settings('system_title');?></title>


<meta property="og:url" content="<?php echo current_url(); ?>" />
<meta property="og:type" content="Atlas Business Directory Listing" />


<?php 
	/*
		Page Part : iFrame Page
	*/
	$iframeSrc = get_post_meta(get_the_ID(),'id_iframe_src', true);
	$iframeHeight = get_post_meta($post->ID,'id_iframe_height', true);
?>
<div class="main-content">
	<div class="container <?php echo get_the_ID(); ?>">
		<iframe id="content_frame" width="100%" height="<?php echo $iframeHeight; ?>" src="<?php echo $iframeSrc; ?>"></iframe>
	</div> 
</div>
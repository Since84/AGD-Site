<?php 
$video_slug = get_post_meta( get_the_ID(), 'video_slug', true );
?> 
<li class="slide">
	<video class="feature-video" controls preload="none" poster="<?= site_url( 'wp-content/uploads/video' ); ?>/<?= $video_slug; ?>.png" width="100%">
	    <source type="video/ogg" src="<?= site_url( 'wp-content/uploads/video' ); ?>/<?= $video_slug; ?>.ogv">
	    <source type="video/webm" src="<?= site_url( 'wp-content/uploads/video' ); ?>/<?= $video_slug; ?>.webm">
	    <source type="video/mp4" src="<?= site_url( 'wp-content/uploads/video' ); ?>/<?= $video_slug; ?>.mp4">
	    <embed src="<?= bloginfo('template_directory'); ?>/wp-content/uploads/video/<?= $video_slug; ?>.mp4" width="100%">
	</video>
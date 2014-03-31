<?php
$link = get_post_meta( get_the_ID(), 'slide_link', true );
?>

<li class='slide'>
<?php 
	$link = get_post_meta( get_the_ID(), 'slide_link', true );
	echo ( $link ) ? '<a href='.$link.'>' : '';
		the_post_thumbnail(); 
	echo ( $link ) ? '</a>' : '';

?>
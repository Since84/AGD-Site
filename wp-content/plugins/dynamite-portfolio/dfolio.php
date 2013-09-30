<?php
/* Dynamite dFolio Widget */

function get_dFolio( $type, $perPage ){

	$listArgs = array (
			'post_type'			=>	$type
			// 'posts_per_page'	=>	$perPage
	);
	$list = new WP_Query( $listArgs );

?>
	<ul id = "dFolio">
	<div class = "dBio"></div>

<?php
	global $post;
	if ( $list->have_posts() ) {
		while ( $list->have_posts() ) {
			$list->the_post();
				$position = get_post_meta( get_the_ID(), 'professional_position', true );
				$terms = wp_get_post_terms( get_the_ID(), 'expertise', array('fields' => 'name' ) );
				$thumbnail = get_the_post_thumbnail( $post->ID, array('200','200') );
?>

		<li class = "dMember dContainer" 
    		 data-name='<?php echo get_the_title(); ?>'
    		 data-position='<?php echo $position; ?>'
    		 data-id='<? echo get_the_ID(); ?>'
		>
			<div class='dCard'>	
			    <figure class='front'><? echo $thumbnail; ?></figure>
			    <figure class='back'>
			    	<? echo $thumbnail; ?>
			    	<div class='dMember-info'>
				    	<h1><?php the_title(); ?></h1>
				    	<p><?php echo $position; ?></p>
				    </div>
			    </figure>
			</div>
		</li>

<?php
		}
	}
?>
	</ul>
<? 
} 
?>
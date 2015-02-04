<?php
/* Dynamite dFolio Widget */

function get_dFolio( $type, $perPage, $pageSlug ){
	global $post;

	$projectType = $_GET['project-type'];

	$listArgs = array (
			'post_type'			=>	$type
			,'posts_per_page'	=>	$perPage
			,'project-type'		=>	$projectType
	);

	$list = new WP_Query( $listArgs );
	$pid = get_query_var( 'pid' );
?>
	<div id = "dFolio" data-pid= "<?php echo $pid; ?>">
		<div class = "dBio <?php echo $pageSlug; ?>" data-page="<?php echo $pageSlug; ?>"></div>
		<div class = "dGallery">
			<ul>

<?php
	global $post;
	if ( $list->have_posts() ) {
		while ( $list->have_posts() ) {
			$list->the_post();
				$position = get_post_meta( get_the_ID(), 'professional_position', true );
				$terms = wp_get_post_terms( get_the_ID(), 'project-type');
				$thumbnail = get_the_post_thumbnail();
				
				if (class_exists('MultiPostThumbnails')
                &&  MultiPostThumbnails::has_post_thumbnail( get_post_type(), 'project_thumbnail' ) ) :
	            	$thumbnail = MultiPostThumbnails::get_the_post_thumbnail( get_post_type(), 'project_thumbnail' );
                endif;

            $projectType = "";
            foreach ($terms as $term) {
            	$projectType .= $term->slug . " ";
            }
				
?>
			<li class = "dMember dContainer <?php echo $projectType; ?> " 
	    		 data-name='<?php echo get_the_title(); ?>'
	    		 data-position='<?php echo $position; ?>'
	    		 data-id='<?php echo get_the_ID(); ?>'
			>
				<div class='dCard'>	
				    <div class='front'>
<?php 					echo $thumbnail;	?>
				    </div>
				    <div class='back'>
<?php 					echo $thumbnail;	
						if ( get_post_type() == "project" ):
?>
				    	<div class='dMember-info'>
					    	<h1>
					    		<?php echo ( get_post_type() == "project" ) ? get_the_excerpt() : $position; ?>
					    	</h1>
					    	<p><?php the_title(); ?></p>
					    </div>

<?php 					else :
?>

				    	<div class='dMember-info'>
					    	<h1><?php the_title(); ?></h1>
					    	<p><?php echo $position; ?></p>
					    </div>

<?php 					endif; ?>

				    </div>					
				</div>
<?php
		}
	}
?>
			</ul>
		</div>
	</div>
<?php 
} 
?>
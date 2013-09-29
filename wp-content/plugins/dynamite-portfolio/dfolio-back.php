<?php
/* Dynamite dFolio Widget */

function get_dFolio( $type, $perPage ){

	$listArgs = array (
			'post_type'			=>	$type,
			'posts_per_page'	=>	$perPage
	);
	$list = new WP_Query( $listArgs );
?>
	<ul class = "dFolio">
<?php
if ( $list->have_posts() ) {
	while ( $list->have_posts() ) {
		$list->the_post();
			$position = get_post_meta( get_the_ID(), 'professional_position', true );
			$terms = wp_get_post_terms( get_the_ID(), 'expertise', array('fields' => 'name' ) );
?>
		<li class = "dMember" data-id = "<?php echo get_the_ID(); ?>" >
			<?php the_post_thumbnail( array('200', '200'), array( 'class' => "dMember-thumb" ) ); ?>
			<div class = 'dMember-profile' >
				<div class = 'dMember-info left-sidebar'>
					<h1><?php the_title(); ?></h1>
					<h2><?php echo $position; ?></h2>
					<ul class="dExpertise">
<?php 					
						foreach( $terms as $term ){
							var_dump($term);
						}
?>
					</ul>

				</div>
			<div class = 'dBio'>
				<?php the_content(); ?>
			</div>
		</li>
<?php
		}
	}
	wp_reset_postdata();
?>
	</ul>
<? } ?>
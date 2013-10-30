<?php
/* Portfolio Feature section */
$projectPage = get_page_by_title('Select Work' );
$pageLink = get_permalink( $projectPage->ID );
$projectType = $_GET['project-type'];
?>
<div class='main-content'>
	<div class="container">
		<ul class="top-menu">
			<li <?php echo ( $projectType == NULL ? 'class="active"' : '' ); ?> data-slug="all"><a href="<?php echo $pageLink; ?>">All</a></li>
			<?php

            	$tArgs = array(
            		'taxonomy' 		=> 'project_type',
            		'hide_empty'	=> true
            	);
                $taxonomy_ar = get_terms('project-type', $tArgs);
                $output = '<span class="btn">';
                foreach($taxonomy_ar as $taxonomy_term) {
                	// var_dump($taxonomy_term);
                    $output.= '<li '.( $taxonomy_term->slug === $projectType ? 'class="active"' : '' ).' data-slug="'.$taxonomy_term->slug.'"><a href="'.$pageLink.'&project-type='.$taxonomy_term->slug.'">'.$taxonomy_term->name.'</a></li>';
                }
                $output.= '</span>';

                echo $output;

			?>
		</ul>
		<div>
			<div class="portfolio-feature">
				<?php get_dFolio( "project", "25", "projects" ); ?>
			</div>
		</div>
	</div>
</div>
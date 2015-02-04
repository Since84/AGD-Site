<?php
/* Portfolio Feature section */
$projectPage = get_page_by_title('Select Work' );
$pageLink = get_permalink( $projectPage->ID );
$projectType = $_GET['project-type'];
?>
<div class='main-content'>
	<div class="container">
		<ul class="top-menu">
			<?php

            	$tArgs = array(
            		'taxonomy' 		=> 'project_type',
            		'hide_empty'	=> true
            	);
                $taxonomy_ar = get_terms('project-type', $tArgs);
                $output = ''//'<li class="work-selected-category"></li>'
                		. '<span class="btn">'
                		. '	<li class="all-work '. ( $projectType ? '' : 'active') .'" data-filter="*"><a href="'.$pageLink.'">All Work</a></li>';
                foreach($taxonomy_ar as $taxonomy_term) {
                	// var_dump($taxonomy_term);
                    $output.= '<li '.( $taxonomy_term->slug === $projectType ? 'class="active"' : '' ).' data-slug="'.$taxonomy_term->slug.'" data-filter=".'.$taxonomy_term->slug.'" ><a href="'.$pageLink.'?project-type='.$taxonomy_term->slug.'">'.$taxonomy_term->name.'</a></li>';
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
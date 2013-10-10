<?php
/* Portfolio Feature section */

$projectTypes = new WP_Query(array('post_type' => 'agd_project', 'posts_per_page' => '-1', 'order' => 'DESC'));
?>
<div class='main-content'>
	<div class="container">
		<ul class="top-menu">
			<li class="active" data-slug="all">All</li>
			<?php
            while ($projectTypes -> have_posts()): $projectTypes -> the_post();

                $taxonomy_ar = get_the_terms($post->ID, 'project-type');
                $output = '<span class="btn">';
                foreach($taxonomy_ar as $taxonomy_term) {
                	// var_dump($taxonomy_term);
                    $output.= '<li data-slug="'.$taxonomy_term->slug.'">'.$taxonomy_term->name.'</li>';
                }
                $output.= '</span>';

                echo $output;


            endwhile;​
			?>
		</ul>
		<div>
			<div class="portfolio-feature">
				<?php get_dFolio( "agd_project", "25", "feature" ); ?>
			</div>
		</div>
	</div>
</div>
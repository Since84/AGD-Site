<?php 
/* Post Category List */

	$catArgs = array (
		"show_option_all"	=> "All"
	);
	//wp_list_categories($catArgs); 
?>

<h1>Categories</h1>
<li class="go-back-button" data-slug="all"><a href="<?php echo get_permalink( get_page_by_title('blog')->ID ); ?>">All</a></li>
<?php
	$projectPage = get_page_by_title('blog');
	$pageLink = get_permalink( $projectPage->ID );
	$tArgs = array(
		'taxonomy' 		=> 'category'
		// ,'hide_empty'	=> true
	);
    $taxonomy_ar = get_terms('category', $tArgs);
    // var_dump($taxonomy_ar);
    $output = '<span class="btn">';
    foreach($taxonomy_ar as $taxonomy_term) {
    	// var_dump($taxonomy_term);
    	$catLink = get_site_url().'?cat='.$taxonomy_term->term_id;
    	// $catLink = get_permalink( $catLink ).'&cat='.$taxonomy_term->term_id;
        $output.= '<li data-slug="'.$taxonomy_term->slug.'"><a href='.$catLink.'>'.$taxonomy_term->name.'</a></li>';
    }
    $output.= '</span>';

    echo $output;

?>
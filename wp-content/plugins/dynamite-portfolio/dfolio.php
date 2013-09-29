<?php
/* Dynamite dFolio Widget */

function get_dFolio( $type, $perPage ){

	$listArgs = array (
			'post_type'			=>	$type,
			'posts_per_page'	=>	$perPage
	);
	$list = new WP_Query( $listArgs );

?>
	<ul id = "dFolio">
	<div class = "dBio"></div>
<?php
	for ( $i = 0; $i <= 12; $i++ ) {
?>

		<li class = "dMember dContainer" >
			<div class='dCard'>	
			    <figure class='front'>Front</figure>
			    <figure class='back'>Back</figure>
			</div>
		</li>

<?php
	}
?>
	</ul>
<? } ?>
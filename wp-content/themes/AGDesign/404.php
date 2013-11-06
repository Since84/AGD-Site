<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<div class='main-content'>
	<div class="container">
		<div class="wide-content column">
			<p>
				Oops. We can't seem to find the page you are searching for. Click <a href='javascript:history.back(1);'>Back</a> to go to the previous page or use the navigation above. If you need immediate assistance, please contact (link to connect page) our office directly.
			</p>
		</div>
	</div>
</div>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
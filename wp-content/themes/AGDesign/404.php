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
				Click <a href='javascript:history.back(1);'>Back</a> to go to the previous page or use the navigation above. If you need immediate assistance, please <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>">contact</a> our office directly.
			</p>
		</div>
	</div>
</div>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
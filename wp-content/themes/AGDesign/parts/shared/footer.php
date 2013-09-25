	
	<footer class="container">
		<div class="footer-main">
			<ul class="footer-nav">
				<li>
					<?php wp_nav_menu( array('theme_location' => 'footer-1' ) ) ?>
				</li>
				<li>
					<?php wp_nav_menu( array('theme_location' => 'footer-2' ) ) ?>
				</li>
				<li>
					<?php wp_nav_menu( array('theme_location' => 'footer-3' ) ) ?>
				</li>
				<li>
					<?php wp_nav_menu( array('theme_location' => 'footer-4' ) ) ?>
				</li>
			</ul>
			<div class="footer-social-links">
				<?php dynamic_sidebar( 'Social Links' ) ?>
			</div>
		</div>
		<div class="footer-sub">
			<span><strong>Bay Area Office / AG Design Group Inc.</strong></span>
			<span>925 Ygnacio Valley Road, Suite 103C/ Walnut Creek, CA 94596 / 925.954.7084</span>
			<span class="right">Copyright 2013. All Rights Reserved</span>
		</div>
	</footer>

<?php /* Post Block for Blog Rolls */ ?>
<li class="post">

	<h3 class="post-date"><?php the_time('m.d.Y'); ?></h3>
	<h1 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h1>
	<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( array('196', '196') ); ?></a>
	<?php the_excerpt(); ?>
</li>
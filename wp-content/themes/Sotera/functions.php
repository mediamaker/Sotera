<?php 
add_action('wp_print_styles', 'so_add_styles');
function so_add_styles()
{
	echo '<link rel="stylesheet/less" type="text/css" href="' . get_stylesheet_directory_uri() . '/css/style.less">';
/*
	if(is_catagory('sotera'))
	{
		echo '<link rel="stylesheet/less" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/css/sotera.less">';
	}
	if(is_catagory('visi'))
	{
		echo '<link rel="stylesheet/less" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/css/visi.less">';
	}
*/
}

add_action( 'wp_print_scripts', 'so_add_javascript' );
function so_add_javascript( ) 
{
	if(!is_admin())
	{		
		wp_deregister_script( 'jquery' );
		wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js');
		wp_enqueue_script('jquery');
		wp_enqueue_script('less', get_bloginfo('stylesheet_directory') . '/inc/js/less-1.1.3.min.js', array(), "1.1.3");
		wp_enqueue_script('so_scripts',  get_bloginfo('stylesheet_directory') .'/inc/js/scripts.js', array( 'jquery') );
		wp_enqueue_script('cycle',  get_bloginfo('stylesheet_directory') .'/inc/js/jquery.cycle.all.js', array( 'jquery') );
			
	}	
}

add_image_size('slideshow',1000,486,true);

function hook_excerpt_featured_length($length) {
	return 50;
}

function slideshow_featured_posts() {
	wp_reset_query();
	$featured = 4; // Assuming that the name of the category ID number 4 is "Featured".
	$count = 3; // How many post to be shown as slides. Ideally, it should be more than 3 posts.
	add_filter('excerpt_length', 'hook_excerpt_featured_length');
?>
 
<div class="list">
	<?php while (have_posts()) : the_post(); ?>
	<div class="item">
		<a class="image" href="<?php the_permalink(); ?>" title="Permanent Link to <?php the_title_attribute(); ?>">
		<?php the_post_thumbnail('slideshow'); ?>
		</a>
		<div class="meta">
			<h3><a href="<?php the_permalink(); ?>" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
			<?php the_excerpt(); ?>
		</div>
		<div style="clear: both"></div>
	</div>
	<?php endwhile; ?>
</div>
 
<?php
	wp_reset_query();
	remove_filter('excerpt_length','hook_excerpt_featured_length');
}
?>
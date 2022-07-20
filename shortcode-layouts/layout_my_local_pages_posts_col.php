<?php  if (!defined('ABSPATH')) { exit; } ?>

<?php if(!empty($sectionheading)){ ?>
	<?php //echo "Suburb Position is" .$suburb_pos;?>
	<?php if(empty($suburb_pos)){ ?>
		<h2 class="elementor-heading-title elementor-size-large mylocalpages-custom-heading no-suburb" ><?php echo $sectionheading; ?>,<?php echo $state_name; ?></h2>
	<?php } ?>
			
	<?php if($suburb_pos == "start"){ ?>
		<h2 class="elementor-heading-title elementor-size-large mylocalpages-custom-heading suburb-start" ><?php echo $_GET['suburb']; ?> <?php echo $sectionheading; ?>, <?php echo $state_name; ?></h2>
	<?php } ?>
			
	<?php if($suburb_pos == "end"){ ?>
		<h2 class="elementor-heading-title elementor-size-large mylocalpages-custom-heading suburb-end" ><?php echo $sectionheading; ?> <?php echo $_GET['suburb']; ?>, <?php echo $state_name; ?></h2>
	<?php } ?>
<?php }?>
<div class="row">
	<?php
	
		$args = array(
			'post_type' => 'post',
			'post_status ' => 'publish',
			'posts_per_page' => 1,
			'order' => 'ASC',
			'orderby' => 'ID',
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => array( 'featured-business'),
				),
				array(
					'taxonomy' => 'post_tag',
					'field'    => 'slug',
					'terms'    => $crnt_zipcode,
				),
			),
			
		);
		$wp_query = new WP_Query($args);
		if ($wp_query->have_posts()):
			while ($wp_query->have_posts()):
				$wp_query->the_post();
				global $post;
				$slug = $post->post_name;
				$video_id = get_field('featured_video');
				
	?>

			<div class="col-md-6">
				<?php if(!empty($video_id)) {?>
					<iframe src="https://www.youtube.com/embed/<?php echo $video_url; ?>" width="100%" height="350"></iframe>
				<?php } ?>
			</div>
			<div class="col-md-6 <?php  echo get_the_ID(); ?>">
				<?php //echo substr(get_the_content(),0,550); ?>
				<?php echo get_the_excerpt(); ?>
			</div>
	<?php endwhile; ?>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</div>
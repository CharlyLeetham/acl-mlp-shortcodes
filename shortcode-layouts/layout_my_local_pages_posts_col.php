<?php  if (!defined('ABSPATH')) { exit; } ?>

<?php if(!empty($section_cat_id)){ ?>
<?php if(!empty($sectionheading)){ ?>
	<?php //echo "Suburb Position is" .$suburb_pos;?>
	<?php if(empty($suburb_pos)){ ?>
		<h2 class="elementor-heading-title elementor-size-large mylocalpages-custom-heading no-suburb" ><?php echo $sectionheading; ?></h2>
	<?php } ?>
			
	<?php if($suburb_pos == "start"){ ?>
		<h2 class="elementor-heading-title elementor-size-large mylocalpages-custom-heading suburb-start" ><?php echo $_GET['suburb']; ?> <?php echo $sectionheading; ?></h2>
	<?php } ?>
			
	<?php if($suburb_pos == "end"){ ?>
		<h2 class="elementor-heading-title elementor-size-large mylocalpages-custom-heading suburb-end" ><?php echo $sectionheading; ?> <?php echo $_GET['suburb']; ?></h2>
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
			
		);
		$wp_query = new WP_Query($args);
		if ($wp_query->have_posts()):
			while ($wp_query->have_posts()):
				$wp_query->the_post();
				global $post;
				$slug = $post->post_name;
				$fimage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID) , 'full');
				if (!empty($fimage))
				{
					$f_img = $fimage[0];
				}
				else
				{
					$f_img = "https://via.placeholder.com/265x150.png?text=Placeholder+Image";
				}
	?>

			<div class="col-md-6">
				<img src="<?php  echo $f_img; ?>" alt="<?php echo get_the_title(); ?>">
			</div>
			<div class="col-md-6 <?php  echo get_the_ID(); ?>">
				<?php //echo substr(get_the_content(),0,550); ?>
				<?php echo get_the_excerpt(); ?>
			</div>
	<?php endwhile; ?>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</div>
<?php } ?>
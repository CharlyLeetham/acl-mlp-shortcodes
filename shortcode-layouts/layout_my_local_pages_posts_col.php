<?php  if (!defined('ABSPATH')) { exit; } ?>

<?php if(!empty($sectionheading)){ ?>
	<?php //echo "Suburb Position is" .$suburb_pos;?>
	<?php if(empty($suburb_pos)){ ?>
		<h3  class="raven-heading raven-heading-h3 mlp-raven-custom-headin no-suburb" ><span class="raven-heading-title"><?php echo $sectionheading; ?>,<?php echo $state_name; ?></span></h3>
		<!--<h2 class="elementor-heading-title elementor-size-large mylocalpages-custom-heading no-suburb" ><?php //echo $sectionheading; ?>,<?php //echo $state_name; ?></h2>-->
	<?php } ?>

	<?php if($suburb_pos == "start"){ ?>
		<h3  class="raven-heading raven-heading-h3 suburb-start mlp-raven-custom-headin" ><span class="raven-heading-title"><?php echo $_GET['suburb']; ?> <?php echo $sectionheading; ?>, <?php echo $state_name; ?></span></h3>
		<!--<h2 class="elementor-heading-title elementor-size-large mylocalpages-custom-heading suburb-start" ><?php //echo $_GET['suburb']; ?> <?php //echo $sectionheading; ?>, <?php //echo $state_name; ?></h2> -->
	<?php } ?>

	<?php if($suburb_pos == "end"){ ?>
		<h3  class="raven-heading raven-heading-h3 suburb-end mlp-raven-custom-headin" ><span class="raven-heading-title"><?php echo $sectionheading; ?> <?php echo $_GET['suburb']; ?>, <?php echo $state_name; ?></span></h3>
		<!--<h2 class="elementor-heading-title elementor-size-large mylocalpages-custom-heading suburb-end" ><?php //echo $sectionheading; ?> <?php //echo $_GET['suburb']; ?>, <?php //echo $state_name; ?></h2> -->
	<?php } ?>
<?php }?>

<div class="row col-template" style="margin-top: 25px;">
	<?php
		
		$args = array(
			'post_type' => 'post',
			'post_status ' => 'publish',
			'posts_per_page' => 1,
			'order' => 'DESC',
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
				<?php if ( !empty($video_id) ) {?>
					<iframe src="https://www.youtube.com/embed/<?php echo $video_id; ?>" width="100%" height="350"></iframe>
				<?php } ?>
			</div>
			<div class="col-md-6 <?php  echo get_the_ID(); ?>">
				<?php //echo substr(get_the_content(),0,550); ?>
				<?php the_content(); ?>
			</div>
	<?php endwhile; ?>
	<?php else : ?>
	
			<?php

			$section_cat_id_array = explode(",",$section_cat_id); 
			$post_num = 1;
			$queried_posts = array();
			if(count($section_cat_id_array) > 1){
				foreach($section_cat_id_array as $cat_id){
					$args = array(
						'post_type' => 'post',
						'post_status ' => 'publish',
						'posts_per_page' => $post_num,
						'order' => 'DESC',
						'orderby' => 'ID', 
						'tax_query' => array(
							'relation' => 'AND',
							array(
								'taxonomy' => 'category',
								'field'    => 'term_id',
								'terms'    => array($cat_id),
							),
							array(
								'taxonomy' => 'post_tag',
								'field'    => 'slug',
								'terms'    => $crnt_zipcode,
							),
						),
					
					);
					$wp_chck_query = new WP_Query($args);
					if($wp_chck_query->found_posts > 0){
						if(count($queried_posts) !== $post_num){
							//array_push($queried_posts, $wp_chck_query->posts);	
							$queried_posts = $queried_posts + $wp_chck_query->posts;
						}
						
					}
					
				}
			}else{
				$args = array(
					'post_type' => 'post',
					'post_status ' => 'publish',
					'posts_per_page' => 1,
					'order' => 'DESC',
					'orderby' => 'ID',
					'tax_query' => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'category',
							'field'    => 'term_id',
							'terms'    => array($section_cat_id),
						),
						array(
							'taxonomy' => 'post_tag',
							'field'    => 'slug',
							'terms'    => $crnt_zipcode,
						),
					),
				);
				$wp_els_query = new WP_Query($args);
				//array_push($queried_posts, $wp_els_query->posts);
				$queried_posts = $queried_posts + $wp_els_query->posts;
			}
			if(!empty($queried_posts)){
				foreach($queried_posts as $queried_post){
					$video_id = get_field('featured_video', $queried_post->ID);
			?>
					<div class="col-md-6">
						<?php if ( !empty($video_id) )  {?>
							<iframe src="https://www.youtube.com/embed/<?php echo $video_id; ?>" width="100%" height="350"></iframe>
						<?php } ?>
					</div>
					<div class="col-md-6 post-<?php  echo $queried_post->ID; ?>">
						<?php //echo substr(get_the_content(),0,550); ?>
						<?php echo $queried_post->post_content; ?>
					</div>
			<?php	}
			}else{ ?>
				<p style="text-align:center;"><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
			<?php }
			?>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</div>

<?php  if (!defined('ABSPATH')) { exit; } ?>
<?php if(!empty($sectionheading)){ ?>
	<div class="row">
		<div class="col-md-6">
			<?php if(empty($suburb_pos)){ ?>
			<h2 style="text-align:left" class="elementor-heading-title elementor-size-large mylocalpages-custom-heading no-suburb" ><?php echo $sectionheading; ?></h2>
			<?php } ?>
			
			<?php if($suburb_pos == "start"){ ?>
			<h2 style="text-align:left" class="elementor-heading-title elementor-size-large mylocalpages-custom-heading suburb-start" ><?php echo $_GET['suburb']; ?> <?php echo $sectionheading; ?></h2>
			<?php } ?>
			
			<?php if($suburb_pos == "end"){ ?>
			<h2 style="text-align:left" class="elementor-heading-title elementor-size-large mylocalpages-custom-heading suburb-end" ><?php echo $sectionheading; ?> <?php echo $_GET['suburb']; ?></h2>
			<?php } ?>
		</div>
		<div class="col-md-6">
			<div class="raven-widget-wrapper">
				<div class="raven-divider">
					<span class="raven-divider-line raven-divider-solid"></span>
				</div>
			</div>
		</div>
	</div>
<?php }?>

<div class="row">
	<?php
		$args = array(
			'post_type' => 'post',
			'post_status ' => 'publish',
			'posts_per_page' => intval($max_posts),
			'order' => 'ASC',
			'orderby' => 'ID',
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'terms' => $section_cat_id,
					'field' => 'term_id',
					'operator' => 'IN'
				)
			) ,
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
			<div class="col-md-3">
				<div class="col-md-12">
					<img src="<?php  echo $f_img; ?>" alt="<?php echo get_the_title(); ?>">
				</div>
				<div class="col-md-12 <?php  echo get_the_ID(); ?>">
					<div class="mylocalpages-post-content">
						<h3 class="mylocalpages-post-title">
							<a class="raven-post-title-link" href="<?php echo get_the_permalink(); ?>">
								<?php echo get_the_title();?>
							</a>
						</h3>
						<div class="mylocalpages-post-meta">
							<a class="raven-post-meta-item raven-post-date" href="https://clients.askcharlyleetham.com/mlpdev/2022/02/" rel="bookmark">
								<?php echo get_the_date(); ?>
							</a> 
							<span class="raven-post-meta-divider">/</span> 
							<span class="raven-post-meta-item raven-post-categories">
								<a href="" rel="tag"><?php echo get_cat_name($section_cat_id); ?></a>
							</span>
						</div>
						<div class="mylocalpages-post-excerpt">
							<?php echo get_the_excerpt(); ?>
						</div>
						<div class="mylocalpages-post-read-more"> 
							<a class="mylocalpages-post-button" href="<?php echo get_the_permalink(); ?>">
								<span class="mylocalpages-post-button-text">Read More</span>
							</a>
						</div>
					</div>
				</div>
			</div>
	<?php endwhile; ?>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</div>
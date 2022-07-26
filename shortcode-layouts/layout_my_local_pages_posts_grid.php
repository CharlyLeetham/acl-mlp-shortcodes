<?php  if (!defined('ABSPATH')) { exit; } ?>
<?php
if(!empty($section_cat_id)){
	if(!empty($sectionheading)){ ?>
	<div class="row">
		<div class="col-md-4">
			<!----if suburb name is required---->
			<?php if($heading_type == "suburb"){?>
				<?php if(empty($suburb_pos)){ ?>
				<h3 class="raven-heading raven-heading-h3 no-suburb mlp-raven-custom-headin" ><span class="raven-heading-title"><?php echo $sectionheading; ?></span></h3>
				<?php } ?>

				<?php if($suburb_pos == "start"){ ?>
				<h3 class="raven-heading raven-heading-h3 suburb-start mlp-raven-custom-headin" > <span class="raven-heading-title"><?php echo $_GET['suburb']; ?> <?php echo $sectionheading; ?></span></h3>
				<?php } ?>

				<?php if($suburb_pos == "end"){ ?>
				<h3  class="raven-heading raven-heading-h3 suburb-end mlp-raven-custom-headin" ><span class="raven-heading-title"><?php echo $sectionheading; ?> <?php echo $_GET['suburb']; ?></span></h3>
				<?php } ?>
			<?php } ?>
			<!----if state name is required---->
			<?php if($heading_type == "state"){?>
				<?php if(empty($state_pos)){ ?>
				<h3 class="raven-heading raven-heading-h3 no-suburb mlp-raven-custom-headin" ><span class="raven-heading-title"><?php echo $sectionheading; ?></span></h3>
				<?php } ?>

				<?php if($state_pos == "start"){ ?>
				<h3 class="raven-heading raven-heading-h3 suburb-start mlp-raven-custom-headin" ><span class="raven-heading-title"><?php echo $state_name; ?> <?php echo $sectionheading; ?><span></h3>				<?php } ?>

				<?php if($state_pos == "end"){ ?>
				<h3  class="raven-heading raven-heading-h3 suburb-end mlp-raven-custom-headin" ><span class="raven-heading-title"><?php echo $sectionheading; ?> <?php echo $state_name; ?></span></h3>
				<?php } ?>
			<?php } ?>
		</div>
		<div class="col-md-8 mlp-divider">
			<div class="raven-widget-wrapper">
				<div class="raven-divider">
					<span class="raven-divider-line raven-divider-solid"></span>
				</div>
			</div>
		</div>
	</div>

<?php }?>

<?php
	//echo "Button Label is" .$button_label;
	if(!empty($button_label)){ ?>
	<div class="row">
		<div class="col-md-12 mlp-button-container">
			<div class="elementor-button-wrapper">
				<a class="elementor-button elementor-size-sm mlp-custom-link" href="<?php echo $button_link; ?>" role="button"> <span class="elementor-button-content-wrapper">
					<span class="elementor-button-text"><?php echo $button_label; ?> </span> </span>
				</a>
			</div>
		</div>
	</div>
<?php } ?>
<div class="row mlp-same-height-col">
	<?php
	if( strpos($section_cat_id, ',') !== false ) {
							 $section_cat_id = explode(',' ,$section_cat_id);
						}
		$args = array(
			'post_type' => 'post',
			'post_status ' => 'publish',
			'posts_per_page' => intval($max_posts),
			'order' => 'DESC',
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
			<div class="col-md-3 ">
				<div class="mlp-post-grid .raven-post .elementor-animation-grow">
					<div class="col-md-12 .raven-post-image-wrap">
						<a class="raven-post-image raven-image-fit" href="<?php echo get_the_permalink(); ?>">
							<img fifu-featured="1" src="<?php  echo $f_img; ?>" alt="<?php echo get_the_title(); ?>">
							<span class="raven-post-image-overlay"></span>
						</a>
					</div>
					<div class="col-md-12 <?php  echo get_the_ID(); ?>">
						<div class="mylocalpages-post-content">
							<h3 class="mylocalpages-post-title">
								<a class="raven-post-title-link" href="<?php echo get_the_permalink(); ?>">
									<?php echo get_the_title();?>
								</a>
							</h3>
							<div class="mylocalpages-post-meta">
								<a class="raven-post-meta-item raven-post-date" href="<?php echo get_month_link('', ''); ?>" rel="bookmark">
									<?php echo get_the_date(); ?>
								</a>
								<span class="raven-post-meta-divider">/</span>
								<span class="raven-post-meta-item raven-post-categories">
									<a href="" rel="tag"><?php
											$acl_categories = get_the_category();//$post->ID
											foreach($acl_categories as $acl_category){
												echo $acl_category->name;
											}
									 ?></a>
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
			</div>
	<?php endwhile; ?>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</div>
<?php } ?>

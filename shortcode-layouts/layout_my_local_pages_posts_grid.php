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

		$queried_posts = array();

		if(is_array($section_cat_id)&& count($section_cat_id) > 1){

				foreach($section_cat_id as $cat_id){
					$args = array(
						'post_type' => 'post',
						'post_status ' => 'publish',
						'posts_per_page' => intval($max_posts),
						'order' => 'DESC',
						'orderby' => 'ID',
						'tax_query' => array(
							array(
								'taxonomy' => 'category',
								'terms' => array($cat_id),
								'field' => 'term_id',
								'operator' => 'IN'
							)
						) ,
					);
					$wp_chck_query = new WP_Query($args);

					if($wp_chck_query->found_posts > 0){
						//echo "Post Found for category".$cat_id. 'is' .$wp_chck_query->found_posts;
						if(count($queried_posts) !== intval($max_posts)){
							//array_merge($queried_posts,$wp_chck_query->posts);
							$queried_posts = $queried_posts + $wp_chck_query->posts;
						}
					}

				}
			} else {

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
				$wp_query = new WP_Query( $args );
				$queried_posts = $queried_posts + $wp_query->posts;
				//array_push($queried_posts, $wp_query->posts[0]);

			}

		/* echo "<pre>";
		print_r($queried_posts);
		exit; */
		if(!empty($queried_posts)){
			foreach($queried_posts as $queried_post){
				$fimage = wp_get_attachment_image_src(get_post_thumbnail_id($queried_post->ID) , 'full');
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
          <div class="mlp-post-grid raven-post elementor-animation-grow">
					  <div class="col-md-12 raven-post-image-wrap">
              <a class="raven-post-image raven-image-fit" href="<?php echo get_the_permalink($queried_post->ID); ?>">
						    <img src="<?php  echo $f_img; ?>" alt="<?php echo $queried_post->post_title; ?>">
                <span class="raven-post-image-overlay"></span>
              </a>
					</div>
					<div class="col-md-12 <?php  echo $queried_post->ID; ?>">
						<div class="mylocalpages-post-content">
							<h3 class="mylocalpages-post-title">
								<a class="raven-post-title-link" href="<?php echo get_the_permalink($queried_post->ID); ?>">
									<?php echo $queried_post->post_title;?>
								</a>
							</h3>
							<div class="mylocalpages-post-meta">
								<a class="raven-post-meta-item raven-post-date" href="<?php echo get_month_link('', ''); ?>" rel="bookmark">
									<?php echo get_the_date(get_option( 'date_format' ), $queried_post->ID); ?>
								</a>
								<span class="raven-post-meta-divider">/</span>
								<span class="raven-post-meta-item raven-post-categories">
                  <?php
                  $debug = false;
                  if ($debug) {
                  ?>
									<a href="" rel="tag"><?php echo get_post_categories($queried_post->ID); ?></a>
                  <?php
                  }
                  ?>
									<a href="" rel="tag"><?php
											$acl_categories = get_the_category( $queried_post->ID );
											foreach($acl_categories as $acl_category){
												echo $acl_category->name;
											}
									 ?></a>
								</span>
							</div>
							<div class="mylocalpages-post-excerpt">
								<?php echo $queried_post->post_excerpt; ?>
							</div>
							<div class="mylocalpages-post-excerpt">
								<?php
								$old_content = $queried_post->post_content;
								$new_content = wp_strip_all_tags( $old_content );
								$new_content = strip_shortcodes( $new_content );
								echo wp_trim_words( $new_content, 40 ); ?>
							</div>
							<div class="mylocalpages-post-read-more">
								<a class="mylocalpages-post-button" href="<?php echo get_the_permalink($queried_post->ID); ?>">
									<span class="mylocalpages-post-button-text">Read More</span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	<?php } ?>
	<?php wp_reset_postdata(); ?>
</div>
<?php } ?>

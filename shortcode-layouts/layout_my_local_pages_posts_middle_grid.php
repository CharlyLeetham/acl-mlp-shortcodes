<?php  if (!defined('ABSPATH')) { exit; } ?>
<div class="row" style="display: block;">
	<div class="col-md-12" style="display: flex;">
		<?php
			$args = array(
				'post_type' => 'post',
				'post_status ' => 'publish',
				'posts_per_page' => 2,
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
				<div class="col-md-6">
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
</div>
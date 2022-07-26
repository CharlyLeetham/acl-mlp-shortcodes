<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }

	if(!empty($section_cat_id)){

?>
			<style>

			.slick-dots li button{
				box-shadow: none !important;
			}
			.mlp-post-title{
				font-size: 1.1em;
				padding: 0;
				font-weight: 700;
				word-spacing: normal;
				letter-spacing: normal;
				text-transform: unset;
				font-family: Lato;
				min-height: 160px;
				    margin-top: 0.5rem;
			}
			.mlp-post-title a{
				color: #38B449;
			}
			.mlp-post-img img {
				width: 100%;
        height: 200px;
			}

			.slick-dots li {
				width: 25px !important;
				height: 25px !important;
			}
			.slick-dots li button {
				width: 25px !important;
				height: 25px !important;
			}
			.slick-dots li button:hover,
			.slick-dots li button:focus{
				background: transparent !important;
			}
			.slick-dots li button:before {
				font-size: 10px !important;
				width: 25px !important;
				height: 25px !important;
			}

			.slick-dots li.slick-active button:before
			{
				opacity: 1 !important;
			}
			span.post-published-date,
			i.fa.fa-calendar{
				font-size: 12px;
				color: #777;
				line-height: 1.5;
				font-weight: 500;
			}
			svg.anwp-pg-icon{
					display: inline-block;
				width: 16px;
				height: 16px;
				stroke-width: 0;
				stroke: none;
				fill: #777;
			}

      .col-xs-12.slick-slide, .col-sm-3.slick-slide, .col-md-3.slick-slide, .col-md-3 {
        padding-right: 0;
        padding-left: 0;
        margin-right: 3px;
      }

			</style>
			<section class="mlp-post-section">
				<div class="mlp-post-container">
					<div class="mlp-post-slider row">
						<?php
						if( strpos($section_cat_id, ',') !== false ) {
							 $section_cat_id = explode(',' ,$section_cat_id);
						}


							$args = array(
								'post_type' => 'post',
								'post_status ' => 'publish',
								'posts_per_page' => intval($max_posts),
								'order'=> 'DESC',
								'orderby'=>'ID',
								'tax_query' => array(
									array(
										'taxonomy' => 'category',
										'terms' => $section_cat_id,
										'field' => 'term_id',
										'operator' => 'IN'
									)
								),
							);
							$wp_query = new WP_Query($args);
							if ( $wp_query->have_posts() ):
							while ( $wp_query->have_posts() ) : $wp_query->the_post();
							global $post;
							$slug = $post->post_name;
							$fimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
							if ( !empty( $fimage ) ){
								$f_img = $fimage[0];
							} else {
								$f_img = "https://via.placeholder.com/265x150.png?text=Placeholder+Image";
							}
						?>
						<div class="col-xs-12 col-sm-3 col-md-3">
							<div class="mlp-post-img <?php echo $post->ID; ?>">
								<a href="<?php echo get_permalink(); ?>">
									<img src="<?php echo $f_img; ?>">
								</a>
							</div>
							<div class="mlp-post-title <?php echo $post->ID; ?>">
								<a href="<?php echo get_permalink(); ?>">
									<?php echo get_the_title(); ?>
								</a>
								<p>
								<i class="fa fa-calendar" aria-hidden="true"></i>
								<span class="post-published-date"><?php echo get_the_date(); ?></span></p>
							</div>
							<!---<div class="mlp-post-link">
								<a href="<?php //echo get_permalink(); ?>">Read More</a>
							</div>---->
						</div>
						<?php endwhile; ?>
						<?php endif; ?>
						<?php wp_reset_postdata(); ?>
					</div>
				</div>
			</section>
	<?php } ?>

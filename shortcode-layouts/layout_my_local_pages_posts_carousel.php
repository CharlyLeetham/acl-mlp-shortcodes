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

      .col-md-3.slick-thumb {
        padding-right: 0;
        padding-left: 0;
        margin-right: 3px;
      }

			</style>
			<section class="mlp-post-section">
				<div class="mlp-post-container">
					
						<?php
						if( strpos($section_cat_id, ',') !== false ) {
							 $section_cat_id = explode(',' ,$section_cat_id);
						}
						
						$queried_posts = array();
						if(is_array($section_cat_id) && count($section_cat_id) > 1){
								foreach($section_cat_id as $cat_id){
									$args = array(
									'post_type' => 'post',
									'post_status ' => 'publish',
									'posts_per_page' => intval($max_posts),
									'order'=> 'DESC',
									'orderby'=>'ID',
									'tax_query' => array(
										array(
											'taxonomy' => 'category',
											'terms' => array($cat_id),
											'field' => 'term_id',
											'operator' => 'IN'
										)
									),
								);
									$wp_chck_query = new WP_Query($args);
									
									if($wp_chck_query->found_posts > 0){
										if(count($queried_posts) !== intval($max_posts)){
											//array_merge($queried_posts,$wp_chck_query->posts); 
											$queried_posts = $queried_posts + $wp_chck_query->posts;
										}
									}
									
								}
							}else{ 
								$args = array(
									'post_type' => 'post',
									'post_status ' => 'publish',
									'posts_per_page' => intval($max_posts),
									'order'=> 'DESC',
									'orderby'=>'ID',
									'tax_query' => array(
										array(
											'taxonomy' => 'category',
											'terms' => array($section_cat_id[0]),
											'field' => 'term_id',
											'operator' => 'IN'
										)
									),
								);
								$wp_query = new WP_Query($args);
								$queried_posts = $queried_posts + $wp_query->posts;
							}

							if(!empty($queried_posts)){ ?>
								<div class="mlp-post-slider row">
								<?php 
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
                  
                <div class="col-xs-12 col-sm-3 col-md-3 slick-thumb">
                    <div class="mlp-post-img <?php echo $queried_post->ID; ?> raven-post-image-wrap">    
                        <a href="<?php echo get_permalink($queried_post->ID); ?>" class="raven-post-image raven-image-fit">
                          <img src="<?php echo $f_img; ?>">
                          <span class="raven-post-image-overlay"></span>                        
                        </a>
										</div>
										<div class="mlp-post-title <?php echo $queried_post->ID; ?>">
											<a href="<?php echo get_permalink($queried_post->ID); ?>">
												<?php echo $queried_post->post_title;?>
											</a>
											<p>
											<i class="fa fa-calendar" aria-hidden="true"></i>
											<span class="post-published-date"><?php echo get_the_date(get_option( 'date_format' ), $queried_post->ID); ?></span></p>
										</div>
										<!---<div class="mlp-post-link">
											<a href="<?php //echo get_permalink(); ?>">Read More</a>
										</div>---->
									</div>
								<?php } ?>
								</div>
							<?php } else {?>
							 <p>No Posts to show. Please add some post against category for this section</p>
							<?php } ?>
						<?php wp_reset_postdata(); ?>
					
				</div>
			</section>
	<?php } ?>

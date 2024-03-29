<?php
/*
Plugin Name: ACL MLP Shortcodes
Plugin URI: http://askcharlyleetham.com
Description: Shortcode query to use with Elementor to display dynamic templates
Version: 1.1
Author: Sam
Author URI: http://askcharlyleetham.com
License: GPL

Changelog
Version 1.0 - Original Version
Version 1.1 - When multiple categories are provided, the subsequent categories are only queried if there are insufficient posts in the first categories.
*/


function acl_my_local_pages_posts_callback( $atts ){
    /* ob_start(  );
        require_once( 'shortcode-layouts/layout_my_local_pages_posts.php' );
        return ob_get_clean(  ); */

        extract( shortcode_atts( array(
                'section' => 'Section 1',
                'type' => 'cat',
                'max_posts' => 8,
                'layout' => 'carousel',
				'heading_type' => '',
                'sectionheading'=> '',
                'suburb_pos' => '',
				'state_pos' => '',
				'button_label' => '',
				'button_link'=>'#',
         ), $atts ) );

    $crnt_zipcode = $_GET['zip']; //get zipcode from url
    $zipcode_records = get_option( 'zipcodes_rec' ); //get all zipcode records
    $crrent_zipcode_data = $zipcode_records[$crnt_zipcode]; //get crrent zipcode section data
	$title_area = $crrent_zipcode_data['Title Area']; //get crrent state
	$state_name = $crrent_zipcode_data['State']; //get crrent state
	$section_cat_id = $crrent_zipcode_data[$section]; //get crrent section cat id


		if ( $section == 'Title Area' ) {
			return  '<h1 class="elementor-heading-title elementor-size-default mlp-titlearea">My Local '.$crnt_zipcode.' - '.$title_area.' Region</h1>';
		}


    if ( $type == 'cat' ) {

            if ( $layout == 'carousel'  ){

                    ob_start(  );
                    require( 'shortcode-layouts/layout_my_local_pages_posts_carousel.php' );
                    return ob_get_clean();

            } elseif( $layout == 'sidebyside' ){

                    ob_start(  );
                    require( 'shortcode-layouts/layout_my_local_pages_posts_col.php' );
                    return ob_get_clean();

            } else {


                    if ( $section == 'Section 10 middle' ) {
                            ob_start();
                            require_once( 'shortcode-layouts/layout_my_local_pages_posts_middle_grid.php' );
                            return ob_get_clean();

                    } else{

						ob_start();
                            require( 'shortcode-layouts/layout_my_local_pages_posts_grid.php' );
                            return ob_get_clean();

                    }

            }
    } elseif ( $type== 'ad') {
  		if(!empty($section_cat_id)){
  			$ad_split_arr =  explode( " ",$section_cat_id);
  			$ad_id = $ad_split_arr[3];
  			echo do_shortcode( '[bsa_pro_ad_space id='.$ad_id.']' );
  		}

    } else {
				if ( $type == 'featured' ) {

					 require( 'shortcode-layouts/layout_my_local_pages_featured_post_section.php' );
				}
		}
}
add_shortcode( 'my_local_pages_posts' , 'acl_my_local_pages_posts_callback' );

/** Post Code functionality **/

add_action( 'admin_menu', 'acl_localpages_zipcode_page' );

function acl_localpages_zipcode_page() {

        add_menu_page(
                'All Post Codes', // page <title>Title</title>
                'Local Pages Post Codes', // menu link text
                'manage_options', // capability to access the page
                'local-pages-zipcodes', // page URL slug
                'acl_localpages_zipcode_page_content', // callback function /w content
                'dashicons-star-half', // menu icon
                5 // priority
        );
}

//Admin page html callback
//Print out html for admin page
function acl_localpages_zipcode_page_content() {
  // check user capabilities
  if ( ! current_user_can( 'manage_options' ) ) {
    return;
  }

  define( 'mlppluginpath', plugin_dir_path( __FILE__ ) );

  //Get the active tab from the $_GET param
  $default_tab = null;
  $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
  ?>
  <!-- Our admin page content should all be inside .wrap -->
  <div class="wrap">
    <!-- Print the page title -->
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <!-- Here are our tabs -->
    <nav class="nav-tab-wrapper">
      <a href="?page=local-pages-zipcodes" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Manage Zipcode</a>
      <a href="?page=local-pages-zipcodes&tab=import-zipcodes" class="nav-tab <?php if($tab==='import-zipcodes'):?>nav-tab-active<?php endif; ?>">Import Zipcodes</a>
    </nav>

    <div class="tab-content">
    <?php

    $mydir = plugin_dir_path( __FILE__ );
    switch( $tab ) :
      case 'import-zipcodes':
          include ( mlppluginpath.'/inc/import-zipcodes.php' );
      break;
      default:

      include ( mlppluginpath.'/inc/zipcodes-list.php' );
        break;
    endswitch; ?>
    </div>
  </div>
  <?php
}


/************Snippet to add Imported Zipcode Dropdown to category screen**************
****************************************************************************/

//add extra fields to category edit form hook
//add_action ( 'edit_category_form_fields', 'acl_extra_category_fields');
//add_action ( 'category_add_form_fields', 'acl_extra_category_fields');

//add extra fields to category edit form callback function

function acl_extra_category_fields( $tag ) {    //check for existing featured ID
    $t_id = $tag->term_id;
    //$cat_meta = get_option( "category_$t_id");
        $zipcodes_records = get_option( 'zipcodes_rec' );
        $tag_zipcode = get_option( 'term_'.$t_id.'_linked' );


?>
  <tr class="form-field">
  	<th scope="row" valign="top">
  		<label for="mlp_zipcodes"><?php _e('Select Zipcode'); ?></label>
  	</th>
  	<?php if(!empty($zipcodes_records)){ ?>
  		<td>
  			<select multiple="multiple" id="mlp_zipcodes" name="mlp_cat_zipcode[]" style="width: 100%;">
  				<?php
  					$selected_zipcode = "";
  					foreach($zipcodes_records as $zipcode_record) {
  						if($tag_zipcode == $zipcode_record[2]){
  							$selected_zipcode = $zipcode_record[2];
  						}
  				?>
  					<option value="<?php echo $zipcode_record[2]; ?>" <?php if ( $tag_zipcode && ( in_array($zipcode_record[2], $tag_zipcode ) ) ){echo "selected"; }else{ echo "";}?>><?php echo $zipcode_record["Postcode"]; ?></option>
  				<?php } ?>
  			</select><br />
  			<input type="hidden" name="crrent_zipcode" value="zip_<?php echo $selected_zipcode; ?>_linked">
  			<span class="description"><?php _e('Select Zipcode to attach with category '); ?></span>
  		</td>
  	<?php } else{ ?>
  			<select id="mlp_zipcodes" name="mlp_cat_zipcode">
  					<option >Please Add Zipcodes First</option>
  			</select><br />
  	<?php } ?>
  </tr>
<?php
}

/******Now save the selected zipcode *********************/
function acl_save_mlp_category_zipcode( $term_id ) {

$mlp_cat_zipcode = $_POST['mlp_cat_zipcode'];

$posted_val = 'zip_'.$mlp_cat_zipcode.'_linked';
$crrent_zipcode = $_POST['crrent_zipcode'];
// $category_imageUrl = get_option( “{$taxonomy}_{$term_id}_imageUrl” ); // Grab our imageUrl if one exists

if( !empty($_POST['mlp_cat_zipcode'] ) ) { // IF the user has entered text, update our field.
        if($crrent_zipcode != $posted_val){
                delete_option( $crrent_zipcode ); //delete previous to avoid duplication
                update_option( 'zip_'.$mlp_cat_zipcode.'_linked', $term_id ); // Sanitize our data before adding to the database
                update_option( 'term_'.$term_id.'_linked', $mlp_cat_zipcode ); // Sanitize our data before adding to the database
        }else{

        }
} else { // Category imageUrl IS empty but the option is set, they may not want an imageUrl on this category
        delete_option( 'zip_'.$mlp_cat_zipcode.'_linked' ); // Delete our
        delete_option( 'term_'.$term_id.'_linked');
}

} // End Function
add_action ( 'created_category', 'acl_save_mlp_category_zipcode' );
add_action ( 'edited_category', 'acl_save_mlp_category_zipcode' );


function acl_mlp_custom_scripts() {

        wp_enqueue_style( 'mlp-slick-css', plugin_dir_url( __FILE__ ) .'/assets/lib/slick/slick.css');
        wp_enqueue_style( 'mlp-themes-slick-css', plugin_dir_url( __FILE__ ) .'/assets/lib/slick/slick-theme.css');
        wp_enqueue_script( 'mlp-slick-js', plugin_dir_url( __FILE__ ) . '/assets/lib/slick/slick.min.js', array(), '', true );
        wp_enqueue_script( 'mlp-slick-init-js', plugin_dir_url( __FILE__ ) . '/assets/js/slick-init.js', array(), '', true );
		wp_enqueue_style( 'acl-mlp-shortcodes-styles', plugin_dir_url( __FILE__ ) . '/assets/css/acl-mlp-shortcodes-styles.css', array(), time(), 'all' );

      }
add_action( 'wp_enqueue_scripts', 'acl_mlp_custom_scripts' );


function get_post_categories($post_id){

	$category_detail = get_the_category($post_id, 'category');//$post->ID
	$posts_cat_arr =  array();
	if(!empty($category_detail)){
		foreach($category_detail as $cd){
		 array_push($posts_cat_arr,$cd->cat_name);
		}
		$post_cat = implode(", ",$posts_cat_arr);
	}else{
		$post_cat = "";
	}
	
	

	return $post_cat;
}




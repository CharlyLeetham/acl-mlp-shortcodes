<?php
/*
Plugin Name: ACL MLP Shortcodes
Plugin URI: http://askcharlyleetham.com
Description: Shortcode query to use with Elementor to display dynamic templates
Version: 1.0
Author: Sam
Author URI: http://askcharlyleetham.com
License: GPL

Changelog
Version 1.0 - Original Version
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
                'sectionheading'=> '',
                'suburb_pos' => '',
         ), $atts ) );

        $crnt_zipcode = $_GET['zip']; //get zipcode from url
        $zipcode_records = get_option( 'zipcodes_rec' ); //get all zipcode records
        $crrent_zipcode_data = $zipcode_records[$crnt_zipcode]; //get crrent zipcode section data
        $section_cat_id = $crrent_zipcode_data[$section]; //get crrent section cat id

        if ( $type == 'cat' ) {
                if ( $layout == 'carousel'  ){

                        ob_start(  );
                        require_once( 'shortcode-layouts/layout_my_local_pages_posts_carousel.php' );
                        return ob_get_clean(  );

                } elseif( $layout == 'sidebyside' ){

                        ob_start(  );
                        require_once( 'shortcode-layouts/layout_my_local_pages_posts_col.php' );
                        return ob_get_clean(  );

                } else {


                        if ( $section == 'Section 10 middle' ) {
                                ob_start(  );
                                require_once( 'shortcode-layouts/layout_my_local_pages_posts_middle_grid.php' );
                                return ob_get_clean(  );

                        } else{

                                ob_start(  );
                                require_once( 'shortcode-layouts/layout_my_local_pages_posts_grid.php' );
                                return ob_get_clean(  );

                        }

                }
        } else {

                 if ( $section == 'Section 10 left' ) {

                                $ad_split_arr =  explode( " ",$section_cat_id );
                                $ad_id = $ad_split_arr[3];
                                //exit;
                                echo do_shortcode( '[bsa_pro_ad_space id='.$ad_id.']' );

                } elseif ( $section == 'Section 10 right' ){

                        $ad_split_arr =  explode( " ",$section_cat_id );
                                $ad_id = $ad_split_arr[3];
                                //exit;
                                echo do_shortcode( '[bsa_pro_ad_space id='.$ad_id.']' );

                } else {
                        $ad_split_arr =  explode( " ",$section_cat_id );
                                $ad_id = $ad_split_arr[3];
                                //exit;
                                echo do_shortcode( '[bsa_pro_ad_space id='.$ad_id.']' );
                }
        }
}
add_shortcode( 'my_local_pages_posts' , 'acl_my_local_pages_posts_callback' );

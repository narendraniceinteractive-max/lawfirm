<?php

/* Breadcrumb override - Require ACF and Breadcrumb NavXT plugin to be installed */

//ACF Fields needed to make this work

add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
	'key' => 'group_6657a54930dfa',
	'title' => 'Custom Breadcrumb Override',
	'fields' => array(
		array(
			'key' => 'field_6657a5498572f',
			'label' => 'Override Default Breadcrumb?',
			'name' => 'override_default_breadcrumb',
			'aria-label' => '',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'ui' => 1,
		),
		array(
			'key' => 'field_6657a6d2e36ad',
			'label' => 'Breadcrumb Override - Home will default first in breadcrumb and current page as last automatically. No need to set those below.',
			'name' => 'breadcrumb_override',
			'aria-label' => '',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_6657a5498572f',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'table',
			'sub_fields' => array(
				array(
					'key' => 'field_6657a6fce36ae',
					'label' => 'Link1',
					'name' => 'link1',
					'aria-label' => '',
					'type' => 'link',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
				),
				array(
					'key' => 'field_6657a759e36b0',
					'label' => 'Link2',
					'name' => 'link2',
					'aria-label' => '',
					'type' => 'link',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
				),
				array(
					'key' => 'field_6657a769e36b2',
					'label' => 'Link3',
					'name' => 'link3',
					'aria-label' => '',
					'type' => 'link',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );
} );



//Breadcrumb NavXT hook 
add_action( 'bcn_after_fill', 'project_rebuild_breadcrumbs' );
function project_rebuild_breadcrumbs( $breadcrumb ) {

    //check if acf and navxt are active on site
    if (!class_exists('ACF')) { return; }
    if (!function_exists('bcn_display')) { return;  } 

    //check toggle if override is true or false
    $overrideBreadcrumb = get_field('override_default_breadcrumb');

    if (!$overrideBreadcrumb) {
       //if toggle set to false then don't do anything since we are not overriding
        return;
    }

    //if true update the breadcrumb with the new information
    $getThePostType = get_post_type();
    $groupValuesLinks = get_field('breadcrumb_override');
    $override_item_breadcrumb = [];
    $newBreadcrumbs = [];

    // Store the first and last breadcrumbs, we're rebuilding the middle part.
    $breadcrumb_root = reset( $breadcrumb->breadcrumbs );
    $breadcrumb_end  = end( $breadcrumb->breadcrumbs );

    // Set default breadcrumb template base on post type, defaults to page
    if ($getThePostType === 'page') {
        $breadcrumb_template = $breadcrumb->opt['Hpost_page_template'];
    } else if ($getThePostType === 'post') {
        $breadcrumb_template = $breadcrumb->opt['Hpost_post_template'];
    } else {
        $breadcrumb_template = $breadcrumb->opt['Hpost_page_template'];
    }

    //Build our override breadcrumb by looping through acf fields on page
     foreach ($groupValuesLinks as $key => $invdLink) {

            //will loop through till it find an empty one and then break out
            if (empty($invdLink)) { break;}

            $parsedLink= wp_parse_url( $invdLink['url'] ); // Parse URL
            $slugLink = substr($parsedLink['path'], 1 ); // Trim slash in the beginning

            //get the info from acf field to make new breadcrumbs
            $breadcrumbLinkID = url_to_postid(  $slugLink  );  
            $breadcrumb_title = $invdLink['title'];
            $breadcrumb_link = $invdLink['url'];
        
       
            //add new breadcrumb to array
            $override_item_breadcrumb[] = new bcn_breadcrumb( $breadcrumb_title, $breadcrumb_template, [], $breadcrumb_link, $breadcrumbLinkID );
      }    
 
    //create array of the new override breadcrumbs   
    $override_item_breadcrumb=array_reverse($override_item_breadcrumb);

    array_push($newBreadcrumbs , $breadcrumb_root); 
    array_push($newBreadcrumbs , ...$override_item_breadcrumb); 
    array_push($newBreadcrumbs , $breadcrumb_end); 
    
    //update the Breadcrumb NavXT object wiht our overrides
    $breadcrumb->breadcrumbs =  $newBreadcrumbs;

}

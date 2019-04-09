<?php

/**
 * Helper class of SPu for admin
 *
 * @package SocialPopup_Admin
 * @author  Damian Logghe <info@timersys.com>
 */
class Spu_Helper {
	/**
	 * Plugin slug
	 * @var string
	 */
	protected static $plugin_slug = '';

	/**
	*  ajax_render_operator
	*
	*  @description creates the HTML for the field group operator metabox. Called from both Ajax and PHP
	*  @since 1.4.6
	*  I took this functions from the awesome Advanced custom fields plugin http://www.advancedcustomfields.com/
	*/
	
	public static function ajax_render_operator( $options = array() ) {
		// defaults
		$defaults = array(
			'group_id' => 0,
			'rule_id' => 0,
			'value' => null,
			'param' => null,
		);

		$is_ajax = false;

		if( isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'spu_nonce') )
		{
			$is_ajax = true;
		}

		// Is AJAX call?
		if( $is_ajax )
		{
			$options = array_merge($defaults, $_POST);
			$options['name'] = 'spu_rules[' . $options['group_id'] . '][' . $options['rule_id'] . '][operator]';
		}
		else
		{
			$options = array_merge($defaults, $options);
		}
		// default for all rules
		$choices = array(
			'=='	=>	__("is equal to", 'popups' ),
			'!='	=>	__("is not equal to", 'popups' ),
		);
		if( $options['param'] == 'local_time' ) {
			$choices = array(
				'<'	=>	__("less than", 'popups' ),
				'>'	=>	__("greater than", 'popups' ),
			);
		}

		if(  $options['param'] == 'date' ) {
			$choices = array_merge( $choices,array(
				'<'	=>	__("less than", 'popups' ),
				'>'	=>	__("greater than", 'popups' ),
			));
		}

		// allow custom operators
		$choices = apply_filters( 'spu/metaboxes/rule_operators', $choices, $options );
		
		self::print_select( $options, $choices );

		// ajax?
		if( $is_ajax )
		{
			die();
		}
	}
	
	/**
	*  ajax_render_rules
	*
	*  @description creates the HTML for the field group rules metabox. Called from both Ajax and PHP
	*  @since 2.0
	*  I took this functions from the awesome Advanced custom fields plugin http://www.advancedcustomfields.com/
	*/

	public static function ajax_render_rules( $options = array() )
	{

		// defaults
		$defaults = array(
			'group_id' => 0,
			'rule_id' => 0,
			'value' => null,
			'param' => null,
		);
		
		$is_ajax = false;
		
		if( isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'spu_nonce') )
		{
			$is_ajax = true;
		}
		
		// Is AJAX call?
		if( $is_ajax )
		{
			$options = array_merge($defaults, $_POST);
			$options['name'] = 'spu_rules[' . $options['group_id'] . '][' . $options['rule_id'] . '][value]';
		}
		else
		{
			$options = array_merge($defaults, $options);
		}
		
		// vars
		$choices = array();
		
		
		// some case's have the same outcome
		if($options['param'] == "page_parent")
		{
			$options['param'] = "page";
		}

		
		switch($options['param'])
		{
			case "post_type":
				
				// all post types except attachment
				$choices = apply_filters('spu/get_post_types', array(), array('attachment') );

				break;
			
			
			case "page":
				
				$post_type = 'page';
				$args = array(
					'posts_per_page'			=>	-1,
					'post_type'					=> $post_type,
					'orderby'					=> 'menu_order title',
					'order'						=> 'ASC',
					'post_status'				=> 'any',
					'suppress_filters'			=> false,
					'update_post_meta_cache'	=> false,
				);

				$posts = get_posts( apply_filters('spu/rules/page_args', $args ) );
				
				if( $posts )
				{
					// sort into hierachial order!
					if( is_post_type_hierarchical( $post_type ) )
					{
						$posts = get_page_children( 0, $posts );
					}
					
					foreach( $posts as $page )
					{
						$title = '';
						$ancestors = get_ancestors($page->ID, 'page');
						if($ancestors)
						{
							foreach($ancestors as $a)
							{
								$title .= '- ';
							}
						}
						
						$title .= apply_filters( 'the_title', $page->post_title, $page->ID );
						
						
						// status
						if($page->post_status != "publish")
						{
							$title .= " ($page->post_status)";
						}
						
						$choices[ $page->ID ] = $title;
						
					}
					// foreach($pages as $page)
				
				}
				
				break;
			
			
			case "page_type" :
				
				$choices = array(
					'all_pages'		=>	__("All Pages", 'popups'),
					'front_page'	=>	__("Front Page", 'popups'),
					'posts_page'	=>	__("Posts Page", 'popups'),
					'category_page'	=>	__("Category Page", 'popups'),
					'search_page'	=>	__("Search Page", 'popups'),
					'archive_page'	=>	__("Archives Page", 'popups'),
					'top_level'		=>	__("Top Level Page (parent of 0)", 'popups'),
					'parent'		=>	__("Parent Page (has children)", 'popups'),
					'child'			=>	__("Child Page (has parent)", 'popups'),
				);
								
				break;
				
			case "page_template" :
				
				$choices = array(
					'default'	=>	__("Default Template", 'popups'),
				);
				
				$templates = get_page_templates();
				foreach($templates as $k => $v)
				{
					$choices[$v] = $k;
				}
				
				break;
			
			case "post" :
				$post_types = apply_filters('spu/get_post_types', array());
				unset( $post_types['page'], $post_types['attachment'], $post_types['revision'] , $post_types['nav_menu_item'], $post_types['spucpt']  );
				if( $post_types )
				{
					foreach( $post_types as $post_type )
					{
						$args  = array(
							'numberposts' => '-1',
							'post_type' => $post_type,
							'post_status' => array('publish', 'private', 'draft', 'inherit', 'future'),
							'suppress_filters' => false,
                            'update_post_meta_cache' => false,
                            'update_post_term_cache' => false,
						);
						$posts = get_posts(apply_filters('spu/rules/post_args', $args ));
						
						if( $posts)
						{
							$choices[$post_type] = array();
							
							foreach($posts as $post)
							{
								$title = apply_filters( 'the_title', $post->post_title, $post->ID );
								
								// status
								if($post->post_status != "publish")
								{
									$title .= " ($post->post_status)";
								}
								
								$choices[$post_type][$post->ID] = $title;

							}
							// foreach($posts as $post)
						}
						// if( $posts )
					}
					// foreach( $post_types as $post_type )
				}
				// if( $post_types )
				
				
				break;
			
			case "post_category" :
				
				$categories 	= get_terms('category', array('get' => 'all', 'fields' => 'id=>name' ) );
				$choices	= apply_filters('spu/rules/categories', $categories );	
				
				break;
			
			case "post_format" :
				
				$choices = get_post_format_strings();
								
				break;
			
			case "post_status" :

				$choices = get_post_stati();
								
				break;
			
			case "user_type" :
				
				global $wp_roles;
				
				$choices = $wp_roles->get_names();

				if( is_multisite() )
				{
					$choices['super_admin'] = __('Super Admin');
				}
								
				break;
			
			case "taxonomy" :
				
				$choices = array();
				$simple_value = true;
				$choices = apply_filters('spu/get_taxonomies', $choices, $simple_value);
								
				break;
			
			case "logged_user" :
			case "mobiles" :
			case "tablets" :
			case "desktop" :
			case "crawlers" :
			case "left_comment" :
			case "search_engine" :
			case "same_site" :
												
				$choices = array('true' => __( 'True',  'popups' ) );
			
				break;
				
				
		}
		
		
		// allow custom rules rules
		$choices = apply_filters( 'spu/rules/rule_values/' . $options['param'], $choices );

		// Custom fields for rules
		do_action( 'spu/rules/print_' . $options['param'] . '_field', $options, $choices );

		// ajax?
		if( $is_ajax )
		{
			die();
		}
	}	

	/**
	 * Helper function to print select fields for rules
	 * @since  2.0
	 * @param  array  $choices options values for select
	 * @param  array  $options array to pass group, id, rule_id etc
	 * @return echo  the select field
	 */
	static function print_select( $options, $choices ) {
		
		// value must be array
		if( !is_array($options['value']) )
		{
			// perhaps this is a default value with new lines in it?
			if( strpos($options['value'], "\n") !== false )
			{
				// found multiple lines, explode it
				$options['value'] = explode("\n", $options['value']);
			}
			else
			{
				$options['value'] = array( $options['value'] );
			}
		}
		
		
		// trim value
		$options['value'] = array_map('trim', $options['value']);
		// determin if choices are grouped (2 levels of array)
		if( is_array($choices) )
		{
			foreach( $choices as $k => $v )
			{
				if( is_array($v) )
				{
					$optgroup = true;
				}
			}
		}

		echo '<select id="spu_rule_'.$options['group_id'].'_rule_'.$options['rule_id'].'" class="select" name="'.$options['name'].'">';

		// loop through values and add them as options
		if( is_array($choices) )
		{
			foreach( $choices as $key => $value )
			{
				if( isset($optgroup) )
				{
					// this select is grouped with optgroup
					if($key != '') echo '<optgroup label="'.$key.'">';
					
					if( is_array($value) )
					{
						foreach($value as $id => $label)
						{

							$selected = in_array($id, $options['value']) ? 'selected="selected"' : '';
														
							echo '<option value="'.$id.'" '.$selected.'>'.$label.'</option>';
						}
					}
					
					if($key != '') echo '</optgroup>';
				}
				else
				{
					$selected = in_array($key, $options['value']) ? 'selected="selected"' : '';
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
				}
			}
		}


		echo '</select>';

	}

	/**
	 * Prints a text field rule
	 * @param $options
	 */
	static function print_textfield( $options ) {
		echo '<input type="text" name="'.$options['name'].'" value="'.$options['value'].'" id="spu_rule_'.$options['group_id'].'_rule_'.$options['rule_id'].'" />';
	}

	/**
	 * Return the box options
	 * @param  int $id spucpt id
	 * @since  2.0
	 * @return array metadata values
	 */
	function get_box_options( $id )
	{
		$defaults = array(
			'css' => array(
				'bgopacity'			=> '0.5',
				'overlay_color'		=> '#000',
				'background_color'	=> '#eeeeee',
				'background_opacity'=> '1',
				'width'				=> '600px',
				'padding'			=> '25',
				'color'				=> '#333',
				'shadow_color'		=> '#666',
				'shadow_type'		=> 'outset',
				'shadow_x_offset'	=> '0',
				'shadow_y_offset'	=> '0',
				'shadow_blur'	    => '10',
				'shadow_spread'	    => '1',
				'border_color'		=> '#eee',
				'border_width'		=> '8',
				'border_radius'		=> '0',
				'border_type'		=> 'none',
				'close_color'		=> '#666',
				'close_hover_color'	=> '#000',
				'close_size'		=> '30px',
				'close_position'	=> 'top_right',
				'close_shadow_color'=> '#fff',
				'position' 			=> 'centered',
			),
			'trigger'					=> 'seconds',
			'trigger_number'			=> '5',
			'animation'					=> 'fade',
			'duration-convert-cookie'	=> '999',
			'type-convert-cookie'		=> 'd',
			'duration-close-cookie'		=> '30',
			'type-close-cookie'			=> 'd',
			'name-convert-cookie'		=> 'spu_conversion',
			'name-close-cookie'			=> 'spu_closing',
			'auto_hide'					=> 0,
			'test_mode'					=> 0,
			'conversion_close'  		=> '1',
			'powered_link'      		=> '0',
		);
		
		$opts = apply_filters( 'spu/metaboxes/box_options', get_post_meta( $id, 'spu_options', true ), $id );

		$opts = wp_parse_args( $opts, apply_filters( 'spu/metaboxes/default_options', $defaults ) );
		// we added new rules as we can't merge recursively, so manual check them
		foreach ( $defaults['css'] as $key => $value ) {
			if( ! isset($opts['css'][$key] ) )
				$opts['css'][$key] = $value;
		}

		return $opts;
	}	

	/**
	 * Return the box rules
	 * @param  int $id spucpt id
	 * @since  2.0
	 * @return array metadata values
	 */
	function get_box_rules( $id )
	{
		$defaults = array(
			// group_0
			array(
				
				// rule_0
				array(
					'param'		=>	'page_type',
					'operator'	=>	'==',
					'value'		=>	'all_pages',
					'order_no'	=>	0,
					'group_no'	=>	0
				)
			)
		);
		
		$rules = get_post_meta( $id, 'spu_rules', true );

		if( empty( $rules ) ) {

			return apply_filters( 'spu/metaboxes/default_rules', $defaults );

		} else {

			return $rules;
			
		}

		
	}

	/**
	 * Simple HEX TO RGBA converter
	 * @param $color
	 * @param bool $opacity
	 *
	 * @return string
	 */
	public static function hex2rgba($color, $opacity = false) {

		$default = 'rgb(0,0,0)';

		//Return default if no color provided
		if(empty($color))
			return $default;

		//Sanitize $color if "#" is provided
		if ($color[0] == '#' ) {
			$color = substr( $color, 1 );
		}

		//Check if color has 6 or 3 characters and get values
		if (strlen($color) == 6) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}

		//Convert hexadec to rgb
		$rgb =  array_map('hexdec', $hex);

		//Check if opacity is set(rgba or rgb)
		if($opacity){
			if(abs($opacity) > 1)
				$opacity = 1.0;
			$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
		} else {
			$output = 'rgb('.implode(",",$rgb).')';
		}

		//Return rgb(a) color string
		return $output;
	}
}	
<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/*
*  Meta box - Rules
*
*  This template file is used when editing a popup and creates the interface for editing popup rules.
*
*  @type	template
*  @since	2.0
*/
?>

<table class="spu_table widefat" id="spu_ruñes">
	<tbody>
	<tr>
		<td class="label">
			<label for="post_type"><?php _e("Rules", $this->plugin_slug ); ?></label>
			<p class="description"><?php _e("Create a set of rules to determine where the popup will show", $this->plugin_slug ); ?></p>
		</td>
		<td>
			<div class="rules-groups">
				
<?php if( is_array($groups) ): ?>
	<?php foreach( $groups as $group_id => $group ): 
		$group_id = 'group_' . $group_id;
		?>
		<div class="rules-group" data-id="<?php echo $group_id; ?>">
			<?php if( $group_id == 'group_0' ): ?>
				<h4><?php _e("Show this popup if", $this->plugin_slug ); ?></h4>
			<?php else: ?>
				<h4><?php _e("or", $this->plugin_slug ); ?></h4>
			<?php endif; ?>
			<?php if( is_array($group) ): ?>
			<table class="spu_table widefat">
				<tbody>
					<?php foreach( $group as $rule_id => $rule ): 
						$rule_id = 'rule_' . $rule_id;
					?>
					<tr data-id="<?php echo $rule_id; ?>">
					<td class="param"><?php 
						
						$choices = array(
							__("User", $this->plugin_slug ) => array(
								'user_type'		=>	__("User role", $this->plugin_slug ),
								'logged_user'	=>	__("User is logged", $this->plugin_slug ),
								'left_comment'	=>	__("User never left a comment", $this->plugin_slug ),
								'search_engine'	=>	__("User came via a search engine", $this->plugin_slug ),
								'same_site'		=>	__("User did not arrive via another page on your site", $this->plugin_slug ),
							),
							__("Post", $this->plugin_slug ) => array(
								'post'			=>	__("Post", $this->plugin_slug ),
								'post_type'		=>	__("Post Type", $this->plugin_slug ),
								'post_category'	=>	__("Post Category", $this->plugin_slug ),
								'post_format'	=>	__("Post Format", $this->plugin_slug ),
								'post_status'	=>	__("Post Status", $this->plugin_slug ),
								'taxonomy'		=>	__("Post Taxonomy", $this->plugin_slug ),
							),
							__("Page", $this->plugin_slug ) => array(
								'page'			=>	__("Page", $this->plugin_slug ),
								'page_type'		=>	__("Page Type", $this->plugin_slug ),
								'page_parent'	=>	__("Page Parent", $this->plugin_slug ),
								'page_template'	=>	__("Page Template", $this->plugin_slug ),
							),
							__("Other", $this->plugin_slug ) => array(
								'mobiles'		=>	__("Mobile Phone", $this->plugin_slug ),
								'tablets'		=>	__("Tablet", $this->plugin_slug ),
							)
						);
								
						
						// allow custom rules rules
						$choices = apply_filters( 'spu/metaboxes/rule_types', $choices );
						
						
						// create field						
						$args = array(
							'group_id' 	=> $group_id,
							'rule_id'	=> $rule_id,
							'name'		=> 'spu_rules[' . $group_id . '][' . $rule_id . '][param]',
							'value' 	=> $rule['param']
						);
						
						Spu_Helper::print_select( $choices, $args );
							
						
					?></td>
					<td class="operator"><?php 	
						
						$choices = array(
							'=='	=>	__("is equal to", $this->plugin_slug ),
							'!='	=>	__("is not equal to", $this->plugin_slug ),
						);
						
						
						// allow custom rules rules
						$choices = apply_filters( 'spu/metaboxes/rule_operators', $choices );
						
						$args = array(
							'group_id' 	=> $group_id,
							'rule_id'	=> $rule_id,
							'name'		=> 'spu_rules[' . $group_id . '][' . $rule_id . '][operator]',
							'value' 	=> $rule['operator']

						);
						
						Spu_Helper::print_select( $choices, $args );

						
					?></td>
					<td class="value"><?php 
						$args = array(
							'group_id' 		=> $group_id,
							'rule_id' 		=> $rule_id,
							'value' 		=> $rule['value'],
							'name'			=> 'spu_rules[' . $group_id . '][' . $rule_id . '][value]',
							'param'			=> $rule['param']
						);
						Spu_Helper::ajax_render_rules( $args ); 
						
					?></td>
					<td class="add">
						<a href="#" class="rules-add-rule button"><?php _e("and", $this->plugin_slug ); ?></a>
					</td>
					<td class="remove">
						<a href="#" class="rules-remove-rule rules-remove-rule">-</a>
					</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
	
	<h4><?php _e("or", $this->plugin_slug ); ?></h4>
	
	<a class="button rules-add-group" href="#"><?php _e("Add rule group", $this->plugin_slug ); ?></a>
	
<?php endif; ?>
				
			</div>
		</td>
	</tr>
	</tbody>
</table>
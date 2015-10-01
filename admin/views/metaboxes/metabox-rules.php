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
			<label for="post_type"><?php _e("Rules", 'popups' ); ?></label>
			<p class="description"><?php _e("Create a set of rules to determine where the popup will show", 'popups' ); ?></p>
		</td>
		<td>
			<div class="rules-groups">
				
<?php if( is_array($groups) ): ?>
	<?php foreach( $groups as $group_id => $group ): 
		$group_id = 'group_' . $group_id;
		?>
		<div class="rules-group" data-id="<?php echo $group_id; ?>">
			<?php if( $group_id == 'group_0' ): ?>
				<h4><?php _e("Show this popup if", 'popups' ); ?></h4>
			<?php else: ?>
				<h4><?php _e("or", 'popups' ); ?></h4>
			<?php endif; ?>
			<?php if( is_array($group) ): ?>
			<table class="spu_table widefat">
				<tbody>
					<?php foreach( $group as $rule_id => $rule ): 
						$rule_id = 'rule_' . $rule_id;
					?>
					<tr data-id="<?php echo $rule_id; ?>">
					<td class="param"><?php 
						
						$choices = $this->get_rules_choices();

						// create field						
						$args = array(
							'group_id' 	    => $group_id,
							'rule_id'	    => $rule_id,
							'name'		    => 'spu_rules[' . $group_id . '][' . $rule_id . '][param]',
							'value' 	    => $rule['param']
						);
						
						Spu_Helper::print_select( $args, $choices );
							
						
					?></td>
					<td class="operator"><?php 	
						
						$choices = array(
							'=='	=>	__("is equal to", 'popups' ),
							'!='	=>	__("is not equal to", 'popups' ),
						);
						
						
						// allow custom rules rules
						$choices = apply_filters( 'spu/metaboxes/rule_operators', $choices );
						
						$args = array(
							'group_id' 	=> $group_id,
							'rule_id'	=> $rule_id,
							'name'		=> 'spu_rules[' . $group_id . '][' . $rule_id . '][operator]',
							'value' 	=> $rule['operator']

						);
						
						Spu_Helper::print_select( $args, $choices );

						
					?></td>
					<td class="value"><?php 
						$args = array(
							'group_id' 		=> $group_id,
							'rule_id' 		=> $rule_id,
							'value' 		=> !empty($rule['value']) ? $rule['value'] : '',
							'name'			=> 'spu_rules[' . $group_id . '][' . $rule_id . '][value]',
							'param'			=> $rule['param'],
						);
						Spu_Helper::ajax_render_rules( $args ); 
						
					?></td>
					<td class="add">
						<a href="#" class="rules-add-rule button"><?php _e("and", 'popups' ); ?></a>
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
	
	<h4><?php _e("or", 'popups' ); ?></h4>
	
	<a class="button rules-add-group" href="#"><?php _e("Add rule group", 'popups' ); ?></a>
	
<?php endif; ?>
				
			</div>
		</td>
	</tr>
	</tbody>
</table>
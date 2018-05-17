<form name="form" autocomplete="off">
<div id="spu_editor" class="shortcode_editor" title="Insert popup link to page"  style="display:none;height:500px">
	<div style="display: none;"><!--hack for chrome-->
		<input type="text" id="PreventChromeAutocomplete" name="PreventChromeAutocomplete" autocomplete="address-level4" />
	</div>
	<table class="form-table">
		<tr>
			<td colspan="2">
				<p>
					<?php _e('Choose which popup you want to insert. This will generate an href link that you can use with text or images', 'spu');?>
				</p>
			</td>
		</tr>
		<tr>
    		<th><label for="spu_what"><?php _e( 'Choose:', 'spu' ); ?></label></th>
    		<td>
				<select name="spu-post" id="spu-posts">
					<option value=""><?php _e('Choose one','spu');?></option>
				<?php

				global $wpdb;
				$popups = $wpdb->get_results( "SELECT post_title, ID FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'spucpt'");

				// The Loop
				if ( $popups ) {
					foreach( $popups as $po ) {
						echo '<option value="'.$po->ID.'">'.$po->post_title.'</option>"';
					}
				}

				 ?>
			 </select>
    		</td>
        </tr>

	</table>
</div>
</form>

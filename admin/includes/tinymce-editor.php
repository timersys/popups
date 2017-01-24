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
					<option value="">
						<?php _e('Choose one','spu');?>
					</option>
				<?php
				// WP_Query arguments
				$args = array(
					'post_type'              => array( 'spucpt' ),
					'post_status'            => array( 'publish' ),
					'posts_per_page'         => '-1',
				);

				// The Query
				$query = new WP_Query( $args );

				// The Loop
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						echo '<option value="'.get_the_id().'">'.get_the_title().'</option>"';
					}
				} else {
				// no posts found
				}

				// Restore original Post Data
				wp_reset_postdata();
				 ?>
    		</td>
        </tr>

	</table>
</div>
</form>

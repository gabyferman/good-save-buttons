<?php
/**
 * Good Save Buttons
 *
 * This plugin adds two extra buttons: 'Save & Add New' and 'Save & Close' to the
 * edit screen.
 *
 * @link https://github.com/gabyferman/good-save-button
 * @package good_save_buttons
 *
 * @wordpress-plugin
 * Plugin Name: Good Save Buttons
 * Plugin URI: https://github.com/gabyferman/good-save-button
 * Description: Adds two extra buttons: 'Save & Add New' and 'Save & Close'.
 * Version: 1.0.0
 * Author: Good Bad Taste by Gaby Ferman
 * Author URI: https://github.com/gabyferman
 * Text Domain:	gsb
 * License: WTPFL
 * License URI: http://www.wtfpl.net
*/

add_action( 'post_submitbox_misc_actions', 'gsb_add_actions', 999 );
add_action( 'admin_head', 'gsb_admin_head_script' );
add_action( 'redirect_post_location', 'gsb_insert_post' );

function gsb_add_actions() {
	global $post;

	echo '
	<div class="misc-pub-section extra-actions misc-pub-section-extra-actions" style="float: right;">
		<input type="hidden" name="tbtn_redirect_post_type" id="tbtn_redirect_post_type" value="' . $post->post_type . '">
		<input type="hidden" name="tbtn_redirect" id="tbtn_redirect" value="no">
		<input type="button" id="prn_publish" name="submit-new" value="' . __( 'Save & Add New', 'gbs' ) . '" class="button button-default">
		<input type="button" id="prn_exit" name="submit-new" value="' . __( 'Save & Close', 'gbs' ) . '" class="button button-default">
	</div>';
}

function gsb_admin_head_script() {
	?>
	<script>
	jQuery(document).ready(function(w) {
		w( '#prn_publish' ).click( function(){
			w( '#tbtn_redirect' ).val( 'yes' );
			w( '#publish' ).trigger( 'click' );
		} );

		w( '#prn_exit' ).click( function(){
			w( '#tbtn_redirect' ).val( 'exit' );
			w( '#publish' ).trigger( 'click' );
		} );
	} );
	</script>
	<?php
}

function gsb_insert_post( $url ) {

	if ( isset( $_POST['tbtn_redirect'] ) AND $_POST['tbtn_redirect'] == 'yes' ) {
		wp_redirect( admin_url( 'post-new.php?post_type='.$_POST['tbtn_redirect_post_type'] ) );
		die();
	} elseif ( isset( $_POST['tbtn_redirect'] ) AND $_POST['tbtn_redirect'] == 'exit' ) {
		wp_redirect( admin_url( 'edit.php?post_type='.$_POST['tbtn_redirect_post_type'] ) );
		die();
	}

	return $url;
}

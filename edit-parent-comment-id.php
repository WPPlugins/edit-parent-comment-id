<?php
/*
Plugin Name: Edit Parent Comment ID
Version: 0.3
Plugin URI: http://uplift.ru/projects/
Description: Adds parent comment ID meta box to a comment editing page. Use to make existing comments threaded.
Author: Sergey Biryukov
Author URI: http://sergeybiryukov.ru/
*/

function epc_add_meta() {
	load_plugin_textdomain( 'edit-parent-comment-id', false, dirname( plugin_basename( __FILE__ ) ) );
	add_meta_box( 'parent-comment', __( 'Parent Comment ID', 'edit-parent-comment-id' ), 'epc_parent_meta', 'comment', 'normal' );
}
add_action('admin_menu', 'epc_add_meta');

function epc_parent_meta() {
    global $comment;
?>
<input type="text" name="comment_parent" value="<?php echo esc_attr( $comment->comment_parent ); ?>" size="25" />
<?php
}

function epc_save_meta($comment_ID) {
	global $wpdb;
	if ( isset( $_POST['comment_parent'] ) )
		$wpdb->update( $wpdb->comments, array( 'comment_parent' => absint( $_POST['comment_parent'] ) ), array( 'comment_ID' => $comment_ID ) );
}
add_action('edit_comment', 'epc_save_meta');
?>
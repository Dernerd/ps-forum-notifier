<?php

function ps_forum_notifier_the_mail_subscription_button( $group_id = '' ) {
	echo ps_forum_notifier_get_mail_subscription_button( $group_id );
}

/**
 * Returns the button for toggling per-group-forum subscriptions
 */

function ps_forum_notifier_get_mail_subscription_button( $group_id = '' ) {
	if ( function_exists( 'is_buddypress' ) && is_buddypress() ) {
		$nonce = wp_create_nonce( 'ps-forum-notifier-toggle-subscription' );
		if ( ! $group_id ) {
			$group_id = bp_get_group_id();
		}
		$string = __( 'Neue Themen & Antworten abbestellen', 'ps-forum-notifier' );
		$action = 'unsubscribe';

		if ( $users = groups_get_groupmeta( $group_id, 'ps-forum-notifier-mail-unsubscribe' ) ) {
			if ( in_array( bp_loggedin_user_id(), $users ) ) {
				$string = __( 'Neue Themen & Antworten abonnieren', 'ps-forum-notifier' );
				$action = 'subscribe';
			}
		}

		return sprintf( '<span id="ps-forum-notifier-wrapper"><a href="#" class="subscription-toggle" id="ps-forum-notifier-toggle-subscription" data-nonce="%s" data-group_id="%d" data-action="%s">%s</a></span>', $nonce, $group_id, $action, $string );
	}
}
add_action( 'psf_template_before_single_forum', 'ps_forum_notifier_the_mail_subscription_button' );

/**
 * Handles the ajax request for toggling subscriptions on a per-group-forum basis
 */

function ps_forum_notifier_toggle_subscription() {
	check_ajax_referer( 'ps-forum-notifier-toggle-subscription', 'nonce' );

	$group_id = absint( $_POST['group_id'] );

	if ( groups_is_user_member( bp_loggedin_user_id(), $group_id ) ) {
		$users = groups_get_groupmeta( $group_id, 'ps-forum-notifier-mail-unsubscribe' );
		if ( $_POST['subscribe_or_unsubscribe'] == 'unsubscribe' && ! in_array( bp_loggedin_user_id(), $users ) ) {
			$users[] = bp_loggedin_user_id();
		} elseif ( $_POST['subscribe_or_unsubscribe'] == 'subscribe' && is_int( $key = array_search( bp_loggedin_user_id(), $users ) ) ) {
			unset( $users[$key] );
		}
		groups_update_groupmeta( $group_id, 'ps-forum-notifier-mail-unsubscribe', (array) $users );
		echo ps_forum_notifier_get_mail_subscription_button( $group_id );
		die();
	} else {
		echo '-1';
		die();
	}
}
add_action( 'wp_ajax_ps_forum_notifier_toggle_subscription', 'ps_forum_notifier_toggle_subscription' );

/**
 * Remove psforum' notifications if on a group forum since this plugin takes care of those...
 */
function ps_forum_notifier_maybe_remove_psf_notifications() {
	if ( ps_forum_notifier_notify_on_all_replies() && bp_is_groups_component() && bp_is_current_action( 'forum' ) ) {
		remove_action( 'psf_new_reply', 'psf_buddypress_add_notification', 10, 7 );
	}
}
add_action( 'psf_new_reply', 'ps_forum_notifier_maybe_remove_psf_notifications', 1 );

?>
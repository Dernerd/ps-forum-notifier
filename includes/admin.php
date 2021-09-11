<?php

class PS_Forum_Notifier_Admin {

	static public function __setup() {
		add_action( 'init', array( 'PS_Forum_Notifier_Admin', 'init' ) );
	}

	static public function init() {
		if( is_super_admin() ) {
			add_action( 'admin_init', array( 'PS_Forum_Notifier_Admin', 'admin_page_save' ) );
			add_action( 'admin_menu', array( 'PS_Forum_Notifier_Admin', 'admin_menu' ) );
		}
	}

	/**
	 * Retrieves current settings
	 * @return array
	 */
	static public function get_settings() {
		$settings = get_option( 'ps_forum_notifier_settings', get_site_option( 'ps_forum_notifier_settings', array() ) );
		$defaults = array(
			'notifications-for-all-replies' => 'no',
			'mail-delay' => '15',
			'multiple-mail-messages-subject' => __( '[%1$s] %2$d neue Forenaktivitäten', 'ps-forum-notifier' ),
			'reply-notification-single' => __( '%2$s hat eine neue Antwort in %3$s geschrieben', 'ps-forum-notifier' ),
			'reply-notification-multi' => __( '%2$d neue Antworten in %3$s', 'ps-forum-notifier' ),
			'reply-mail-subject-single' => __( '[%1$s] Eine neue Antwort in %3$s', 'ps-forum-notifier' ),
			'reply-mail-subject-multi' => __( '[%1$s] %2$d neue Antworten in %3$s', 'ps-forum-notifier' ),
			'reply-mail-message-line' => __( '%1$s hat eine Antwort in %2$s geschrieben:
%3$s
Beitragslink: %4$s', 'ps-forum-notifier' ),
			'topic-notification-single' => __( '%2$s hat ein neues Thema in %3$s geschrieben', 'ps-forum-notifier' ),
			'topic-notification-multi' => __( '%2$d neue Themen in %3$s', 'ps-forum-notifier' ),
			'topic-mail-subject-single' => __( '[%1$s] Ein neues Thema in %3$s', 'ps-forum-notifier' ),
			'topic-mail-subject-multi' => __( '[%1$s] %2$d neue Themen in %3$s', 'ps-forum-notifier' ),
			'topic-mail-message-line' => __( '%1$s hat ein Thema in %2$s geschrieben:
%3$s
Beitragslink: %4$s', 'ps-forum-notifier' ),
			'quote-notification-single' => __( '%2$s hat Dich in %3$s zitiert', 'ps-forum-notifier' ),
			'quote-notification-multi' => __( 'Du wurdest %2$d Mal in %3$s zitiert', 'ps-forum-notifier' ),
			'quote-mail-subject-single' => __( '[%1$s] Du wurdest in %3$s zitiert', 'ps-forum-notifier' ),
			'quote-mail-subject-multi' => __( '[%1$s] Du wurdest %2$d Mal in %3$s zitiert', 'ps-forum-notifier' ),
			'quote-mail-message-line' => __( '%1$s hat Dich in %2$s zitiert:
%3$s
Beitragslink: %4$s', 'ps-forum-notifier' ),
			'mail-message-wrap' => __( '%1$s

--------------------

Du erhältat diese E-Mail, weil Du ein Forumsthema abonniert hast.

Melde Dich an und besuche das Thema, um Dich von diesen E-Mails abzumelden.', 'ps-forum-notifier' )
		);

		if( is_array( $settings ) ) {
			foreach( $defaults as $key => $val ) {
				if( array_key_exists( $key, $settings ) ) {
					$defaults[ $key ] = $settings[ $key ];
				}
			}
		}

		return $defaults;
	}

	/**
	 * Adds menu item
	 * @return void
	 */
	public static function admin_menu() {
		add_submenu_page(
			'options-general.php',
			__( 'Forum Benachrichtigung Einstellungen', 'ps-forum-notifier' ),
			__( 'Forum Benachrichtigung', 'ps-forum-notifier' ),
			'manage_options',
			'forum-notifier',
			array( 'PS_Forum_Notifier_Admin', 'admin_page' )
		);
	}

	/**
	 * Prints an admin page through template
	 * @return void
	 */
	public static function admin_page() {
		global $settings;
		$settings = self::get_settings();
		PS_Forum_Notifier::get_template( 'ps-forum-notifier-admin' );
	}

	/**
	 * Receives the posted admin form and saved the settings
	 * @return void
	 */
	public static function admin_page_save() {
		if( array_key_exists( 'forum-notifier-save', $_POST ) ) {
			check_admin_referer( 'ps_forum_notifier_admin' );
			$settings = self::get_settings();

			foreach( $settings as $key => $val ) {
				if( array_key_exists( $key, $_POST ) ) {
					$settings[ $key ] = $_POST[ $key ];
				}
			}

			update_option( 'ps_forum_notifier_settings', $settings );
			wp_redirect( add_query_arg( array( 'forum-notifier-updated' => '1' ) ) );
		} elseif( array_key_exists( 'forum-notifier-updated', $_GET ) ) {
			add_action( 'admin_notices', create_function( '', sprintf(
				'echo "<div class=\"updated\"><p>%s</p></div>";',
				__( 'Einstellungen aktualisiert.', 'ps-forum-notifier' )
			) ) );
		}
	}

}

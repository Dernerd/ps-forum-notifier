<?php global $settings;

$fields = array(
	'notifications-for-all-replies'  => array( 'checkbox',  __( 'Bei Antworten immer benachrichtigen', 'ps-forum-notifier' ), __( 'In older versions (< 1.4) the plugin would only notify members of new replies if they had "subscribed" to the topic. By checking this box groupmembers will get notifications from all replies in group forums.', 'ps-forum-notifier' ) ),
	'mail-delay'                     => array( 'textfield', __( 'Verzögerung in Minuten, bevor E-Mails gesendet werden', 'ps-forum-notifier' ) ),
	'multiple-mail-messages-subject' => array( 'textfield', __( 'E-Mail-Betreff, wenn die Nachricht mehrere Forenaktivitäten enthält', 'ps-forum-notifier' ), __( '%1$s = blogname, %2$d = number of activities', 'ps-forum-notifier' ) ),
	'reply-notification-single'      => array( 'textfield', __( 'Antwortbenachrichtigung (einzelne Antwort)', 'ps-forum-notifier' ), __( '%1$s = blogname, %2$s = author, %3$s = topic title', 'ps-forum-notifier' ) ),
	'reply-notification-multi'       => array( 'textfield', __( 'Antwortbenachrichtigung (mehrere Antworten im selben Thema)', 'ps-forum-notifier' ), __( '%1$s = blogname, %2$d = number or replies, %3$s = topic title', 'ps-forum-notifier' ) ),
	'reply-mail-subject-single'      => array( 'textfield', __( 'Betreff der E-Mail-Antwort (Einzelantwort)', 'ps-forum-notifier' ), __( '%1$s = blogname, %2$s = author, %3$s = topic title', 'ps-forum-notifier' ) ),
	'reply-mail-subject-multi'       => array( 'textfield', __( 'Betreff der E-Mail-Antwort (mehrere Antworten im selben Thema)', 'ps-forum-notifier' ), __( '%1$s = blogname, %2$d = number of replies, %3$s = topic title', 'ps-forum-notifier' ) ),
	'reply-mail-message-line'        => array( 'textarea',  __( 'Nachrichtentext der Antwort-E-Mail', 'ps-forum-notifier' ), __( '%1$s = author, %2$s = topic title, %3$s = reply, %4$s = topic link', 'ps-forum-notifier' ) ),
	'topic-notification-single'      => array( 'textfield', __( 'Themenbenachrichtigung (Einzelthema)', 'ps-forum-notifier' ), __( '%1$s = blogname, %2$s = author, %3$s = forum title', 'ps-forum-notifier' ) ),
	'topic-notification-multi'       => array( 'textfield', __( 'Themenbenachrichtigung (mehrere Themen im selben Forum)', 'ps-forum-notifier' ), __( '%1$s = blogname, %2$d = number of topics, %3$s = forum title', 'ps-forum-notifier' ) ),
	'topic-mail-subject-single'      => array( 'textfield', __( 'Thema E-Mail-Betreff (Einzelthema)', 'ps-forum-notifier' ), __( '%1$s = blogname, %2$s = author, %3$s = forum title', 'ps-forum-notifier' ) ),
	'topic-mail-subject-multi'       => array( 'textfield', __( 'Thema E-Mail-Betreff (mehrere Themen im selben Forum)', 'ps-forum-notifier' ), __( '%1$s = blogname, %2$d = number of topics, %3$s = forum title', 'ps-forum-notifier' ) ),
	'topic-mail-message-line'        => array( 'textarea',  __( 'Thema E-Mail-Nachrichtentext', 'ps-forum-notifier' ), __( '%1$s = author, %2$s = forum title, %3$s = topic, %4$s = topic link', 'ps-forum-notifier' ) ),
	'quote-notification-single'      => array( 'textfield', __( 'Angebotsbenachrichtigung (Einzelangebot)', 'ps-forum-notifier' ), __( '%1$s = blogname, %2$s = author, %3$s = topic title', 'ps-forum-notifier' ) ),
	'quote-notification-multi'       => array( 'textfield', __( 'Angebotsbenachrichtigung (mehrere Zitate im selben Thema)', 'ps-forum-notifier' ), __( '%1$s = blogname, %2$d = number or quotes, %3$s = topic title', 'ps-forum-notifier' ) ),
	'quote-mail-subject-single'      => array( 'textfield', __( 'Betreff der Angebots-E-Mail (Einzelangebot)', 'ps-forum-notifier' ), __( '%1$s = blogname, %2$s = author, %3$s = topic title', 'ps-forum-notifier' ) ),
	'quote-mail-subject-multi'       => array( 'textfield', __( 'Betreff der Angebots-E-Mail (mehrere Zitate im selben Thema)', 'ps-forum-notifier' ), __( '%1$s = blogname, %2$d = number or quotes, %3$s = topic title', 'ps-forum-notifier' ) ),
	'quote-mail-message-line'        => array( 'textarea',  __( 'E-Mail-Nachrichtentext zitieren', 'ps-forum-notifier' ), __( '%1$s = author, %2$s = topic title, %3$s = reply, %4$s = topic link', 'ps-forum-notifier' ) ),
	'mail-message-wrap'              => array( 'textarea',  __( 'E-Mail-Nachrichtentextwrapper', 'ps-forum-notifier' ), __( '%1$s = message bodies', 'ps-forum-notifier' ) )
);

?>
<div class="wrap">
	<h2><?php _e( 'Forenbenachrichtigungseinstellungen', 'ps-forum-notifier' ); ?></h2>
	<form action="" method="post">
		<?php wp_nonce_field( 'ps_forum_notifier_admin' ); ?>

		<table class="form-table">
			<tbody>
				<?php foreach( $fields as $field_name => $field ) : ?>
					<tr>
						<th scope="row">
							<label for="<?php echo $field_name; ?>"><?php echo $field[ 1 ]; ?></label>
						</th>
						<td>
							<?php if( $field[ 0 ] == 'textfield' ) : ?>
								<input id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" type="textfield" class="large-text" value="<?php echo esc_attr( $settings[ $field_name ] ); ?>" />
							<?php elseif( $field[ 0 ] == 'textarea' ) : ?>
								<textarea id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="large-text"><?php echo $settings[ $field_name ]; ?></textarea>
							<?php elseif( $field[ 0 ] == 'checkbox' ) : ?>
								<input id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" type="checkbox" value="yes" <?php checked( $settings[ $field_name ], 'yes', true ) ?> />
							<?php endif; ?>

							<?php if( array_key_exists( 2, $field ) ) : ?>
								<br />
								<?php echo $field[ 2 ]; ?>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<p class="submit clear">
			<input class="button-primary" name="forum-notifier-save" type="submit" value="<?php echo esc_attr( __( 'Speichern' ) ); ?>" />
		</p>

	</form>
</div>

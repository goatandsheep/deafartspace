<?php
wp_enqueue_script('jquery-form');

//fields translatable strings
$zass_fields_strings = array();
$zass_fields_strings['name'] = esc_html__('Name', 'zass-plugin');
$zass_fields_strings['email'] = esc_html__('E-Mail Address', 'zass-plugin');
$zass_fields_strings['phone'] = esc_html__('Phone', 'zass-plugin');
$zass_fields_strings['address'] = esc_html__('Street Address', 'zass-plugin');
$zass_fields_strings['subject'] = esc_html__('Subject', 'zass-plugin');

//response messages
$zass_missing_content = esc_html__('Please enter %s.', 'zass-plugin');
$zass_missing_message = esc_html__('Please enter a message.', 'zass-plugin');
$zass_captcha_message = esc_html__('Calculation result was not correct.', 'zass-plugin');
$zass_email_invalid = esc_html__('Email Address Invalid.', 'zass-plugin');
$zass_message_unsent = esc_html__('Message was not sent. Try Again.', 'zass-plugin');
$zass_message_sent = esc_html__('Thanks! Your message has been sent.', 'zass-plugin');

//user posted variables
$zass_subject = array_key_exists('zass_subject', $_POST) ? $_POST['zass_subject'] : '';
$zass_email = array_key_exists('zass_email', $_POST) ? $_POST['zass_email'] : '';
$zass_name = array_key_exists('zass_name', $_POST) ? $_POST['zass_name'] : '';
$zass_phone = array_key_exists('zass_phone', $_POST) ? $_POST['zass_phone'] : '';
$zass_address = array_key_exists('zass_address', $_POST) ? $_POST['zass_address'] : '';
$zass_message = array_key_exists('zass_enquiry', $_POST) ? $_POST['zass_enquiry'] : '';
$zass_captcha_rand = array_key_exists('zass_contact_submitted', $_POST) ? $_POST['zass_contact_submitted'] : '';
$zass_captcha_answer = array_key_exists('zass_captcha_answer', $_POST) ? $_POST['zass_captcha_answer'] : '';
// shortcode params
if (!isset($zass_shortcode_params_for_tpl)) {
	$zass_shortcode_params_for_tpl = array_key_exists('shortcode_params_for_tpl', $_POST) ? stripcslashes($_POST['shortcode_params_for_tpl']) : '';
}

if ($zass_shortcode_params_for_tpl) {
	$zass_shortcode_params_array = json_decode($zass_shortcode_params_for_tpl, true);
	if ($zass_shortcode_params_array) {
		extract($zass_shortcode_params_array);
	}
}

$zass_headers = '';
$zass_contactform_response = '';
$zass_rand_captcha = '';

$zass_contacts_fields = array();

/* if is from shortcode */
if (isset($zass_contact_form_fields)) {

	if(is_string($zass_contact_form_fields)) {
		$zass_contact_form_fields_arr = explode( ',', $zass_contact_form_fields );
	} elseif (is_array($zass_contact_form_fields)) {
		$zass_contact_form_fields_arr = $zass_contact_form_fields;
	} else {
		$zass_contact_form_fields_arr = array();
	}

    foreach($zass_contact_form_fields_arr as $zass_field)    {
        $zass_contacts_fields[$zass_field] = true;
    }
}

$zass_has_error = false;
$zass_name_error = $zass_email_error = $zass_phone_error = $zass_address_error = $zass_subject_error = $zass_message_error = $zass_captcha_error = false;

if (isset($_POST['zass_contact_submitted'])) {

	/* Validate Email address */
	if ($zass_email && $zass_contacts_fields['email'] && !filter_var($zass_email, FILTER_VALIDATE_EMAIL)) {
		$zass_has_error = true;
		$zass_email_error = zass_contact_form_generate_response("error", $zass_email_invalid);
	} else {
		$zass_headers = 'From: ' . sanitize_email($zass_email) . "\r\n" . 'Reply-To: ' . sanitize_email($zass_email) . "\r\n";
	}

	/* Check if all fields are filled */
	foreach ($zass_contacts_fields as $zass_fieldname => $zass_is_enabled) {
		if ($zass_is_enabled && !${'zass_' . $zass_fieldname}) {
			$zass_has_error = true;
			${'zass_' . $zass_fieldname . '_error'} = zass_contact_form_generate_response("error", sprintf($zass_missing_content, $zass_fields_strings[$zass_fieldname]));
		}
	}

	/* Check for a message */
	if (!trim($zass_message)) {
		$zass_has_error = true;
		$zass_message_error = zass_contact_form_generate_response("error", $zass_missing_message);
	}

	/* captcha validation */
	if ($zass_simple_captcha) {
		if ((int) $zass_captcha_rand + 1 !== (int) $zass_captcha_answer) {
			$zass_has_error = true;
			$zass_captcha_error = zass_contact_form_generate_response("error", $zass_captcha_message);
		}
	}

	if (!$zass_has_error) {
		$zass_sent = wp_mail(sanitize_email($zass_contact_mail_to), ($zass_subject ? sanitize_text_field($zass_subject) : sprintf(esc_html__('Someone sent a message from %s', 'zass-plugin'), sanitize_text_field(get_bloginfo('name')))), ($zass_name ? "Name: " . sanitize_text_field($zass_name) : "") . "\r\n" . ($zass_email ? "E-Mail Address: " . sanitize_text_field($zass_email) . "\r\n" : "") . ($zass_phone ? "Phone: " . sanitize_text_field($zass_phone) . "\r\n" : "") . ($zass_address ? "Street Address: " . sanitize_text_field($zass_address) . "\r\n" : "") . "\r\n" . wp_kses_post($zass_message), $zass_headers);
		if ($zass_sent) {
			$zass_contactform_response = zass_contact_form_generate_response("success", $zass_message_sent); //message sent!
			//clear values
			$zass_subject = $zass_email = $zass_name = $zass_phone = $zass_address = $zass_message = '';
		} else {
			$zass_contactform_response = zass_contact_form_generate_response("error", $zass_message_unsent); //message wasn't sent
		}
	}
}

$zass_contact_title = isset($zass_title) ? $zass_title : esc_html__('Send us a message', 'zass-plugin');
?>
<?php if ($zass_contact_title): ?>
	<h2 class="contact-form-title"><?php echo esc_html($zass_contact_title) ?></h2>
<?php endif; ?>
<form action="<?php echo esc_url(admin_url('admin-ajax.php')) ?>" method="post" class="contact-form">
	<?php if (isset($zass_contacts_fields['name'])): ?>
		<div class="content zass_name"> <span><?php esc_html_e('Your Name', 'zass-plugin'); ?>:</span>
			<input type="text" value="<?php echo esc_attr($zass_name); ?>" name="zass_name" />
			<?php if ($zass_name_error) echo wp_kses_post($zass_name_error); ?>
		</div>

	<?php endif; ?>
	<?php if (isset($zass_contacts_fields['email'])): ?>
		<div class="content zass_email"> <span><?php esc_html_e('E-Mail Address', 'zass-plugin'); ?>:</span>
			<input type="text" value="<?php echo esc_attr($zass_email); ?>" name="zass_email" />
			<?php if ($zass_email_error) echo wp_kses_post($zass_email_error); ?>
		</div>
	<?php endif; ?>
	<?php if (isset($zass_contacts_fields['phone'])): ?>
		<div class="content zass_phone"> <span><?php esc_html_e('Phone', 'zass-plugin'); ?>:</span>
			<input type="text" value="<?php echo esc_attr($zass_phone); ?>" name="zass_phone" />
			<?php if ($zass_phone_error) echo wp_kses_post($zass_phone_error); ?>
		</div>
	<?php endif; ?>
	<?php if (isset($zass_contacts_fields['address'])): ?>
		<div class="content zass_address"> <span><?php esc_html_e('Street Address', 'zass-plugin'); ?>:</span>
			<input type="text" value="<?php echo esc_attr($zass_address); ?>" name="zass_address" />
			<?php if ($zass_address_error) echo wp_kses_post($zass_address_error); ?>
		</div>
	<?php endif; ?>
	<?php if (isset($zass_contacts_fields['subject'])): ?>
		<div class="content zass_subject"> <span><?php esc_html_e('Subject', 'zass-plugin'); ?>:</span>
			<input type="text" value="<?php echo esc_attr($zass_subject); ?>" name="zass_subject" />
			<?php if ($zass_subject_error) echo wp_kses_post($zass_subject_error); ?>
		</div>
	<?php endif; ?>
	<div class="content zass_enquiry"> <span><?php esc_html_e('Message Text', 'zass-plugin'); ?>:</span>
		<textarea style="width: 99%;" rows="10" cols="40" name="zass_enquiry"><?php echo esc_textarea($zass_message); ?></textarea>
		<?php if ($zass_message_error) echo wp_kses_post($zass_message_error); ?>
	</div>
	<?php if ($zass_simple_captcha): ?>
		<?php $zass_rand_captcha = mt_rand(0, 8); ?>
		<div class="content zass_form_test">
			<?php echo esc_html__("Prove you're a human", 'zass-plugin') ?>: <span class=constant>1</span> + <span class=random><?php echo esc_html($zass_rand_captcha) ?></span> = ? <input type="text" value="" name="zass_captcha_answer" />
		</div>
		<?php if ($zass_captcha_error) echo wp_kses_post($zass_captcha_error); ?>
	<?php endif; ?>
	<?php echo wp_kses_post($zass_contactform_response); ?>
	<div class="buttons">
		<input type="hidden" name="zass_contact_submitted" value="<?php echo esc_attr($zass_rand_captcha) ?>">
		<input type="hidden" name="shortcode_params_for_tpl" value="<?php echo esc_attr($zass_shortcode_params_for_tpl) ?>">
		<div class="left"><input class="button button-orange" value="<?php esc_html_e('Send message', 'zass-plugin') ?>" type="submit"></div>
	</div>
</form>

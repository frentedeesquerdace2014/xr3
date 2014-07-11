<?php
// the shortcode
function vscf_shortcode($atts) {
	extract(shortcode_atts(array(
		"email_to" 			=> get_bloginfo('admin_email'),
		"label_name" 			=> __('Name', 'verysimple') ,
		"label_email" 			=> __('Email', 'verysimple') ,
		"label_subject" 		=> __('Subject', 'verysimple') ,
		"label_message" 		=> __('Message', 'verysimple') ,
		"label_submit" 			=> __('Submit', 'verysimple') ,
		"error_empty" 			=> __("Please fill in all the required fields", "verysimple"),
		"error_form_name" 		=> __('Please enter at least 3 characters', 'verysimple') ,
		"error_form_subject" 		=> __('Please enter at least 3 characters', 'verysimple') ,
		"error_form_message" 		=> __('Please enter at least 10 characters', 'verysimple') ,
		"error_email" 			=> __("Please enter a valid email", "verysimple"),
		"success" 				=> __("Thanks for your message! I will contact you as soon as I can.", "verysimple"),
	), $atts));

	if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['form_send']) ) {
	
	// get posted data and sanitize them
		$post_data = array(
			'form_name' 		=> vscf_clean_input (sanitize_text_field($_POST['form_name'])),
			'email' 			=> sanitize_email($_POST['email']),
			'form_subject' 		=> vscf_clean_input (sanitize_text_field($_POST['form_subject'])),
			'form_message' 		=> vscf_clean_input (sanitize_text_field($_POST['form_message']))
		);
			
		$error = false;
		$required_fields = array("form_name", "email", "form_subject", "form_message");
		
		foreach ($required_fields as $required_field) {
			$value = stripslashes(trim($post_data[$required_field]));
		
		// displaying error message if validation failed for each input field
			if(((($required_field == "form_name") || ($required_field == "form_subject")) && strlen($value)<3) || 
			 	(($required_field == "form_message") && strlen($value)<10) || empty($value)) {
				$error_class[$required_field] = "error";
				$error_msg[$required_field] = ${"error_".$required_field};
				$error = true;
				$result = $error_empty;
			}
			$form_data[$required_field] = $value;
		}
		

		// sending email to admin
		if ($error == false) {
			$email_subject = "[" . get_bloginfo('name') . "] " . $form_data['form_subject'];
			$email_message = $form_data['form_name'] . "\n\n" . $form_data['email'] . "\n\n" . $form_data['form_message'] . "\n\nIP: " . vscf_get_the_ip();
			$headers  = "From: ".$form_data['form_name']." <".$form_data['email'].">\n";
			$headers .= "Content-Type: text/plain; charset=UTF-8\n";
			$headers .= "Content-Transfer-Encoding: 8bit\n";
			wp_mail($email_to, $email_subject, $email_message, $headers);
			$result = $success;
			$sent = true;
		}
	}

	// message 
	if($result != "") {
		$info .= '<div class="info">'.$result.'</div>';
	}

	// the contact form with error messages
	$email_form = '<form class="vscf" id="vscf" method="post" action="">
		<div>
			<label for="vscf_name">'.$label_name.': <span class="error '.((isset($error_class['form_name']))?"":" hide").'" >'.$error_form_name.'</span></label>
			<input type="text" name="form_name" id="vscf_name" class="'.$error_class['form_name'].'" maxlength="50" value="'.$form_data['form_name'].'" />
		</div>
		<div>
			<label for="vscf_email">'.$label_email.': <span class="error '.((isset($error_class['email']))?"":" hide").'" >'.$error_email.'</span></label>
			<input type="text" name="email" id="vscf_email" class="'.$error_class['email'].'"  maxlength="50" value="'.$form_data['email'].'" />
		</div>
		<div>
			<label for="vscf_subject">'.$label_subject.': <span class="error '.((isset($error_class['form_subject']))?"":" hide").'" >'.$error_form_subject.'</span></label>
			<input type="text" name="form_subject" id="vscf_subject" maxlength="50"  class="'.$error_class['form_subject'].'"  value="'.$subject.$form_data['form_subject'].'" />
		</div>
		<div>
			<label for="vscf_message">'.$label_message.': <span class="error '.((isset($error_class['form_message']))?"":" hide").'" >'.$error_form_message.'</span></label>
			<textarea name="form_message" id="vscf_message" rows="10" class="'.$error_class['form_message'].'" >'.$form_data['form_message'].'</textarea>
			
		</div>
		<div>
			<input type="submit" value="'.$label_submit.'" name="form_send" id="vscf_send" />
		</div>
	</form>';
	
	if($sent == true) {
		return $info;
	} else {
		return $info.$email_form;
	}
} 
add_shortcode('contact', 'vscf_shortcode');
?>
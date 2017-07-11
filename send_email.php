<?php
// This function checks for email injection. Specifically, it checks for carriage returns - typically used by spammers to inject a CC list.
function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

// Load form field data into variables.
$email_address = $_REQUEST['Email'] ;
$comments = $_REQUEST['Message'] ;

// If the user tries to access this script directly, redirect them to feedback form,
if (!isset($_REQUEST['Email'])) {
header( "Location: index.html" );
}

// If the form fields are empty, redirect to the error page.
elseif (empty($Email) || empty($Message)) {
header( "Location: error_message.html" );
}

// If email injection is detected, redirect to the error page.
elseif ( isInjected($Email) ) {
header( "Location: error_message.html" );
}

// If we passed all previous tests, send the email!
else {
mail( "songcaron@yahoo.com", "Ursa's Feedback",
  $Message, "From: $Email" );
header( "Location: thank_you.html" );
}
?>

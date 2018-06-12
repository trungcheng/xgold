<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
$config['protocol'] = 'smtp';               			// mail, sendmail, or smtp	The mail sending protocol.
// $config['mailpath'] = '/usr/sbin/sendmail'; 			// The server path to Sendmail.
$config['charset'] = 'utf-8';               			// Character set (utf-8, iso-8859-1, etc.).
// $config['useragent'] = 'CodeIgniter';    			// The "user agent".
$config['smtp_host'] = 'ssl://smtp.googlemail.com';     // SMTP Server Address.
$config['smtp_user'] = 'trungs1bmt@gmail.com'; 			// SMTP Username.
$config['smtp_pass'] = 'hajimemashitee1234';          	// SMTP Password.
$config['smtp_port'] = '465';               			// SMTP Port.
$config['mailtype'] = 'html';               			// text or html	Type of mail. If you send HTML email you must
// $config['smtp_crypto'] = 'tls';             			// Encryption
// $config['smtp_timeout'] = 5;             			// SMTP Timeout (in seconds).
// $config['wordwrap'] = TRUE;                 			// TRUE or FALSE (boolean)	Enable word-wrap.
// $config['wrapchars'] = 76;               			// Character count to wrap at.
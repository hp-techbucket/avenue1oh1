<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

		$config['useragent'] = 'CodeIgniter';
		$config['protocol'] = 'smtp';
		//$config['mailpath'] = '/usr/sbin/sendmail';
		$config['smtp_host'] = 'mail.global-sub.com';
		$config['smtp_user'] = 'services@global-sub.com';
		$config['smtp_pass'] = 'Liverpool2k';
		$config['smtp_port'] = 465; 
		$config['smtp_timeout'] = 5;
		$config['wordwrap'] = TRUE;
		$config['wrapchars'] = 76;
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['validate'] = FALSE;
		$config['priority'] = 3;
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";


/* End of file email.php */
/* Location: ./system/application/config/email.php */
<?php

	namespace Game\Model;
	
	use Zend\Mail\Transport\Smtp as SmtpTransport;
	use Zend\Mail\Transport\SmtpOptions;

	class Mail {
	
		private $transport;
	
		function __construct() {
		
			$this->transport = new SmtpTransport();
			$options   = new SmtpOptions(array(
				'host' => 'smtp.uibk.ac.at',
				'name' => 'smtp.uibk.ac.at',
				'connection_class'  => 'login',
				'connection_config' => array(
					'port' => 587,
					'ssl' => 'tls',
					'username' => '',	//username einfuegen
					'password' => '',	//passwort einfuegen
				),
			));
			
			$this->transport->setOptions($options);
			
		}
		
		public function sendMail($message) {
			$this->transport->send($message);
		}	
	
	}
	
?>
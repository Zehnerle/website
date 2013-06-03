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
				'port' => 587,				
				/*'connection_class'  => 'login',
				'connection_config' => array(
                'username' => '',
                'password' => '',
				'ssl'      => 'tls',
				),*/
			));
			
			$this->transport->setOptions($options);
			
		}
		
		public function sendMail($message) {
			$this->transport->send($message);
		}	
	
	}
	
?>
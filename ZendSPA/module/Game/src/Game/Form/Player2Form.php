<?php

	namespace Game\Form;

	use Zend\Form\Form;
	use Game\Model\GameLogic;

	class Player2Form extends Form {
	
		public function __construct($name = null) {
		
			parent::__construct('game');	
			
			$choices = new GameLogic();
			$choiceEnum = $choices->getEnum();
			
			$this->setAttribute('method', 'post');
			$this->setAttribute('onsubmit' , 'return submitCheck()');
			
			$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
			));	

			$this->add(array(
				'name' => 'hash',
				'type' => 'Hidden',
			));			
			
			$this->add(array(
				'name' => 'mail2',
				'type' => 'Text',
				'options' => array(
					'label' => 'Mail: ',
				),
			));
			
			$this->add(array(
				'name' => 'choice2',
				'type' => 'Text',
			));
			
			$this->add(array(
				'name' => 'msg2',
				'type' => 'TextArea',
				'options' => array(
					'label' => 'Message for Player1: ',
				),
				'attributes' => array(
					'class' => 'msg',
					'rows' => '4',
				),
			));			
			
			$this->add(array(
				'name' => 'mailcheckbox',
				'type' => 'Checkbox',
				'options' => array(
					'label' => 'Send result also to Player 1 by mail?',					
					'use_hidden_element' => false,
				),	
				'attributes' => array(
					'class' => 'inline',
				),				
			));
			
			$this->add(array(
				'name' => 'submit',
				'type' => 'Submit',
				'attributes' => array(
					'value' => 'Play game',
					'id' => 'submitbutton',
				),
			));
		}
	}

?>

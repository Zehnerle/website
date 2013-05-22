<?php

	namespace Game\Form;

	use Zend\Form\Form;
	use Game\Model\GameLogic;
	use Zend\Form\Element;

	class GameForm extends Form {
	
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
				'name' => 'player1',
				'type' => 'Text',
				'options' => array(
					'label' => 'Player1 Name: ',
				),
			));	
			
			$this->add(array(
				'name' => 'mail1',
				'type' => 'Text',
				'options' => array(
					'label' => 'Player1 Mail: ',
				),
			));
			
			$this->add(array(
				'name' => 'player2',
				'type' => 'Text',
				'options' => array(
					'label' => 'Player2 Name: ',
				),
			));
			
			$this->add(array(
				'name' => 'mail2',
				'type' => 'Text',
				'options' => array(
					'label' => 'Player2 Mail: ',
				),
			));
			
			$this->add(array(
				'name' => 'choice1',
				'type' => 'Text',
			));
			
			$this->add(array(
				'name' => 'mailcheckbox',
				'type' => 'Checkbox',
				'options' => array(
					'label' => 'Notify Player 2 by mail?',				
					'use_hidden_element' => true,
					'checked_value' => 'mail',
					'unchecked_value' => 'nomail',
				),
				'attributes' => array(
					'class' => 'inline',
				),				
			));
			
			
			$this->add(array(
				'name' => 'submit',
				'type' => 'Submit',
				'attributes' => array(
					'value' => 'New Game',
					'id' => 'submitbutton',
				),
			));
		}
	}

?>

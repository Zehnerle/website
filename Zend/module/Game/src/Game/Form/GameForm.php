<?php

	namespace Game\Form;

	use Zend\Form\Form;
	use Game\Model\GameLogic;

	class GameForm extends Form {
	
		public function __construct($name = null) {
		
			parent::__construct('game');	
			
			$choices = new GameLogic();
			$choiceEnum = $choices->getEnum();
			
			$this->setAttribute('method', 'post');

			$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
			));
			
			$this->setLabel('Player Info:');
			
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
				'type' => 'Radio',
				'options' => array(
					'label' => 'Your choice:',
					'value_options' => array(
						'1' => $choiceEnum[0],
						'2' => $choiceEnum[1],
						'3' => $choiceEnum[2],
						'4' => $choiceEnum[3],
						'5' => $choiceEnum[4],
					),
				),
				'attributes' => array(
					'value' => '0'
				)
			));
			
			$this->add(array(
				'name' => 'mailcheckbox',
				'type' => 'Checkbox',
				'options' => array(
					'label' => 'Notify Player 2 by mail (only Uni Innsbruck mail addresses allowed)?',				
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
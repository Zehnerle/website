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
			$this->setAttribute('New Game' , 'return submitCheck()');

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
				'name' => 'scissors',
				'type' => 'Image',
				'attributes' => array(
					'class'  => 'scissors',
					'type'  => 'Image',
					'src'   => 'http://localhost/Zend/public/img/game/Scissors.png',
					'height'=> '200',
					'width' => '200',
					'border'=> '10',
					'alt'   => 'Scissors',
				),
				'options' => array(
					'value_options' => array(
						'1' => $choiceEnum[0],
					),
				),
			));
			
			$this->add(array(
				'name' => 'spock',
				'type' => 'Image',
				'attributes' => array(
					'class'  => 'spock',
					'type'  => 'image',
					'src'   => 'http://localhost/Zend/public/img/game/Spock.png',
					'height'=> '200',
					'width' => '200',
					'border'=> '10',
					'alt'   => 'Spock',
				),
				'options' => array(
					'value_options' => array(
						'2' => $choiceEnum[1],
					),
				),
			));
			
			$this->add(array(
				'name' => 'paper',
				'type' => 'Image',
				'attributes' => array(
					'class'  => 'paper',
					'type'  => 'image',
					'src'   => 'http://localhost/Zend/public/img/game/Paper.png',
					'height'=> '200',
					'width' => '200',
					'border'=> '10',
					'alt'   => 'Paper',
				),
				'options' => array(
					'value_options' => array(
						'3' => $choiceEnum[2],
					),
				),
			));
			
			$this->add(array(
				'name' => 'lizard',
				'type' => 'Image',
				'attributes' => array(
					'class'  => 'lizard',
					'type'  => 'image',
					'src'   => 'http://localhost/Zend/public/img/game/Lizard.png',
					'height'=> '200',
					'width' => '200',
					'border'=> '10',
					'alt'   => 'Lizard',
				),
				'options' => array(
					'value_options' => array(
						'4' => $choiceEnum[3],
					),
				),
			));
			
			$this->add(array(
				'name' => 'rock',
				'type' => 'Image',
				'attributes' => array(
					'class'  => 'rock',
					'type'  => 'image',
					'src'   => 'http://localhost/Zend/public/img/game/Rock.png',
					'height'=> '200',
					'width' => '200',
					'border'=> '10',
					'alt'   => 'Rock',
				),
				'options' => array(
					'value_options' => array(
						'5' => $choiceEnum[4],
					),
				),
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

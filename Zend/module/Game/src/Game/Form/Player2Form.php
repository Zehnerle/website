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
			
			$this->add(array(
				'name' => 'id',
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
					'value' => '1'
				)
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
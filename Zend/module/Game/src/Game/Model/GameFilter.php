<?php

	namespace Game\Model;
	
	use Zend\InputFilter\Factory as InputFactory;
	use Zend\InputFilter\InputFilter;
	use Zend\InputFilter\InputFilterAwareInterface;
	use Zend\InputFilter\InputFilterInterface;

	class GameFilter implements InputFilterAwareInterface {	
		
		protected $inputFilter; 		
		
		public function setInputFilter(InputFilterInterface $inputFilter) {
			throw new \Exception("Not used");
		}		
		
		public function getInputFilter() {
		
			if(!$this->inputFilter) {
			
				$inputFilter = new InputFilter();
				$factory     = new InputFactory();

				$inputFilter->add($factory->createInput(array(
					'name'     => 'id',
					'required' => true,
					'filters'  => array(
						array('name' => 'Int'),
					),
				)));

				$inputFilter->add($factory->createInput(array(
					'name'     => 'player1',
					'required' => true,
					'filters'  => array(
						array('name' => 'StripTags'),
						array('name' => 'StringTrim'),
					),
					'validators' => array(
						array(
							'name'    => 'StringLength',
							'options' => array(
								'encoding' => 'UTF-8',
								'min'      => 1,
								'max'      => 50,
							),
						),
					),
				)));
				
				$inputFilter->add($factory->createInput(array(
					'name'     => 'mail1',
					'required' => true,
					'filters'  => array(
						array('name' => 'StripTags'),
						array('name' => 'StringTrim'),
					),
					'validators' => array(
						array(
							'name'    => 'StringLength',
							'options' => array(
								'encoding' => 'UTF-8',
								'min'      => 1,
								'max'      => 100,
							),
						),
					),
				)));
				
				$inputFilter->add($factory->createInput(array(
					'name'     => 'player2',
					'required' => true,
					'filters'  => array(
						array('name' => 'StripTags'),
						array('name' => 'StringTrim'),
					),
					'validators' => array(
						array(
							'name'    => 'StringLength',
							'options' => array(
								'encoding' => 'UTF-8',
								'min'      => 1,
								'max'      => 50,
							),
						),
					),
				)));
						
				
				$inputFilter->add($factory->createInput(array(
					'name'     => 'mail2',
					'required' => true,
					'filters'  => array(
						array('name' => 'StripTags'),
						array('name' => 'StringTrim'),
					),
					'validators' => array(
						array(
							'name'    => 'StringLength',
							'options' => array(
								'encoding' => 'UTF-8',
								'min'      => 1,
								'max'      => 100,
							),
						),
					),
				)));
				
				$inputFilter->add($factory->createInput(array(
					'name'     => 'choice1',
					'required' => true,
				)));
				
				$inputFilter->add($factory->createInput(array(
					'name'     => 'mailcheckbox',
				)));

				$this->inputFilter = $inputFilter;
			}

			return $this->inputFilter;
		}
		
	}

?>
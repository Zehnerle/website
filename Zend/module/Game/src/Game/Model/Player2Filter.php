<?php

	namespace Game\Model;
	
	use Zend\InputFilter\Factory as InputFactory;
	use Zend\InputFilter\InputFilter;
	use Zend\InputFilter\InputFilterAwareInterface;
	use Zend\InputFilter\InputFilterInterface;

	class Player2Filter implements InputFilterAwareInterface {	
		
		protected $inputFilter; 		
		
		public function setInputFilter(InputFilterInterface $inputFilter) {
			throw new \Exception("Not used");
		}	
		
		public function getInputFilter() {
		
			if (!$this->inputFilter) {
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
					'name'     => 'choice2',
					'required' => true,
				)));

				$this->inputFilter = $inputFilter;
			}

			return $this->inputFilter;
		}		
		
	}

?>
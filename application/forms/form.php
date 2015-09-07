<?php
class Application_Form_Form extends Zend_Form 
{
	public function init()
    {
		$this->setMethod('post');
		$this->addElement('text','department',array(
			'label'  => 'Department:',
            'required'   => true,
            'filters'    => array('StringTrim'),
			'validators' => array('Alpha'),
			'class'	 =>'department',
		));
		
		$this->addElement('textarea','deliverable',array(
			'label'  => 'Key Deliverables:',
            'required'   => true,
            'filters'    => array('StringTrim'),
			'validators' => array('Alpha'),
			'class'	 =>'deliverable',
		));
		$this->addElement('text','achievement_level',array(
			'label'  => 'Achievement level(%):',
            'required'   => true,
            'filters'    => array('StringTrim'),
			'validators' => array('Digits'),
			'class'	 =>'achievement_level',
		));
		$this->addElement('text','self_socre',array(
			'label'  => 'Self Score(1 to 10):',
            'required'   => true,
            'filters'    => array('StringTrim'),
			'validators' => array('Digits'),
			'class'	 =>'self_socre',
		));
		
		$this->addElement('textarea','Improvement',array(
			'label'  => 'Qualitative Improvements:',
            'required'   => true,
            'filters'    => array('StringTrim'),
			'validators' => array('Alpha'),
			'class'	 =>'Improvement',
		));
		$this->addElement('textarea','self_development',array(
			'label'  => 'Qualitative Improvements:',
            'required'   => true,
            'filters'    => array('StringTrim'),
			'validators' => array('Alpha'),
			'class'	 =>'self_development',
		));
		$this->addElement('submit','save', array(
            'ignore'   => true,
            'label'    => 'Save',
			'class'  => 'save',	
			));
		
		
		
		
	}
}
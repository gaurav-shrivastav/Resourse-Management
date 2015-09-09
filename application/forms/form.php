<?php
class Application_Form_Form extends Zend_Form 
{
	public function init()
    {
		$this->setMethod('post');
		//$this->setDefaultDisplayGroupClass('form');
		$this->addElement('text','department',array(
			'label'  => 'Department:',
            'required'   => true,
            'filters'    => array('StringTrim'),
			'validators' => array('Alpha'),
			'class'	 => array('form-control','span4'),
			'placeholder' => 'Department',
			
		));
		
		
		/*$this->addElement('textarea','deliverable',array(
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
		));*/
		
		$this->addElement('textarea','Improvement',array(
			'label'  => 'Qualitative Improvements:',
            'required'   => true,
            'filters'    => array('StringTrim'),
			'validators' => array('Alpha'),
			'class'	 =>'form-control',
		));
		$this->addElement('textarea','self_development',array(
			'label'  => 'Self Development:',
            'required'   => true,
            'filters'    => array('StringTrim'),
			'validators' => array('Alpha'),
			'class'	 => array('form-control','center-block'),
		));
		$this->addElement('submit','save', array(
            'ignore'   => true,
            'label'    => 'Save',
			'class'  => 'btn btn-warning',	
			));
		
		
		
		
	}
}
<?php
class Application_Form_Login extends Zend_Form 
{
	public function init()
    {
		$this->setMethod('post');
		$this->setAttrib('class','loginForm');
		$this->addElement('text','username',array(
			'label'  => 'Username:',
            'required'   => true,
            'filters'    => array('StringTrim'),
			'validators' => array('Alpha'),
			'class'	 =>'form-control',
			'placeholder' => 'Username',

		));
		$this->addElement('password','password',array(
			'label'  => 'Password:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array('NotEmpty'),
			'class'	 =>'form-control',
			'placeholder' => 'Password',	
		));	
		    $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Login',
			'class'  => array('btn btn-success','pull-right') 
        ));
	}
}
?>
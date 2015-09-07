<?php
class Application_Form_Login extends Zend_Form 
{
	public function init()
    {
		$this->setMethod('post');
		$this->addElement('text','username',array(
			'label'  => 'username:',
            'required'   => true,
            'filters'    => array('StringTrim'),
			'validators' => array('Alpha'),
			'class'	 =>'user',
			'placeholder' => 'Username',

		));
		$this->addElement('password','password',array(
			'label'  => 'password:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array('NotEmpty'),
			'class'	 =>'pass',
			'placeholder' => 'Password',	
		));	
		    $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Login',
			'class'  => 'button' 
        ));
	}
}
?>
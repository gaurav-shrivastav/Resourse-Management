<?php
class Application_Form_Comment extends Zend_Form
{
	public function init() 
	{

		/*$this->addElement('hidden', 'id', array(
		'value' => 1
		));*/

		$this->addElement('text', 'name', array(
		'required' => true,
		'label'    => 'Name',
		'order'    => 2,
		));

	/*	$this->addElement('button', 'addElement', array(
		'label' => 'Add',
		'order' => 91
		));

		$this->addElement('button', 'removeElement', array(
		'label' => 'Remove',
		'order' => 92
		));

		// Submit
		$this->addElement('submit', 'submit', array(
		'label' => 'Submit',
		'order' => 93
		));*/
	}
}

?>
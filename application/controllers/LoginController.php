<?php
class LoginController extends Zend_Controller_Action
{
	public function init() 
	{
		$session = new Zend_Session_Namespace();
	}
	public function loginAction()
	{	
		$this->view->headTitle()->prepend('Login');
		$usertype="";
		$request = $this->getRequest();
		$form = new Application_Form_Login();
		try {
		    if($request->isPost()) {
		        if($form->isValid($request->getPost())) {
				    $user = new Service_Login();
				    $usertype = $user->getloginData($request->getPost('username'), $request->getPost('password'));
				    $session = new Zend_Session_Namespace();
				    $session->username = $request->getPost('username');
				    $session->password = $request->getPost('password');
				    $session->empname = $usertype->getEmpName();
				    $session->empcode = $usertype->getEmployeeCode();
				    $session->empid = $usertype->getEmpId();
				    $session->email = $usertype->getEmail();
					if($usertype->getuserType()=="employee") {
						$this->_helper->redirector('employee','User',null,array('emp_id' =>$usertype->getEmpId(),'emp_code' =>$usertype->getEmployeeCode()));
					}
					if($usertype->getuserType()=="teamleader") {
						$this->_helper->redirector('teamleader','User',null,array('emp_id' =>$usertype->getEmpId(),'emp_code' =>$usertype->getEmployeeCode()));	
					}	
				}	
			}
		} catch(Exception $e) {
			echo "invalid login";
			//$this->_helper->redirector('login','User');
		}
		$this->view->form = $form;
	}
	public function logoutAction() 
	{
		$session = new Zend_Session_Namespace();
		unset($session->username);
		$this->_helper->redirector('login','login');
	}
}

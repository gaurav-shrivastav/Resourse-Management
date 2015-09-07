<?php
class UserController extends Zend_Controller_Action
{
	public function loginAction()
	{	
	/*$mail = new Zend_Mail();
	$mail->setBodyText('This is the text of the mail.');
			$mail->setFrom('namrata.patel@sts.in');
			$mail->addTo('sanket.goyal@sts.in', 'Some Recipient');
			$mail->setSubject('Appraisal Form')
			  ->send();exit(); */
		$usertype="";
		$request = $this->getRequest();
		$form = new Application_Form_Login();
		try {
		if($request->isPost()){
			if($form->isValid($request->getPost())){
			
				$user = new Service_Login();
				$usertype = $user->getloginData($request->getPost('username'),$request->getPost('password'));
				$session = new Zend_Session_Namespace();
				$session->empname = $usertype->getEmpName();
				$session->empcode = $usertype->getEmployeeCode();
				$session->empid = $usertype->getEmpId();
				$session->email = $usertype->getEmail();
				if($usertype->getuserType()=="employee"){
				$this->_helper->redirector('employee','User',null,array('emp_id' =>$usertype->getEmpId(),'emp_code' =>$usertype->getEmployeeCode()));
				}
				if($usertype->getuserType()=="teamleader") {
				$this->_helper->redirector('teamleader','User',null,array('emp_id' =>$usertype->getEmpId(),'emp_code' =>$usertype->getEmployeeCode()));	
				}	
			}	
		}
		}
		catch(Exception $e)
		{
			echo "invalid login";
			//$this->_helper->redirector('login','User');
		}
		$this->view->form = $form;
	}
	public function employeeAction()
	{
		$request = $this->getRequest();
		$session = new Zend_Session_Namespace();
 		$emp_id = $this->_getParam("emp_id");
		$emp_code = $this->_getParam("emp_code");
		$employee =  new Service_Form();
		$form = new	Application_Form_Form();
		$flag =false;
		$res= $employee->checkStatus($emp_id);
		if($res['formStatus']=="saved" || $res['formStatus']==NULL)
			{
				$flag = true;
			}
		if(($form_id = $employee->checkAvailablity($emp_id))&&($flag)) {
			$ids = $this->setPrefilledData($session->empname,$emp_id,$emp_code,$form);
			$this->view->ids = $ids;
			$head= $employee->getReportHead($emp_id);
			$this->view->reportHead = $head['empName'];
			$this->view->form = $form;
			$this->sendData($request,$emp_id,$form_id,$ids);
			
			//echo "<pre>";
		//	print_r($ids);die;
		}	
		else
			{
				echo "Form is either submitted or not available";
			}			
		}
	public function teamleaderAction()
		{
			$valid = array();
			$session = new Zend_Session_Namespace();
			$service =  new Service_Form();
			$result = $service->getEmpIDs($session->empid); 
			foreach($result as $r) {
				$status = $service->checkStatus($r['empId']);
				if($status['formStatus']=="waiting_for_review") {
					$valid[] = $r;
				}
			}
			$this->view->valid = $valid;
		}
	 public function commentAction()
		{
			$session = new Zend_Session_Namespace();
			$emp_id = $this->_getParam("empid");
			$employee =  new Service_Form();
			$result = $employee->getFormData($emp_id);
			foreach ($result as $k=>$i)
			{
				if(!strcmp($k,'deliver')){				
					$dev[$k] = $i; 
				}
				else{				
					foreach($i as $key=>$val)
					{					
						$dev[$key] = $val; 
					}
				}
			}
			//echo "<pre>";
			//print_r($dev);die;
			$head = $employee->getReportHead($emp_id);
			$this->view->empnane = $session->empname;
			$this->view->empcode = $session->empcode;
			$this->view->head = $head['empName'];
			$this->view->department=$dev['deptName'];
			$this->view->deliver=$dev['deliver'];
			$this->view->Improvement=$dev['improvementDetail'];
			$this->view->id_imp=$dev['id_imp'];
			$this->view->self_development=$dev['requirementDetail'];
			$this->view->id_dep=$dev['id_dep'];
			
			//$form->Improvement->setValue($dev['requirementDetail']);
			//$form->self_development->setValue($dev['requirementDetail']);
			//echo "<pre>";
			//print_r($dev);die;
		}
	public function addcommentAction()
		{
			echo "commeny";
			$request = $this->getRequest();
			$service = new Service_Login();
			echo "<pre>";
			print_r($request->getPost());die;
			
			if($request->isPost()){
				if($form->isValid($request->getPost())) { 
					$service->addComment($request->getPost('a_comment'),$request->getPost('ac_id'),$request->getPost('b_comment'),$request->getPost('bc_id'),$request->getPost('c_comment'),$request->getPost('cc_id'));
				
				}
			}		
		}
	
	 public function statusAction()
		{	
			//$empid = $this->_getParam("empid");
			$session = new Zend_Session_Namespace();
			$service = new Service_Form();
			 $head = $service->getReportHead($session->empid);
			 //echo "<pre>";
			 //print_r($head);die;
			$service->setStatus($session->empid,$session->email,$head['email']);
			$this->_helper->redirector('employee','User');
		}		
	public function sendData($request,$emp_id,$form_id,$ids)
	{
		$FormService = new Service_Form();
		if($request->isPost()){	
			$btn ="";
			if(($request->getPost('save'))){
				$btn ="saved";
			}
			if(($request->getPost('submit'))){
				$btn = "waiting_for_review";
			}
			//print_r($request->getPost());
			//print_r($request->getPost('save'));
			$FormService->setFormData($request->getPost('department'),$request->getPost('deliverables'),$request->getPost('achievement'),$request->getPost('selfscore'),$request->getPost('Improvement'),$request->getPost('self_development'),$emp_id,$form_id,$ids,$btn);
			}
		
	}
	public function setPrefilledData($empname,$emp_id,$emp_code,$form)
	{
		$this->view->emp_name= $empname;	
		$this->view->emp_code = $emp_code;
		try{
		$dev = array();
			$employee =  new Service_Form();
			$result = $employee->getFormData($emp_id);
				
			//var_dump(0=='deliver');
			foreach ($result as $k=>$i)
			{
				if(!strcmp($k,'deliver')){				
					$dev[$k] = $i; 
				}
				else{				
					foreach($i as $key=>$val)
					{					
						$dev[$key] = $val; 
					}
				}
			}
			/**echo "here";
			echo "<pre>";
			print_r($dev['deliver']);die*/
			
			$form->department->setValue($dev['deptName']);
			$form->Improvement->setValue($dev['improvementDetail']);
			$form->self_development->setValue($dev['requirementDetail']);
			//print_r($dev['deliver']);die;
			return $dev['deliver'];
		}
		catch(Exception $e)
		{		
			echo "Catch it";
		}		
	}

		/*$request = $this->getRequest();
		if($request->isPost()){
				if($form->isValid($request->getPost())){
				
			}
		}*/
		
		//$employee =  new Service_Form();
		//$employee->getReportHead($emp_id);
		
	
}
?>
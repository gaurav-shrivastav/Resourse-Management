<?php
class UserController extends Zend_Controller_Action
{
	public function init() 
	{
		$session = new Zend_Session_Namespace();
		if(!$session->username) {
			$this->_helper->redirector('login','login');	
		}
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
		if($res['formStatus']=="saved" || $res['formStatus']==null) {
			$flag = true;
		}
		if(($form_id = $employee->checkAvailablity($emp_id))&&($flag)) {
			$ids = $this->setPrefilledData($session->empname, $emp_id,$emp_code, $form);
			$this->view->ids = $ids;
			$head= $employee->getReportHead($emp_id);
			$this->view->reportHead = $head['empName'];
			$this->view->form = $form;
			$this->sendData($request, $emp_id, $form_id, $ids);
		} else {
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
		$emp_id = array();
		$session = new Zend_Session_Namespace();
		$emp_id= $this->_getParam("empid");
		$employee =  new Service_Form();
		$result = $employee->getFormData($emp_id);
		foreach ($result as $k=>$i) {
			if(!strcmp($k,'deliver')) {				
				$dev[$k] = $i; 
			} else {				
				foreach($i as $key=>$val) {					
					$dev[$key] = $val; 
				}
			}
		}
		$result = $employee->formData($emp_id);
		$head = $employee->getReportHead($emp_id);
		$this->view->empnane = $result['empName'];
		$this->view->empcode = $result['employeeCode'];
		$this->view->head = $head['empName'];
		$this->view->department=$dev['deptName'];
		$this->view->deliver=$dev['deliver'];
		$this->view->Improvement=$dev['improvementDetail'];
		$this->view->id_imp=$dev['id_imp'];
		$this->view->self_development=$dev['requirementDetail'];
		$this->view->id_dep=$dev['id_dep'];
	}
	public function addcommentAction()
	{
		$request = $this->getRequest();
		$service = new Service_Form();
		if($request->isPost()) {
			$service->addComment(
					$request->getPost('a_comment'),
					$request->getPost('ac_id'),
					$request->getPost('b_comment'),
					$request->getPost('bc_id'),
					$request->getPost('c_comment'),
					$request->getPost('cc_id')
			);
		}	
		$this->_helper->redirector('teamleader','User');	
	}
	public function statusAction()
	{	
		$session = new Zend_Session_Namespace();
		$service = new Service_Form();
		$head = $service->getReportHead($session->empid);
		$service->setStatus($session->empid, $session->email,$head['email']);
		$this->_helper->redirector('employee','User');
	}		
	public function sendData($request, $emp_id, $form_id, $ids)
	{
		$FormService = new Service_Form();
		if($request->isPost()) {	
			$btn ="";
			if(($request->getPost('save'))) {
				$btn ="saved";
			}
			if(($request->getPost('submit'))){
				$btn = "waiting_for_review";
			}
			$FormService->setFormData(
						$request->getPost('department'),
						$request->getPost('formid'),
						$request->getPost('id_imp'),
						$request->getPost('id_dep'),
						$request->getPost('deliverables'),
						$request->getPost('achievement'),
						$request->getPost('selfscore'),
						$request->getPost('ids'),
						$request->getPost('Improvement'),
						$request->getPost('self_development'),
						$emp_id,
						$form_id,
						$ids
			);
		}
	}
	public function setPrefilledData($empname, $emp_id, $emp_code, $form)
	{
		$this->view->emp_name= $empname;	
		$this->view->emp_code = $emp_code;
		try {
			$dev = array();
			$employee =  new Service_Form();
			$result = $employee->getFormData($emp_id);
			foreach ($result as $k=>$i) {
				if(!strcmp($k,'deliver')){				
					$dev[$k] = $i; 
				} else {				
					foreach($i as $key=>$val) {					
						$dev[$key] = $val; 
					}
				}
			}
			$form->addElement('hidden','formid');
			$form->formid->setValue($dev['id']);
			$form->department->setValue($dev['deptName']);
			$form->Improvement->setValue($dev['improvementDetail']);
			$form->addElement('hidden','id_imp');
			$form->id_imp->setValue($dev['id_imp']);
			$form->self_development->setValue($dev['requirementDetail']);
			$form->addElement('hidden','id_dep');
			$form->id_dep->setValue($dev['id_dep']);
			return $dev['deliver'];
		} catch(Exception $e) {		
			echo "Catch it";
		}		
	}
}
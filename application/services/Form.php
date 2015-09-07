<?php

class Service_Form 
{
	public function getReportHead($emp_id)
	{
		/*
		$qb->select('l.empName')
		   ->from('Entities\\Login','l')
		   ->where('l.empId')	*/
		$em = Zend_Registry::get("em"); 
		$qb = $em->createQueryBuilder();
		$qb->select('emp.empName,emp.email')
		   ->from('Entities\\EmpTeamlead','etl')
		   ->innerJoin('etl.head', 'emp')
		   ->where('etl.emp =:id')
		   ->setParameter('id', $emp_id);
		$query = $qb->getQuery();
		try{		
			$result = $query->getSingleResult();
			//print_r($result);die;
			return $result;
		}
		catch(\Exception $e)
		{
		//throw new \Exception($e->getMessage());die;
			echo "no head";
		}
	}
	public function getEmpIDs($headid)
	{
		$em = Zend_Registry::get("em"); 
		$qb = $em->createQueryBuilder();
		$qb->select('ep.empId,ep.empName,ep.email,ep.designation,ep.dateOfJoin,ep.employeeCode')
		   ->from('Entities\\EmpTeamlead','etl')
		   ->innerJoin('etl.emp', 'ep')
		   ->where('etl.head =:id')
		   ->setParameter('id', $headid);
		$query = $qb->getQuery();
		try{		
			$result = $query->getResult();
			return $result;
		}
		catch(\Exception $e)
		{
		//throw new \Exception($e->getMessage());die;
			echo "no head";
		}
	}
	public function checkAvailablity($empid)
	{
		$em = Zend_Registry::get("em"); 
		$qb = $em->createQueryBuilder();	
		$qb->select('f.id,f.empId')
		   ->from('Entities\FormPeriod','f')
		   ->where('f.empId = :empid')
		   ->setParameter('empid',$empid);
		$query = $qb->getQuery();
			//$result = $query->getSingleResult();
		try
		{
			$result = $query->getSingleResult();
		} 
		catch(Exception $e)
		{
			return false;
		}
		if($empid==$result['empId']) {
			return $result['id'];
		}
	}
	public function checkStatus($empid)
	{
		$em = Zend_Registry::get("em"); 
		$qb = $em->createQueryBuilder();	
		$qb->select('f.formStatus')
		   ->from('Entities\FormDetails','f')
		   ->where('f.empId = :empid')
		   ->setParameter('empid',$empid);
		$query = $qb->getQuery();
		$result = $query->getResult();
		
		try {
			$result = $query->getSingleResult();
			return $result;
		}
		catch(Exception $e){
			
			return true;
		}
	}
	public function setStatus($empid,$empEmailId,$headEmailId) 
	{
		echo "<pre>";
		print_r($empid.$empEmailId.$headEmailId);
		/*$sts = "waiting_for_review";
		$em = Zend_Registry::get("em");
		$qb = $em->createQueryBuilder();	
		$q = $qb->update('Entities\\FormDetails', 'f')
			->set('f.formStatus','?1')
			->where('f.empId = :empid')
			->setParameter(1, $sts)
			->setParameter('empid',$empid)
			->getQuery();
		$query = $q->execute();
		$mail = new Zend_Mail('utf-8');
		$mail->setBodyText($msg);
		$mail->setBodyHtml($msg);
		$mail->setFrom('shrivastav.47@gmail.com', 'gaurav');
		$mail->addTo('gaurav.shrivastav@sts.in', 'gaurav');
		$mail->setSubject('Leave Application');
		$mail->send(); */
	}
	public function setFormData($dept_name,$deliverable,$achievement,$self_score,$improvement,$development ,$emp_id,$form_id,$ids = null,$btn)
	{
		$em = Zend_Registry::get("em");
		$qb = $em->createQueryBuilder();	
			$qb->select('f.empId,f.id')
			   ->from('Entities\\FormDetails','f')
			   ->where('f.empId =:empid')
			   ->setParameter('empid',$emp_id);
			$query = $qb->getQuery();	
			$service = new Service_Form();
			//echo "<pre>";
			//print_r($self_score);die;
			try {
				$result = $query->getSingleResult();
				//$service->setUpdateData($dept_name,$deliverable,$updateIds,$achievement,$self_score,$improvement,$development,$ids);		
			}
			catch(Exception $e)
			{
					echo "not found";
					$service = new Service_Form();
					$service->setNewData($dept_name,$deliverable,$achievement,$self_score,$improvement,$development,$emp_id,$form_id,$btn);
			}
	}
	public function setNewData($dept_name,$deliverable,$achievement,$self_score,$improvement,$development,$emp_id,$form_id,$btn)	
		{
			$em = Zend_Registry::get("em"); 
			$user = new \Entities\FormDetails;
			$user->setEmpId($emp_id);
			$d = $em->find('Entities\FormPeriod',$form_id);
			$user->setForm($d);
			$user->setDeptName($dept_name);
			$dt = new DateTime();
			$user->setDateCreated($dt);
			$user->setFormStatus($btn);
			$em->persist($user);
			$em->flush();
			$id = $user->getId();
			$service = new Service_Form();
			$service->setNewDeliverable($deliverable,$achievement,$self_score,$id);
			$service->setNewImprovement($improvement,$id);
			$service->setNewDevelopment($development,$id);
				
		}
	public function setUpdateData($dept_name,$deliverable,$updateIds,$achievement,$self_score,$improvement,$development,$ids)
		{
			/*//echo "<pre>";
			//print_r($ids);die;
			
			$user = $em->find('Entities\\FormDetails',$ids['id']);
			//var_dump($user);die;
			$user->setDeptName($dept_name);
			$dt = new DateTime();
			$user->setDateUpdated($dt);
			$em->persist($user);
			$em->flush();*/
			$service = new Service_Form();
			//$service->setUpdateDeliverable($deliverable,$achievement,$self_score,$updateIds);
			//$service->setUpdateImprovement($improvement,$ids['id_imp']);
			//$service->setUpdateDevelopment($development,$ids['id_dep']);
		}
	public function setNewDeliverable($deliverable,$achievement,$self_score,$id)
		{
			$em = Zend_Registry::get("em"); 
			$d = $em->find('Entities\FormDetails',$id);
			for($i = 0; $i<sizeof($deliverable)||$i<sizeof($achievement)||$i<sizeof($self_score);$i++)
			{
				$user = new \Entities\FormDeliverables;
				$user->setFormdetail($d);
				$user->setKeyDeliverables($deliverable[$i]);
				$user->setAchieventLevel($achievement[$i]);
				$user->setSelfScore($self_score[$i]);
			$dt = new DateTime();
			$user->setDateCreated($dt);
			$em->persist($user);
		}
		$em->flush();
	}	
	public function setNewImprovement($improvement,$id)
		{
			$em = Zend_Registry::get("em"); 
			$user = new \Entities\QualitativeImprovement;
			$d = $em->find('Entities\FormDetails',$id);
			$user->setFormdetail($d);
			$user->setImprovementDetail($improvement);
			$dt = new DateTime();
			$user->setDateCreated($dt);
			$em->persist($user);
			$em->flush();
		}
	public function setNewDevelopment($development,$id)
		{
			$em = Zend_Registry::get("em"); 
			$user = new \Entities\SelfDevelopment;
			$d = $em->find('Entities\FormDetails',$id);
			$user->setFormdetail($d);
			$user->setRequirementDetail($development);
			$dt = new DateTime();
			$user->setDateCreated($dt);
			$em->persist($user);
			$em->flush();
		}
			
	public function setUpdateDeliverable($deliverable,$achievement,$self_score,$updateIds)
		{
			//echo "<pre>";
			//print_r($deliverable);
			//print_r($updateIds);
			//die;
			$em = Zend_Registry::get("em"); 
			$user = $em->find('Entities\FormDeliverables',$id);
			$user->setKeyDeliverables($deliverable);
			$user->setAchieventLevel($achievement);
			$user->setSelfScore($self_score);
			$dt = new DateTime(); 
			$user->setDateUpdated($dt);
			$em->persist($user);
			$em->flush();
		}
	public function setUpdateImprovement($improvement,$id)
		{
			$em = Zend_Registry::get("em"); 
			$user = $em->find('Entities\QualitativeImprovement',$id);
			$user->setImprovementDetail($improvement);
			$dt = new DateTime(); 
			$user->setDateUpdated($dt);
			$em->persist($user);
			$em->flush();
		}	
	public function setUpdateDevelopment($development,$id)
		{
			$em = Zend_Registry::get("em"); 
			$user = $em->find('Entities\SelfDevelopment',$id);
			$user->setRequirementDetail($development);
			$dt = new DateTime(); 
			$user->setDateUpdated($dt);
			$em->persist($user);
			$em->flush();
		}
			
		
	public function getFormData($emp_id)
		{
			//print_r($emp_id);die;
			//$data = new \Entities\FormDetails;
			$final_Result = array();
			$em = Zend_Registry::get("em"); 
			$qb = $em->createQueryBuilder();	
			$qb->select('f.id,f.empId,f.deptName')
			   ->from('Entities\FormDetails','f')
			   ->where('f.empId = :empid')
			   ->setParameter('empid',$emp_id);
			$query = $qb->getQuery();
			$result = $query->getSingleResult();
			$formid  = $result['id'];
			$res = $this->getFormDeliverable($formid);
			
			$res1 =$this->getFormImprovement($formid);
			
			$res2 =$this->getFormDevelopment($formid);
			
			$final_Result  = array($result,'deliver'=>$res,$res1,$res2);
			//echo "<pre>";
			//print_r($final_Result);die;
			return $final_Result;
			/*echo "<pre>";
			print_r($final_Result);die;*/
		}
	public function getFormDeliverable($formid)
		{
			$em = Zend_Registry::get("em"); 
			$qb = $em->createQueryBuilder();	
			$qb->select('f.id,f.keyDeliverables,f.achieventLevel,f.selfScore')
			   ->from('Entities\FormDeliverables','f')
			   ->where('f.formdetail = :formid')
			   ->setParameter('formid',$formid);
			$query = $qb->getQuery();
			$result = $query->getResult();
			//echo "<pre>";
		   // print_r($result);die;
			/*$result['id_del'] = $result['id'];
			unset($result['id']);*/
			return $result;
		}
	public function getFormImprovement($formid)
		{
			$em = Zend_Registry::get("em"); 
			$qb = $em->createQueryBuilder();	
			$qb->select('f.id,f.improvementDetail')
			   ->from('Entities\QualitativeImprovement','f')
			   ->where('f.formdetail = :formid')
			   ->setParameter('formid',$formid);
			$query = $qb->getQuery();
			
			$result = $query->getSingleResult();
			$result['id_imp'] = $result['id'];
			unset($result['id']);
			return $result;
		}
	public function getFormDevelopment($formid)
		{
			$em = Zend_Registry::get("em"); 
			$qb = $em->createQueryBuilder();	
			$qb->select('f.id,f.requirementDetail')
			   ->from('Entities\SelfDevelopment','f')
			   ->where('f.formdetail = :formid')
			   ->setParameter('formid',$formid);
			$query = $qb->getQuery();
			$result = $query->getSingleResult();
			$result['id_dep'] = $result['id'];
			unset($result['id']);
			return $result;
		}
	public function addComment($acomment,$aId,$bcomment,$bId,$ccomment,$cID)
	{
		$em = Zend_Registry::get("em"); 
		$qb = $em->createQueryBuilder();	
	
	}	
			

		
		
}
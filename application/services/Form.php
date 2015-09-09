<?php

class Service_Form 
{
	public function getReportHead($emp_id)
	{
		$em = Zend_Registry::get("em"); 
		$qb = $em->createQueryBuilder();
		$qb->select('emp.empName,emp.email')
		   ->from('Entities\\EmpTeamlead','etl')
		   ->innerJoin('etl.head', 'emp')
		   ->where('etl.emp =:id')
		   ->setParameter('id', $emp_id);
		$query = $qb->getQuery();
		try {		
			$result = $query->getSingleResult();
			return $result;
		} catch(\Exception $e) {
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
		try {		
			$result = $query->getResult();
			return $result;
		} catch(\Exception $e) {
			echo "no head";
		}
	}
	public function checkAvailablity($empid)
	{
		$em = Zend_Registry::get("em"); 
		$qb = $em->createQueryBuilder();	
		$qb->select('f.id,f.empId,f.startDate,f.endDate')
		   ->from('Entities\FormPeriod','f')
		   ->where('f.empId = :empid')
		   ->setParameter('empid',$empid);
		$query = $qb->getQuery();
		try {
			$result = $query->getSingleResult();
			$startDate = new DateTime($result['startDate']);
			$endDate = new DateTime($result['endDate']);
			$dt = new DateTime();		
		} catch(Exception $e) {
			return false;
		}
		if(($dt>$startDate) && ($dt<$endDate)) { 
			 if($empid==$result['empId']) {
				return $result['id'];
			 }
		} else {
			return false;
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
		} catch(Exception $e) {
			return true;
		}
	}
	public function setStatus($empid,$empEmailId,$headEmailId) 
	{
		$sts = "waiting_for_review";
		$em = Zend_Registry::get("em");
		$qb = $em->createQueryBuilder();	
		$q = $qb->update('Entities\\FormDetails', 'f')
			->set('f.formStatus','?1')
			->where('f.empId = :empid')
			->setParameter(1, $sts)
			->setParameter('empid',$empid)
			->getQuery();
		$query = $q->execute();
		$sendMail = new Web_Mail();
        $sendMail -> mail($empEmailId,$headEmailId);
	}
	public function setFormData(
				$dept_name,
				$formid,
				$idImp,
				$idDep,
				$deliverable,
				$achievement,
				$self_score,
				$upids,
				$improvement,
				$development ,
				$emp_id,
				$form_id,
				$ids = null
		)  {
			$em = Zend_Registry::get("em");
			$qb = $em->createQueryBuilder();	
			$qb->select('f.empId,f.id')
			   ->from('Entities\\FormDetails','f')
			   ->where('f.empId =:empid')
			   ->setParameter('empid',$emp_id);
			$query = $qb->getQuery();	
			$service = new Service_Form();
			try {
				$result = $query->getSingleResult();
				$service->setUpdateData($dept_name,
						$idImp,
						$idDep,
						$deliverable,
						$achievement,
						$self_score,
						$upids,
						$improvement,
						$development,
						$ids,
						$formid
					);		
			} catch(Exception $e) {
				echo "not found";
				$service = new Service_Form();
				$service->setNewData(
						$dept_name,
						$deliverable,
						$achievement,
						$self_score,
						$improvement,
						$development,
						$emp_id,
						$form_id
					);
			}	
	}
	public function setNewData($dept_name,
				$deliverable,
				$achievement,
				$self_score,
				$improvement,
				$development,
				$emp_id,
				$form_id
		) {
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
			$service->setNewDeliverable($deliverable, $achievement, $self_score, $id);
			$service->setNewImprovement($improvement, $id);
			$service->setNewDevelopment($development, $id);
				
		}
	public function setUpdateData(
				$dept_name,
				$idImp,
				$idDep,
				$deliverable,
				$achievement,
				$self_score,
				$upids,
				$improvement,
				$development,
				$ids,
				$formid
		) {
			$em = Zend_Registry::get("em"); 
			$user = $em->find('Entities\\FormDetails',$formid);
			//var_dump($user);die;
			$user->setDeptName($dept_name);
			$dt = new DateTime();
			$user->setDateUpdated($dt);
			$em->persist($user);
			$em->flush();
			$formid = $user->getId();
			$service = new Service_Form();
			$service->setUpdateDeliverable($deliverable, $achievement, $self_score, $upids, $ids, $formid);
			$service->setUpdateImprovement($improvement, $idImp);
			$service->setUpdateDevelopment($development, $idDep);
	}
	public function setNewDeliverable($deliverable, $achievement, $self_score, $id)
	{
		$em = Zend_Registry::get("em"); 
		$d = $em->find('Entities\FormDetails',$id);
		for($i = 0; $i<sizeof($deliverable)||$i<sizeof($achievement)||$i<sizeof($self_score);$i++) {
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
	public function setNewImprovement($improvement, $id)
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
	public function setNewDevelopment($development, $id)
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
	public function setUpdateDeliverable($deliverable, $achievement, $self_score, $upids,$ids, $formid)
	{	
		$em = Zend_Registry::get("em"); 
		foreach ($ids as $u) {
			$delId[] = array_diff($u,$upids);
		}
		if(!empty($delId)) {
			$id = array();
			foreach($delId as $dId) {
				if(isset($dId['id'])) {
					$id[] = $dId['id'];
				}
			}
			for($i=0;$i<sizeof($id);$i++) {
				$user = $em->find('Entities\FormDeliverables', $id[$i]);
				$em->remove($user);
				$em->flush();	
			}	
		}
		for($i = 0;$i<sizeof($upids);$i++) 
		{
			$qb = $em->createQueryBuilder();
			$q = $qb->update('Entities\FormDeliverables','f')
					->set('f.keyDeliverables',':del')
					->set('f.achieventLevel','?1')
					->set('f.selfScore','?2')
					->where('f.id = ?3')
					->setParameter('del', $deliverable[$i])
					->setParameter(1, $achievement[$i])
					->setParameter(2, $self_score[$i])	
					->setParameter(3, $upids[$i])
					->getQuery();
			$p = $q->execute();		
		}	
		$em = Zend_Registry::get("em"); 
		$d = $em->find('Entities\FormDetails',$formid);
		for($i = 0; $i<sizeof($deliverable)||$i<sizeof($achievement)||$i<sizeof($self_score);$i++) {
			if(!isset($upids[$i])) {
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
	}
	public function setUpdateImprovement($improvement, $idImp)
	{
		$em = Zend_Registry::get("em"); 
		$user = $em->find('Entities\QualitativeImprovement',$idImp);
		$user->setImprovementDetail($improvement);
		$dt = new DateTime(); 
		$user->setDateUpdated($dt);
		$em->persist($user);
		$em->flush();
	}	
	public function setUpdateDevelopment($development, $idDep)
	{
		$em = Zend_Registry::get("em"); 
		$user = $em->find('Entities\SelfDevelopment',$idDep);
		$user->setRequirementDetail($development);
		$dt = new DateTime(); 
		$user->setDateUpdated($dt);
		$em->persist($user);
		$em->flush();
	}
	public function getFormData($emp_id)
	{
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
		return $final_Result;
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
		for($i =0;$i<sizeof($acomment);$i++) {
			$user = $em->find('Entities\FormDeliverables',$aId[$i]);
			$user->setAppraiserComment($acomment[$i]);
			$dt = new DateTime(); 
			$user->setDateUpdated($dt);
			$em->persist($user);
		}
		$em->flush();	
		$user = $em->find('Entities\QualitativeImprovement',$bId);
		$user->setAppraiserComment($bcomment);
		$dt = new DateTime(); 
		$user->setDateUpdated($dt);
		$em->persist($user);
		$em->flush();	

		$user = $em->find('Entities\SelfDevelopment',$cID);
		$user->setAppraiserComment($ccomment);
		$dt = new DateTime(); 
		$user->setDateUpdated($dt);
		$em->persist($user);
		$em->flush();	
	}
	public function formData($empid) 
	{
		$em = Zend_Registry::get("em"); 
		$qb = $em->createQueryBuilder();
		$qb->select('ep.empName, ep.employeeCode')
		   ->from('Entities\\login','ep')
		   ->where('ep.empId =:id')
		   ->setParameter('id', $empid);
		$query = $qb->getQuery();
		try {		
			$result = $query->getSingleResult();
			return $result;
		} catch(\Exception $e) {
			echo "no details";
		}
	}			
}
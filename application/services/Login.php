<?php

class Service_Login 
{
	/*public $em;
	public function init()
	{
	
	}*/
	public function loginData($username,$password) 
	{
		$em = Zend_Registry::get("em"); 
		$user = new \Entities\Login;
		$user->setUsername($username);
		$user->setPassword($password);
		$user->setUserType($usertype);
		$em->persist($user);
		$em->flush();
	}
	public function getloginData($username,$password)
	{
		$em = Zend_Registry::get("em"); 
		$qb = $em->createQueryBuilder();
		  
		$qb->select('l')
		   ->from('Entities\\Login','l')
		   ->where('l.username = :user')
		   ->andWhere('l.password = :pass')
		   ->setParameters(array('user' => $username, 'pass' => $password));
		$query = $qb->getQuery();
		$result = $query->getSingleResult();
		return $result;
	}
	
}
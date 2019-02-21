<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class OrderRows
{
	private $entityManager;
	private $repository;
	private $fromInt = 0;
	private $toInt = 0;
	private $newPos = 0;
	private $orderFieldName;

	public function __construct($entityClass, $orderFieldName, EntityManagerInterface $entityManager) 
	{
		$this->entityManager = $entityManager;
		$this->orderFieldName = $orderFieldName;
		$this->repository = $this->entityManager->getRepository($entityClass);
	}

	public function from($fromInt)
	{
		$this->fromInt = $fromInt;
		return $this;
	}

	public function to($toInt)
	{
		$this->toInt = $toInt;
		return $this;
	}

	public function addSpace($newPos)
	{
		$this->newPos = $newPos;
		return $this;
	}

	public function reset()
	{
		$pages = $this->repository
			->findBy(array(), [
				$this->orderFieldName => 'ASC'
				]);
		$i = 1;
		foreach($pages as $page) {
			$page->setPageOrder($i);
			$i++;
		}
		$this->entityManager->flush();
	}

	public function move()
	{

		$pages = $this->repository
			->findBy(array(), [
				$this->orderFieldName => 'ASC'
				]);

		if($this->newPos) {

			$this->reset();

			foreach($pages as $page) {
	    		if($page->getPageOrder() >= $this->newPos) {
	    			$page->setPageOrder($page->getPageOrder() + 1);
	    		}
	    	}

	    	$this->entityManager->flush();

		} elseif($this->fromInt && $this->toInt) {

			$this->reset();

			foreach($pages as $page) {
	    		if($this->fromInt < $this->toInt) {
	    			if($page->getPageOrder() == $this->fromInt) {
	    				$page->setPageOrder($this->toInt);
	    			} elseif($page->getPageOrder() <= $this->toInt) {
	    				$page->setPageOrder($page->getPageOrder()-1);
	    			}
	    		}	
	    		if($this->fromInt > $this->toInt) {
	    			if($page->getPageOrder() < $this->fromInt) {
	    				$page->setPageOrder($page->getPageOrder()+1);
	    			} elseif($page->getPageOrder() == $this->fromInt) {
	    				$page->setPageOrder($this->toInt);
	    			}
	    		}
	    	}

	    	$this->entityManager->flush();

			$this->reset();

		}
	}
}

<?php

namespace App\Service;

use App\Entity\PageContent;
use Doctrine\ORM\EntityManagerInterface;

class Menu
{
	private $repository;

	public function __construct(EntityManagerInterface $entityManager) 
	{
		$this->repository = $entityManager->getRepository(PageContent::class);
	}

	public function getMenuList()
	{
		return $this->repository->findPublished();
	}
}

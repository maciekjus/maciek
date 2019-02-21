<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
	private $passwordEncoder;

	public function __construct(UserPasswordEncoderInterface $passwordEncoder)
	{
		$this->passwordEncoder = $passwordEncoder;
	}

    public function load(ObjectManager $manager)
    {
    	$user = new User();
    	$user->setPassword($this->passwordEncoder->encodePassword($user, 'haslo'));
    	$user->setRoles(array('ROLE_ADMIN'));
    	$user->setUsername('mirek');
        $manager->persist($user);
        $manager->flush();
        
    	$user = new User();
    	$user->setPassword($this->passwordEncoder->encodePassword($user, 'haslo'));
    	$user->setRoles(array('ROLE_ADMIN'));
    	$user->setUsername('maciek');
        $manager->persist($user);
        $manager->flush();
    	
    }
}

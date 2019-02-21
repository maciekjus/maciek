<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\PageContent;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Service\OrderRows;
use Symfony\Component\Yaml\Yaml;


/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{

	private $style = '';

	public function __construct()
	{
		$this->style = '/css/admin_style.css';
	}


    /**
     * @Route("/admin/start", name="admin")
     */
    public function index()
    {

    	return $this->redirectToRoute('admin_pages');

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'Strona główna admina',

        ]);
    }


    /**
     * @Route("/admin/strony", name="admin_pages")
     */
    public function pages()
    {

    	$countPages = 0;

    	// test test test
    	$yamlpa = Yaml::parseFile('../config/services.yaml');
    	$yamlpa['mef'] = "gggg";
    	$x = Yaml::dump($yamlpa, 3);
    	file_put_contents('../config/testmef.yaml', $x);
    	// test test test

    	$pages = $this->getDoctrine()
    		->getRepository(PageContent::class)
    		->findBy(array(), ['pageOrder' => 'ASC']);

    	if($pages) {
    		$countPages = count($pages);
    	}

        return $this->render('admin/pages1.html.twig', [
            'pages_list' => $pages,
        ]);
    }


	/**
     * @Route("/admin/strony/{page}", name="admin_edit_page")
     */
	public function editPage(Security $security, Request $request, $page) {

		$pageContent = new PageContent();

		$idPage = false;
		$lastUpdate = false;
		$choices = array();
		$pageCount = 1;

		$pageContentQuery = $this->getDoctrine()
            ->getRepository(PageContent::class)
            ->findOneBy([
                'id' => $page,
                ]);

        if($pageContentQuery) {
        	$pageContent = $pageContentQuery;
        	$idPage = $pageContentQuery->getId();
        	$lastUpdate = $pageContentQuery->getModyf();
        }

		if($pageContent->getContent() === NULL) {
			$pageContent->setContent(' ');
		}

		// ustalenie listy kolejnosci
		$pageContentQueryCount = $this->getDoctrine()
            ->getRepository(PageContent::class)
            ->findAll();


        if($pageContentQueryCount) {
        	$pageCount = count($pageContentQueryCount);

        	if(!$idPage) {
        		$pageCount++;
        	}
        	for($i=1; $i<=$pageCount; $i++) {
	        	$choices[$i] = $i;
	        }
        } else {
        	$choices[1] = 1;
        }

		
		$form = $this->createFormBuilder($pageContent)
			->setAction($this->generateUrl('admin_edit_page', array('page' => $page)))
			->add('oldOrder', HiddenType::class, array(
				'data' => $pageContent->getPageOrder(), 
				'mapped' => false
				))
			->add('router', TextType::class, array('label' => 'Adres strony'))
			->add('menutext', TextType::class, array('label' => 'Nazwa w menu'))
			->add('published', CheckboxType::class, array(
				'label' => 'Publikacja',
				'required' => false,
				))
			->add('mainpage', CheckboxType::class, array(
				'label' => 'Strona główna',
				'required' => false,
				))
			->add('title', TextType::class, array('label' => 'Tytuł'))
			->add('page_order', ChoiceType::class, array('label' => 'Kolejność na pasku menu', 'choices' => $choices))
			->add('content', TextareaType::class, array(
				'attr' => array('class' => 'ckeditor'),
				'label' => false,
				'trim' => true,
				))
			->add('save', SubmitType::class, array('label' => 'Zapisz'))
			->getForm();


		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$entityManager = $this->getDoctrine()->getManager();

			$pageOrderManager = new OrderRows(PageContent::class, 'pageOrder', $entityManager);

			$pageContent = $form->getData();

			if($pageContent->getId()) {
				
				$pageOrderManager
					->from($form->get('oldOrder')->getData())
					->to($pageContent->getPageOrder())
					->move();
			} else {
				$pageOrderManager
					->addSpace($pageContent->getPageOrder())
					->move();
			}

			$pageContent->setModyf(new \DateTime('now', new \DateTimeZone('+0100')));
			$pageContent->setAuthor($security->getUser()->getUsername());

			if($pageContent->getMainpage()) {
				$pageContentQuery1 = $this->getDoctrine()
		            ->getRepository(PageContent::class)
		            ->findAll();
		            foreach($pageContentQuery1 as $W) {
		            	$W->setMainpage(false);
		            	$entityManager->persist($W);
		            }
		            $entityManager->flush();
		            $pageContent->setMainPage(true);
			}

			$entityManager->persist($pageContent);
			$entityManager->flush();

			return $this->redirectToRoute('admin_pages');

		}
		

		return $this->render('admin/edit_page_form.html.twig', [
			'id_page' => $idPage,
            'form' => $form->createView(),
            'style' => $this->style,
            'last_update' => $lastUpdate, 
        ]);
	}


    /**
     * @Route("/admin/strony/usun/{page}", name="admin_delete_page")
     */
    public function delete($page)
    {
    	$entityManager = $this->getDoctrine()->getManager();
    	$pageToDel = $this->getDoctrine()
            ->getRepository(PageContent::class)
            ->findOneBy([
            	'id' => $page,
            	]);
        if($pageToDel) {
        	$entityManager->remove($pageToDel);
        	$entityManager->flush();
        }
        $pageOrderManager = new OrderRows(PageContent::class, 'pageOrder', $entityManager);
        $pageOrderManager->reset();

        return $this->redirectToRoute('admin_pages');

    }


    /**
     * @Route("/admin/strony/przenies/{from}/{to}", name="admin_move_page")
     */
    public function move($from, $to)
    {
    
        return $this->redirectToRoute('admin_pages');

    }







}

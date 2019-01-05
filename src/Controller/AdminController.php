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
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'Strona główna admina',

        ]);
    }

	/**
     * @Route("/admin/strona/{page}", name="admin_new_page")
     */
	public function newPage(Security $security, Request $request, $page="nowa") {

		$pageContent = new PageContent();

		$pageContentQuery = $this->getDoctrine()
            ->getRepository(PageContent::class)
            ->findOneBy([
                'id' => $page,
                ]);

        if($pageContentQuery) {
        	$pageContent = $pageContentQuery;
        }

		if($pageContent->getContent() === NULL) {
			$pageContent->setContent(' ');
		}
		
		$form = $this->createFormBuilder($pageContent)
			->setAction($this->generateUrl('admin_new_page', array('page' => $page)))
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
			->add('content', TextareaType::class, array(
				'attr' => array('class' => 'ckeditor'),
				'label' => false,
				'trim' => true,
				))
			->add('save', SubmitType::class, array('label' => 'Zapisz'))
			->getForm();


		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$pageContent = $form->getData();

			$pageContent->setModyf(new \DateTime('now', new \DateTimeZone('+0100')));
			$pageContent->setAuthor($security->getUser()->getUsername());

			// !!!! Tu zaktualizować wszystkie pola "mainpage" na false jeżeli zostałą zaznaczona w formularzu opcja "Strona główna"
			if($pageContent->getMainpage()) {
				$pageContentQuery1 = $this->getDoctrine()
		            ->getRepository(PageContent::class)
		            ->findAll();
		            $entityManager = $this->getDoctrine()->getManager();
		            foreach($pageContentQuery1 as $W) {
		            	$W->setMainpage(false);
		            	$entityManager->persist($W);
		            }
		            $entityManager->flush();
		            $pageContent->setMainPage(true);
			}

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($pageContent);
			$entityManager->flush();

			return $this->redirectToRoute('admin_new_page', array('page' => $page));
		}
		


		return $this->render('pages/new_page_form.html.twig', [
            'form' => $form->createView(),
            'style' => $this->style,
        ]);
	}

}

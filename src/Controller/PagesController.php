<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\PageContent;
use App\Service\Menu;
use App\Service\Offer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\HttpFoundation\Request;


class PagesController extends AbstractController
{

    private $addons = array();
	
	/**
     * @Route("/login", name="redirect_login")
     */
    public function logRed()
    {
    	return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/admin", name="redirect_admin")
     */
    public function admRed()
    {
        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/cktest", name="redirecttest")
     */
    public function cktest()
    {
        return $this->redirectToRoute('cktest');
    }

    /**
     * @Route("/kontaktee", name="contactee")
     */
    public function contact(Menu $menu)
    {
        /*
        
        */
        $menuList = $menu->getMenuList();

        return $this->render('contact/form.html.twig', [
            'style' => '/css/style.css',
            'menulist' => $menuList,
        ]);
    }

    /**
     * @Route("/{page}", name="pages")
     */
    public function index($page = '_start_', Menu $menu, \Swift_Mailer $mailer, Request $request)
    {

        if($page == '_start_') {
            $mainPageQuery = $this->getDoctrine()
            ->getRepository(PageContent::class)
            ->findOneBy([
                'mainpage' => true,
                ]);
            if($mainPageQuery) {
                $page = $mainPageQuery->getRouter();
            }
        }

        $style = '/css/style.css';
        $formView = false;


        $contactForm = false;
        if($page == 'kontakt') {
            $contactForm = true;
        }

        if($contactForm) {
            $dateTime = new \DateTime('now', new \DateTimeZone('+0100'));

            $form = $this->createFormBuilder()
                ->add('name', TextType::class, ['label' => 'Imię i Nazwisko', 'required' => false])
                ->add('email', EmailType::class, ['label' => 'Adres e-mail', 'required' => false])
                ->add('tel', TelType::class, ['label' => 'Telefon kontaktowy', 'required' => false])
                ->add('message', TextareaType::class, ['label' => 'Treść wiadomości'])
                ->add('time_now', HiddenType::class, ['data' => $dateTime->format('Y-m-d H:i:s')])
                ->add('save', SubmitType::class, ['label' => 'Wyślij wiadomość'])
                ->getForm();
        
            $form->handleRequest($request);

            $failures = false;

            if ($form->isSubmitted() && $form->isValid()) {
                $formData = $form->getData();
                $message = (new \Swift_Message($formData['name'] . ' - Formularz kontaktowy'))
                ->setFrom('formularz@jusiewicz.pl')
                ->setTo('maciekreg@gmail.com')
                ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig', [
                            'name' => $formData['name'],
                            'email' => $formData['email'],
                            'message' => $formData['message'],
                            'time_now' => $formData['time_now'],
                            'tel' => $formData['tel'],
                            ]),
                    'text/html'
                );

                

                if($mailer->send($message, $failures)) {
                    $this->addFlash(
                        'notice',
                        'Dziękujemy. Wiadomość została wysłana.'
                    );
                } else {
                    $this->addFlash(
                        'notice',
                        'Przepraszamy. Wystąpił błąd podczas wysyłania wiadomości. Spróbuj jeszcze raz albo skontaktuj się mailowo lub telefonicznie.'
                    );
                }

                return $this->redirectToRoute('pages', ['page' => $page]);
            }

            $formView = $form->createView();

        }




        $pageContent = $this->getDoctrine()
            ->getRepository(PageContent::class)
            ->findOneBy([
                'router' => $page,
                'published' => true,
                ]);

        if(!$pageContent) {
            throw $this->createNotFoundException('Strona nie istnieje.');
        }

        if($page == 'oferta') $this->setAddon(new Offer());

        $startPage = false;
        if($pageContent->getMainpage() == 1) {
            $startPage = true;
        }


        $title = $pageContent->getTitle();
        $content = $pageContent->getContent();
        $author = $pageContent->getAuthor();
        $lastModified = $pageContent->getModyf();
        $id = $pageContent->getId();


        $menuList = $menu->getMenuList();

        return $this->render('pages/index.html.twig', [
            'addons' => $this->addons,
            'contact_form' => $contactForm,
            'start' => $startPage,
            'id' => $id,
            'style' => $style,
            'title' => $title,
            'content' => $content,
            'author' => $author,
            'lastModified' => $lastModified,
            'menulist' => $menuList,
            'form' => $formView,
            
        ]);
    }
    

    public function setAddon($addonClass)
    {
        $this->addons[] = array(
            'template' => $addonClass->getTeplateName(),
            'data' => $addonClass->getData()
            );
    }


}

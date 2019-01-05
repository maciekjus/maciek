<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\PageContent;
use App\Service\Menu;


class PagesController extends AbstractController
{
	
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
     * @Route("/{page}", name="pages")
     */
    public function index($page = '_start_', Menu $menu)
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

        $pageContent = $this->getDoctrine()
            ->getRepository(PageContent::class)
            ->findOneBy([
                'router' => $page,
                'published' => true,
                ]);

        if(!$pageContent) {
            return $this->redirectToRoute('page_not_found');
        }


        $title = $pageContent->getTitle();
        $content = $pageContent->getContent();
        $author = $pageContent->getAuthor();
        $lastModified = $pageContent->getModyf();

        $menuList = $menu->getMenuList();

        return $this->render('pages/index.html.twig', [
            'style' => $style,
            'title' => $title,
            'content' => $content,
            'author' => $author,
            'lastModified' => $lastModified,
            'menulist' => $menuList,
        ]);
    }


}

<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends BaseController
{
    /**
     * @Route("/category", name="category_list")
     */
    public function index(Request $request): Response
    {
        $categories = $this
            ->getDoctrine()
            ->getRepository(Category::class)
            ->createQueryBuilder('c')
            ->select('c')
            ->getQuery()
            ->getArrayResult();
    
        if ($request->isXmlHttpRequest()) {
            // API call
            return $this->json($categories);
        } else {
            // Browser
            return $this->render('base.html.twig');
        }
        
    }
}


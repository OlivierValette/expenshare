<?php

namespace App\Controller;

use App\Entity\Person;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PersonController extends BaseController
{
    /**
     * @Route("/person", name="person_list")
     */
    public function index(Request $request): Response
    {
        $persons = $this
            ->getDoctrine()
            ->getRepository(Person::class)
            ->createQueryBuilder('p')
            ->select('p')
            ->getQuery()
            ->getArrayResult();
        
        if ($request->isXmlHttpRequest()) {
            // API call
            return $this->json($persons);
        } else {
            // Browser
            return $this->render('base.html.twig');
        }
        
    }
}

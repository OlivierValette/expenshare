<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\ShareGroup;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PersonController extends BaseController
{
    /**
     * @Route("/person/{slug}", name="person_list")
       */
    public function index(ShareGroup $group, Request $request): Response
    {
        $persons = $this
            ->getDoctrine()
            ->getRepository(Person::class)
            ->createQueryBuilder('p');
    
        $persons = $persons
            ->innerJoin('p.shareGroup', 's')
            ->where($persons->expr()->eq('s.slug', ':group'));
    
        $persons = $persons
            ->setParameter(':group', $group->getSlug())
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

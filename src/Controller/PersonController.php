<?php

namespace App\Controller;

use App\Entity\Expense;
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
        
        return $this->json($persons);

    }


    /**
     * @Route("/person/show/{id}", name="person_show")
     */
    public function show(Person $id, Request $request): Response
    {
        $persons = $this
            ->getDoctrine()
            ->getRepository(Expense::class)
            ->personExpense($id);
        
        return $this->json($persons);
        
    }
    
    /**
     * @Route("/person", name="person_new", methods="POST")
     */
    public function new(Request $request)
    {
        $data = $request->getContent();
        
        $jsonData = json_decode($data, true);
        
        $em = $this->getDoctrine()->getManager();
        
        $sharegroup = $em->getRepository(ShareGroup::class)
            ->findOneBySlug($jsonData["slug"]);

        
        $person = new Person();
        $person->setFirstname($jsonData["firstname"]);
        $person->setLastname($jsonData["lastname"]);
        $person->setShareGroup($sharegroup);
        
        $em->persist($person);
        $em->flush();
        
        return $this->json($this->serialize($person));
    }
    
    /**
     * @Route("/person/delete/{id}", name="person_delete", methods="DELETE")
     */
    public function delete(Request $request, Person $person)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($person);
        $em->flush();

         return $this->json($this->serialize($person));
    }

}


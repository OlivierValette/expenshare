<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Expense;
use App\Entity\Person;
use DateTime;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ExpenseController extends BaseController
{
    /**
     * @Route("/expense/list", name="expense_list")
     */
    public function index(Request $request): Response
    {
        $expenses = $this
            ->getDoctrine()
            ->getRepository(Expense::class)
            ->findAll();
        
        return $this->json($this->serialize($expenses));
        
    }
    
    /**
     * @Route("/expense/show/{id}", name="person_exp_list")
     */
    public function show(Person $id, Request $request): Response
    {
        $expenses = $this
            ->getDoctrine()
            ->getRepository(Expense::class)
            ->createQueryBuilder('e');
    
        $expenses = $expenses
            ->select('e', 'p', 'c')
            ->innerJoin('e.person', 'p')
            ->innerJoin('e.category', 'c')
            
            ->where($expenses->expr()->eq('p.id', ':id'));
    
        $expenses = $expenses
            ->setParameter(':id', $id->getId())
            ->getQuery()
            ->getArrayResult();
    
        return $this->json($this->serialize($expenses));
        
    }
    
    
    /**
     * @Route("/expense", name="expense_new", methods="POST")
     */
    public function new(Request $request)
    {
        $data = $request->getContent();
        
        $jsonData = json_decode($data, true);
    
        $em = $this->getDoctrine()->getManager();
    
        $category = $em->getRepository(Category::class)
            ->find($jsonData["categoryId"]);
        $person = $em->getRepository(Person::class)
            ->find($jsonData["personId"]);
        
        $expense = new Expense();
        $expense->setTitle($jsonData["title"]);
        $expense->setAmount($jsonData["amount"]);
        $expense->setCreatedAt(new DateTime());
        $expense->setCategory($category);
        $expense->setPerson($person);
        
        $em->persist($expense);
        $em->flush();
        
        return $this->json($this->serialize($expense));
    }
    
    /**
     * @Route("/expense/delete/{id}", name="expense_delete", methods="DELETE")
     */
    public function delete(Expense $expense)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($expense);
        $em->flush();
        
        return $this->json($this->serialize($expense));
    }
    
}

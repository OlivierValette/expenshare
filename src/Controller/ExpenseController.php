<?php

namespace App\Controller;

use App\Entity\Expense;
use App\Entity\Person;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ExpenseController extends BaseController
{
    /**
     * @Route("/expense/show/{id}", name="expense_list")
     */
    public function show(Person $id, Request $request): Response
    {
        $expenses = $this
            ->getDoctrine()
            ->getRepository(Expense::class)
            ->createQueryBuilder('e');
    
        $expenses = $expenses
            ->innerJoin('e.person', 'p')
            ->where($expenses->expr()->eq('p.id', ':id'));
    
        $expenses = $expenses
            ->setParameter(':id', $id->getId())
            ->getQuery()
            ->getArrayResult();
        
        if ($request->isXmlHttpRequest()) {
            // API call
            return $this->json($expenses);
        } else {
            // Browser
            return $this->render('base.html.twig');
        }
        
    }
}

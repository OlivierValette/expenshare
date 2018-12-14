<?php

namespace App\Controller;

use App\Entity\Expense;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ExpenseController extends BaseController
{
    /**
     * @Route("/expense", name="expense_list")
     */
    public function index(Request $request): Response
    {
        $expenses = $this
            ->getDoctrine()
            ->getRepository(Expense::class)
            ->createQueryBuilder('e')
            ->select('e')
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

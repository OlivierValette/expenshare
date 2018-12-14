<?php

namespace App\Controller;

use App\Entity\Debt;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DebtController extends BaseController
{
    /**
     * @Route("/debt", name="debt_list")
     */
    public function index(Request $request): Response
    {
        $debts = $this
            ->getDoctrine()
            ->getRepository(Debt::class)
            ->createQueryBuilder('c')
            ->select('c')
            ->getQuery()
            ->getArrayResult();
        
        if ($request->isXmlHttpRequest()) {
            // API call
            return $this->json($debts);
        } else {
            // Browser
            return $this->render('base.html.twig');
        }
        
    }
}

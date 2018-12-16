<?php

namespace App\Controller;

use App\Entity\ShareGroup;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ShareGroupController extends BaseController
{
    /**
     * @Route("/sharegroup", name="slug_list")
     */
    public function index(Request $request): Response
    {
        $sharedgroup = $this
            ->getDoctrine()
            ->getRepository(ShareGroup::class)
            ->createQueryBuilder('s')
            ->select('s')
            ->getQuery()
            ->getArrayResult();
        
        if ($request->isXmlHttpRequest()) {
            // API call
            return $this->json($sharedgroup);
        } else {
            // Browser
            return $this->render('base.html.twig');
        }
        
    }
}

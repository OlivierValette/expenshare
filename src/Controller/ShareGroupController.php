<?php

namespace App\Controller;

use App\Entity\ShareGroup;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ShareGroupController
 * @package App\Controller
 * @Route("/sharegroup")
 */
class ShareGroupController extends BaseController
{
    /**
     * @Route("/", name="slug_list", methods="GET")
     */
    public function list(Request $request): Response
    {
        $sharegroup = $this
            ->getDoctrine()
            ->getRepository(ShareGroup::class)
            ->createQueryBuilder('s')
            ->select('s')
            ->getQuery()
            ->getArrayResult();
    
        return $this->json($this->serialize($sharegroup));
        
    }

    /**
     * @Route("/{slug}", name="sharegroup_get", methods="GET")
     */
    public function index(ShareGroup $shareGroup, Request $request)
    {
        return $this->json($this->serialize($shareGroup));
    }
    
    /**
     * @Route("/", name="sharegroup_new", methods="POST")
     */
    public function new(Request $request)
    {
        $data = $request->getContent();
    
        $jsonData = json_decode($data, true);
    
        $em = $this->getDoctrine()->getManager();
    
        $sharegroup = new ShareGroup();
        $sharegroup->setSlug($jsonData["slug"]);
        $sharegroup->setCreatedAt(new \DateTime());
        $sharegroup->setClosed(false);
    
        $em->persist($sharegroup);
        $em->flush();
    
        return $this->json($this->serialize($sharegroup));
    }

}

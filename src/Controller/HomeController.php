<?php

namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\GiftList;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    const DEFAULT_PAGE_GIFTLIST_COUNT = 9;
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index()
    {
        $giftLists = $this->getDoctrine()
            ->getRepository(GiftList::class)
            ->getPublicGiftLists(self::DEFAULT_PAGE_GIFTLIST_COUNT);

         return $this->render('home/index.html.twig',
            ['data' => $giftLists]
        );
    }

}

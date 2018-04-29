<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GiftlistAdmin extends Controller
{
    /**
     * @Route("/saved/gift/list", name="saved_gift_list")
     */
    public function index()
    {
        return $this->render('giftlistadmin/index.html.twig', [
            'controller_name' => 'GiftlistAdminController',
        ]);
    }
}

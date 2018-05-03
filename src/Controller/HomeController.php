<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\GiftListType;
use App\Form\GiftType;
use App\Entity\GiftList;
use App\Entity\Gift;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

                 return $this->render('home/index.html.twig'

            );
    }


}

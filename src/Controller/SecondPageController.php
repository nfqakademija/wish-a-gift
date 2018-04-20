<?php


namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class SecondPageController extends Controller
{
    /**
     * @Route("/secondPage", name="secondPage")
     */
    public function index()
    {
        return $this->render('secondPage/index.html.twig', [
            'controller_name' => 'SecondPageController',
        ]);
    }

}
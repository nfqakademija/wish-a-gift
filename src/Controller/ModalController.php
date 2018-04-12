<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ModalController extends Controller
{
    /**
     * @Route("/modal", name="modal")
     */
    public function index()
    {
        return $this->render('modal/index.html.twig', [
            'controller_name' => 'ModalController',
        ]);
    }

}
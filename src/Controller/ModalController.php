<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ModalController extends Controller
{
    /**
     * @Route("/create", name="create")
     */
    public function index()
    {
        return $this->render('create/index.html.twig', [
            'controller_name' => 'ModalController',
        ]);
    }



}
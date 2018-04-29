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
    private $uuid;
    public function __construct()
    {
        $uuid4 = Uuid::uuid4();
        $this->uuid = $uuid4->toString();

    }

    /**
     * @Route("/", name="home")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
       // var_dump($this->uuid);
        $giftlist = new GiftList();
        $form = $this->createForm(GiftListType::class, $giftlist);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            //var_dump($request->request->get($form->getName()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($giftlist);
//            $entityManager->flush();

            $lastGiftListId = $giftlist->getId();


            return $this->render('create/index.html.twig',
                ['form' => $form->createView(),
                    'lastid' => 'update/'. $lastGiftListId,
                    'uuid' => $this->uuid
                ]
            );
        } else {
            return $this->render('home/index.html.twig',
                ['form' => $form->createView(),
                    'uuid' => $this->uuid
                ]

            );
        }
    }

}

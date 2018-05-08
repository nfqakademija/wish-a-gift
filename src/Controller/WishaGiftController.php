<?php
namespace App\Controller;

use App\Form\GiftListType;
use App\Entity\GiftList;
use App\Entity\Gift;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WishaGiftController extends Controller
{
    private $uuid;

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function create(Request $request)
    {
        $giftlist = new GiftList();

        $form = $this->createForm(GiftListType::class, $giftlist);
        $form->handleRequest($request);

        ////$errors = $form->getErrors();
        //var_dump($errors);


        if ($form->isSubmitted() && $form->isValid()) {



            $giftlist->setUuid(Uuid::uuid4()->toString());
            $giftlist->setUuidAdmin(Uuid::uuid4()->toString());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($giftlist);
            $entityManager->flush();
//
//            $lastGiftListId = $giftlist->getId();
//            $lastUuidAdmin = $giftlist->getUuidAdmin();

//            $data = $request->request->all();
//            $giftNames = $data['gift_list']['Gifts'];
//            $giftNames = '';
//            if (!isset($giftNames) || empty($giftNames)) {
//                $giftNames = $data['gift_list']['Gift']['Gift'];
//            }else {
//                $giftNames = "no gift";
//
//            }

//            foreach ($giftNames as $key => $giftName) {
//
//                $gift = new Gift();
//                $entityManager1 = $this->getDoctrine()->getManager();
//                $gift->setUserId($lastGiftListId);
//                $gift->setGift($giftName);
//                $entityManager1->persist($gift);
//                $entityManager1->flush();
//            }

            return $this->redirectToRoute('giftlist-admin',
                array(
                    'uuidadmin' => $giftlist->getUuidAdmin(),
                ));
        }


        return $this->render('create/index.html.twig',
            ['form' => $form->createView(),
//                'uuid' => $uuid,
//                'uuidadmin' => $uuidAdmin
        ]

        );
    }
}

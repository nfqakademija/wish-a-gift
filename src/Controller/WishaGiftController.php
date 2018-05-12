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
    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        // build the form
        $giftList = new GiftList();
        $giftList->addGift(new Gift());
        $form = $this->createForm(GiftListType::class, $giftList);

        // handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $giftList = $form->getData();
            $giftList->setUuid(Uuid::uuid4()->toString());
            $giftList->setUuidAdmin(Uuid::uuid4()->toString());

            // save data
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($giftList);
            $entityManager->flush();

            return $this->redirectToRoute('giftlist-admin',
                array(
                    'uuidadmin' => $giftList->getUuidAdmin(),
                ));
        }

        return $this->render('create/index.html.twig',
            ['form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/edit/{uuidadmin}", name="edit")
     * @param Request $request
     * @param string $uuidadmin
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, string $uuidadmin)
    {

        $giftListEntity = $this->getDoctrine()
            ->getRepository(GiftList::class)
            ->findOneBy(['uuidAdmin' => $uuidadmin]);

        // build the form
        $form = $this->createForm(GiftListType::class, $giftListEntity, ['allow_gift_editing' => false]); // TODO: allow only if not reservedAt flags are set in gifts collection

        // handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $giftListEntity = $form->getData();
            $giftListEntity->setUuid(Uuid::uuid4()->toString());
            $giftListEntity->setUuidAdmin(Uuid::uuid4()->toString());

            // save data
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($giftListEntity);
            $entityManager->flush();

            return $this->redirectToRoute('giftlist-admin',
                array(
                    'uuidadmin' => $giftListEntity->getUuidAdmin(),
                ));
        }

        return $this->render('create/index.html.twig',
            ['form' => $form->createView()]
        );
    }
}

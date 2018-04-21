<?php
namespace App\Controller;

use App\Form\GiftListType;
use App\Entity\GiftList;
use App\Entity\Gift;
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
        $giftlist = new GiftList();
        $gift = new Gift();

        $form = $this->createForm(GiftListType::class, $giftlist);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($giftlist);
            $entityManager->flush();

            $lastGiftListId = $giftlist->getId();

            $entityManager1 = $this->getDoctrine()->getManager();

            $data = $request->request->all();
            //var_dump($data);
            $giftName = $data['gift_list']['Gift']['Gift'];

            $gift->setUserId($lastGiftListId);
            $gift->setGift($giftName);
            $entityManager1->persist($gift);
            $entityManager1->flush();

           // return $this->redirectToRoute('publiclist');
        }

        return $this->render(
            'create/index.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/publiclist", name="publiclist")
     * @param Request $request
     * @return Response
     */
    public function publicList(Request $request)
    {
        $giftlist = $this->getDoctrine()
            ->getRepository(GiftList::class)
            ->findBy(['public_list' => 1]);

        //if (!$product) {
          //  throw $this->createNotFoundException(
               // 'No product found for id '.$id
           // );
        //}

        //return new Response('Name: '.$giftlist->getFirstname());
        return $this->render('publiclist/index.html.twig',
            ['giftlist' => $giftlist]);
    }
}

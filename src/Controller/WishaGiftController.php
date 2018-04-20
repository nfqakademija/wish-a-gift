<?php
namespace App\Controller;

use App\Form\GiftListType;
use App\Entity\GiftList;
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
        //var_dump($request);

        $form = $this->createForm(GiftListType::class, $giftlist, array(
            'method' => 'POST'));
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($giftlist);
            $entityManager->flush();

            return $this->redirectToRoute('publiclist');
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

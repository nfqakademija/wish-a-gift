<?php

namespace App\Controller;

use App\Entity\GiftList;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GiftListsController extends Controller
{
    /**
     * @Route("/giftlist/admin/{uuidadmin}", name="giftlist-admin")
     * @param Request $request
     * @param string $uuidadmin
     * @return Response
     */
    public function admin(Request $request, string $uuidadmin)
    {
        $getuuidadmin =  $this->getDoctrine()
            ->getRepository(GiftList::class)
            ->findByUuidAdmin($uuidadmin);

        $httpHostadmin = $request->getHttpHost();

        if (!$getuuidadmin){
            return $this->redirectToRoute('home');
        }
        return $this->render('giftlist/admin.html.twig',
            array(
                'data' => $getuuidadmin,
                'httpHost' => $httpHostadmin

            ));
    }

    /**
     * @Route("/giftlist/user/{uuiduser}", name="giftlist-user")
     * @param Request $request
     * @param string $uuiduser
     * @return Response
     */
    public function user(Request $request, string $uuiduser)
    {
        $getuuiduser =  $this->getDoctrine()
            ->getRepository(GiftList::class)
            ->findByUuidUser($uuiduser);

        $httpHostuser = $request->getHttpHost();

        if (!$getuuiduser){
            return $this->redirectToRoute('home');
        }
        return $this->render('giftlist/user.html.twig',
            array(
                'data' => $getuuiduser,
                'httpHost' => $httpHostuser

            ));
    }
}

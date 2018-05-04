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
        $getuuid =  $this->getDoctrine()
            ->getRepository(GiftList::class)
            ->findByUuidAdmin($uuidadmin);

        $httpHost = $request->getHttpHost();

        if (!$getuuid){
            return $this->redirectToRoute('home');
        }
        return $this->render('giftlistadmin/index.html.twig',
            array(
                'data' => $getuuid,
                'httpHost' => $httpHost

            ));
    }
}

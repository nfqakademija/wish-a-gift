<?php

namespace App\Controller;

use App\Entity\GiftList;
use App\Entity\Gift;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GiftListsController extends Controller
{
    public function uuidUser(string $uuiduser)
    {
        $getuuiduser =  $this->getDoctrine()
            ->getRepository(GiftList::class)
            ->findByUuidUser($uuiduser);
//        var_dump($getuuiduser);
        return $getuuiduser;
    }
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
        $getuuiduser = $this->uuidUser($uuiduser);
        if(!$this->uuidUser($uuiduser)) {
            return $this->redirectToRoute('home');
        }

        $httpHostuser = $request->getHttpHost();

        return $this->render('giftlist/user.html.twig',
            array(
                'data' => $getuuiduser,
                'httpHost' => $httpHostuser

            ));
    }

    /**
     * @Route("/giftlist/user/{uuiduser}/edit/{id}")
     * @param $id
     * @param $uuiduser
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function update($id, $uuiduser)
    {
        if(!$this->uuidUser($uuiduser)) {
            return $this->redirectToRoute('home');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $active = $entityManager->getRepository(Gift::class)->find($id);

        if (!$active) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $active->setActive(0);
        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            //'id' => $active ->getId()
        ]);
    }

}

<?php

namespace App\Controller;

use App\Entity\GiftList;
use App\Entity\Gift;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Ramsey\Uuid\Uuid;

//use Symfony\Component\BrowserKit\Cookie;
//use Symfony\Component\BrowserKit\CookieJar;
//use Symfony\Component\BrowserKit\Response;

class GiftListsController extends Controller
{
    public function uuidUser(string $uuiduser)
    {
        $getUuidUser = $this->getDoctrine()
            ->getRepository(GiftList::class)
            ->findOneBy(['uuid' => $uuiduser]);
//        var_dump($getUuidUser);
        return $getUuidUser;
    }

    /**
     * @Route("/giftlist/admin/{uuidadmin}", name="giftlist-admin")
     * @param Request $request
     * @param string $uuidadmin
     * @return Response
     */
    public function admin(Request $request, string $uuidadmin)
    {
        $giftListEntity = $this->getDoctrine()
            ->getRepository(GiftList::class)
            ->findOneBy(['uuidAdmin' => $uuidadmin]);

        if (!$giftListEntity) {
            throw $this->createNotFoundException();
//            return $this->redirectToRoute('home');
        }
        return $this->render('giftlist/admin.html.twig',
            array(
                'data' => $giftListEntity,
            ));
    }

    /**
     * @Route("/giftlist/{uuiduser}", name="giftlist-user")
     * @param Request $request
     * @param string $uuiduser
     * @return Response
     */
    public function user(Request $request, string $uuiduser)
    {
        $giftListEntity = $this->uuidUser($uuiduser);
        if (!$giftListEntity) {
            $this->addFlash('danger', 'Wishlist does not exist! Please, check the URL and try again, if you believe the URL has a valid format.');
            return $this->redirectToRoute('home');
        }

        $httpHostuser = $request->getHttpHost();

        return $this->render('giftlist/user.html.twig',
            array(
                'data' => $giftListEntity,
//                'httpHost' => $httpHostuser

            ));
    }

    /**
     * @Route("/giftlist/{uuiduser}/reserve/{id}", name="gift-reserve")
     * @param $id
     * @param $uuiduser
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function reserve(Request $request, $id, $uuiduser)
    {
        if (!$this->uuidUser($uuiduser)) {
            return $this->redirectToRoute('home');
        }

        $this->getDoctrine()
            ->getRepository(GiftList::class)
            ->findOneBy(['uuid' => $uuiduser]);

        $entityManager = $this->getDoctrine()->getManager();
        $active = $entityManager->getRepository(Gift::class)->find($id);
        if (!$active) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }
        $reservationToken = Uuid::uuid4()->toString();
        $response = new Response();
        $json = '{
            "'.$id.'": [ {
              "reservationToken":"'.$reservationToken.'"
            }]
        }';

        $cookie = new Cookie($id, $json, strtotime('now + 10 minutes'), '', null, false, false);
        $response->headers->setCookie($cookie);
        $response->sendHeaders();
        $active->setReservedAt(new \DateTime());
        $active->setReservationToken(Uuid::uuid4()->toString());
        $entityManager->flush();

        return $this->redirectToRoute('giftlist-user',
            array(
                'uuiduser' => $uuiduser,
               // 'cookie' => json_decode($request->cookies->get($id), true)
            ));
    }

    /**
     * @Route("/giftlist/{uuiduser}/unreserve/{id}", name="gift-unreserve")
     * @param $id
     * @param $uuiduser
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function unreserve($id, $uuiduser)
    {
        if (!$this->uuidUser($uuiduser)) {
            return $this->redirectToRoute('home');
        }

        $this->getDoctrine()
            ->getRepository(GiftList::class)
            ->findOneBy(['uuid' => $uuiduser]);

        $entityManager = $this->getDoctrine()->getManager();
        $active = $entityManager->getRepository(Gift::class)->find($id);
        if (!$active) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        $active->setReservedAt(Null);
        $active->setReservationToken(Null);
        $entityManager->flush();

        return $this->redirectToRoute('giftlist-user',
            array(
                'uuiduser' => $uuiduser
            ));
    }

    /**
     * @Route("/send", name="gift-send")
     * @param \Swift_Mailer $mailer
     * @return void
     */
    public function shareWithFriends(\Swift_Mailer $mailer)
    {
        //var_dump($mailer);
        //var_dump($mailer);
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('nejuras@gmail.com')
            ->setTo('nerusha@gmail.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/sharewithfriends.html.twig',
                    array('name' => 'ford')
                ),
                'text/html'
            );

        $mailer->send($message);
        //var_dump($mailer);

       // return $this->render();
        //return $this->redirectToRoute('home'
        //    );
    }

}

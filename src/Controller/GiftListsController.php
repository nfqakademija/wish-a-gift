<?php

namespace App\Controller;

use App\Entity\GiftList;
use App\Entity\Gift;
use App\Form\EmailsType;
use App\Service\ReservedGiftCookieResolver;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Ramsey\Uuid\Uuid;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class GiftListsController extends Controller
{
    public const RESERVED_GIFTS_COOKIE = 'reserved_gifts';

    public function uuidUser(string $uuiduser)
    {
        $getUuidUser = $this->getDoctrine()
            ->getRepository(GiftList::class)
            ->findOneBy(['uuid' => $uuiduser]);
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
        }

        $form = $this->createForm(EmailsType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data['url'] = $form['url']->getData();
            $data['subject'] = 'Gifts';
            $data['admin'] = $giftListEntity;

            foreach ($form['emails']->getData() as $email) {
               // var_dump($email);
                $this->shareWithFriends($email, $data);

            }

        }

        return $this->render('giftlist/admin.html.twig',
            array(
                'data' => $giftListEntity,
                'form' => $form->createView()
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

        $entityManager = $this->getDoctrine()->getManager();
        $active = $entityManager->getRepository(Gift::class)->findOneBy(['id' => $id, 'reservedAt' => null]);
        if (!$active) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }
        if ($active) {
            $this->addFlash(
                'warning', 'Be careful and think twice! You have 10 minutes to undo your reservation'
            );
        }
        $reservationToken = Uuid::uuid4()->toString();
        $response = new RedirectResponse($this->generateUrl('giftlist-user', ['uuiduser' => $uuiduser]));

        $cookie = $request->cookies->get(self::RESERVED_GIFTS_COOKIE);

        //return false already reserved one gift;
        $cookie = ReservedGiftCookieResolver::addGift($cookie, $id, $reservationToken);
//        var_dump($cookie);

//        $cookie = new Cookie(self::RESERVED_GIFTS_COOKIE, $json, strtotime('now + 10 minutes'), '', null, false, false);

//        $response->setExpires(\DateTimeInterface::COOKIE);
        $response->headers->setCookie($cookie);
//        $response->sendHeaders();
        $active->setReservedAt(new \DateTime());
        $active->setReservationToken($reservationToken);
        $entityManager->flush();

        return $response;
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

        $entityManager = $this->getDoctrine()->getManager();
        $active = $entityManager->getRepository(Gift::class)->find($id);
        if (!$active) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        //todo check isReservedByMe

        $active->setReservedAt(null);
        $active->setReservationToken(null);
        $entityManager->flush();

        $this->addFlash(
            'success', 'Your reservation has been canceled! Pick another gift!'
        );

        return $this->redirectToRoute('giftlist-user',
            array(
                'uuiduser' => $uuiduser
            ));
    }

    public function shareWithFriends($emails, $data)
    {
        $message = (new \Swift_Message($data['subject']))
            ->setFrom('nejuras@gmail.com')
            ->setTo($emails)
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/sharewithfriends.html.twig',
                    array('data' => $data)
                ),
                'text/html'
            );

        $this->get('mailer')->send($message);
    }

}

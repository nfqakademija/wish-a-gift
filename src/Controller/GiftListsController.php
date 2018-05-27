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
use Ramsey\Uuid\Uuid;


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
            // TODO: take URL not from request, but generate it in the controller
            $data['url'] = $form['url']->getData();
            $data['subject'] = 'Gifts';
            $data['admin'] = $giftListEntity;
            $data['emails'] = $form['emails']->getData();

            $this->sendToAdmin($giftListEntity->getEmail(), $data); // TODO: does it work? I did not get any email


            foreach ($data['emails'] as $email) {
                // var_dump($email);
                $this->shareWithFriends($email, $data);

            }

            // TODO: add success flash message

            return $this->redirectToRoute('giftlist-admin', ['uuidadmin' => $uuidadmin]);

        }

        return $this->render('giftlist/admin.html.twig',
            array(
                'data' => $giftListEntity,
                'form' => $form->createView()
            ));
    }

    /**
     * @Route("/giftlist/{uuiduser}", name="giftlist-user")
     * @param string $uuiduser
     * @return Response
     */
    public function user(string $uuiduser)
    {
        $giftListEntity = $this->uuidUser($uuiduser);
        if (!$giftListEntity) {
            $this->addFlash('danger', 'Wishlist does not exist! Please, check the URL and try again, if you believe the URL has a valid format.');
            return $this->redirectToRoute('home');
        }

        return $this->render('giftlist/user.html.twig',
            array(
                'data' => $giftListEntity

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
            // TODO: add flash message, that giftlist was not found.

            return $this->redirectToRoute('home');
        }

        $entityManager = $this->getDoctrine()->getManager();
        // TODO: find only by ID. If not found, show 404 or redirect to giftlist view page with error flash message
        // TODO: if found - check is reserveAt === null, if not redirect to giftlist view page as show flash message that it is already reserved
        $active = $entityManager->getRepository(Gift::class)->findOneBy(['id' => $id, 'reservedAt' => null]);
        if (!$active) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }
        if ($active) { // TODO is this if necessary? Make warning -> success message type
            $this->addFlash(
                'warning', 'Be careful and think twice! You have 10 minutes to undo your reservation.'
            );
        }
        $reservationToken = Uuid::uuid4()->toString();
        $response = new RedirectResponse($this->generateUrl('giftlist-user', ['uuiduser' => $uuiduser]));

        $cookie = $request->cookies->get(self::RESERVED_GIFTS_COOKIE);

        $giftList = $active->getGiftList();

        if (ReservedGiftCookieResolver::hasReservedGifts($cookie, $giftList)) {
            $this->addFlash(
                'warning', 'You have already reserved more than one gift. Leave some for others!'
            );
        }
        $cookie = ReservedGiftCookieResolver::addGift($cookie, $id, $reservationToken);
        $response->headers->setCookie($cookie);

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
    public function unreserve(Request $request, $id, $uuiduser)
    {
        if (!$this->uuidUser($uuiduser)) {
            // TODO: add flash message, that giftlist was not found.
            return $this->redirectToRoute('home');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $active = $entityManager->getRepository(Gift::class)->find($id);
        if (!$active) {
            // TODO: add flash message that gift is not found and redirect to giftlist page
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        // TODO: check if the gift is reserved by me and can I really undo? Check reservation token from the cookie and reservationAt flag. Use ReservedGiftCookieResolver
        // TODO: if it is not my reservation - redirect to giftlist page with flash error message

        $response = new RedirectResponse($this->generateUrl('giftlist-user', ['uuiduser' => $uuiduser]));

        $cookie = $request->cookies->get(self::RESERVED_GIFTS_COOKIE);
        $cookie = ReservedGiftCookieResolver::removeGift($cookie, $id);

        $response->headers->setCookie($cookie);
        $active->setReservedAt(null);
        $active->setReservationToken(null);
        $entityManager->flush();

        $this->addFlash(
            'success', 'Your reservation has been canceled! Pick another gift!'
        );

        return $response;
    }

    public function shareWithFriends($emails, $data) // TODO: it should be a private method
    {
        $message = (new \Swift_Message($data['subject']))
            ->setFrom('nejuras@gmail.com')
            ->setTo($emails)
            ->setBody(
                $this->renderView(
                    'emails/sharewithfriends.html.twig',
                    array('data' => $data)
                ),
                'text/html'
            );

        $this->get('mailer')->send($message);
    }

    public function sendToAdmin($emails, $data) // TODO: it should be a private method
    {
        $message = (new \Swift_Message($data['subject']))
            ->setFrom('nejuras@gmail.com')
            ->setTo($emails)
            ->setBody(
                $this->renderView(
                    'emails/sendtoadmin.html.twig',
                    array('data' => $data)
                ),
                'text/html'
            );

        $this->get('mailer')->send($message);
    }

}

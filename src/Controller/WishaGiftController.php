<?php
namespace App\Controller;

use App\Form\GiftListType;
use App\Form\GiftType;
use App\Entity\GiftList;
use App\Entity\Gift;
use App\Repository\GiftListRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

//use Ramsey\Uuid\Uuid;

class WishaGiftController extends Controller
{
    //pr
    private $uuid;

    public function uuid()
    {

        $uuid4 = Uuid::uuid4();
        $this->uuid = $uuid4->toString();

        return $this;
    }

    /**
     * @Route("/giftlist/admin/{uuidadmin}", name="giftlist-admin")
     * @param string $uuidadmin
     * @return Response
     */
    public function admin(string $uuidadmin)
    {
        $getuuid =  $this->getDoctrine()
            ->getRepository(GiftList::class)
            ->findByUuidAdmin($uuidadmin);

        if (!$getuuid){
            return $this->redirectToRoute('home');
        }
        return $this->render('giftlistadmin/index.html.twig',
            array(
                'uuidadmin' => $uuidadmin

            ));

    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function create(Request $request)
    {
        $uuidAdmin = $this->uuid()->uuid;
        $uuid = $this->uuid()->uuid;
        $giftlist = new GiftList();

        $form = $this->createForm(GiftListType::class, $giftlist);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($giftlist);
            $entityManager->flush();

            $lastGiftListId = $giftlist->getId();
            $lastUuidAdmin = $giftlist->getUuidAdmin();



          $data = $request->request->all();
            $giftNames = $data['gift_list']['Gifts'];
            foreach ($giftNames as $key => $giftName) {

                $gift = new Gift();
                $entityManager1 = $this->getDoctrine()->getManager();
                $gift->setUserId($lastGiftListId);
                $gift->setGift($giftName);
                $entityManager1->persist($gift);
                $entityManager1->flush();
            }

            return $this->redirectToRoute('giftlist-admin', array('uuidadmin' => $lastUuidAdmin));
        }


        return $this->render('create/index.html.twig',
            ['form' => $form->createView(),
                'uuid' => $uuid,
                'uuidadmin' => $uuidAdmin
        ]

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

        return $this->render('publiclist/index.html.twig',
            ['giftlist' => $giftlist]
        );
    }

    /**
     * @Route("/giftlist", name="giftlist")
     * @return Response
     */
    public function giftList()
    {
        var_dump('hh');
        return $this->render('giftlist/index.html.twig',
            ['giftlist' => 'jjj']
        );
    }
}

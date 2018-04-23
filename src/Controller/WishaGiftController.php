<?php
namespace App\Controller;

use App\Form\GiftListType;
use App\Form\GiftType;
use App\Entity\GiftList;
use App\Entity\Gift;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

//use Ramsey\Uuid\Uuid;

class WishaGiftController extends Controller
{
    //private $router;


    /**
     * @Route("/update/{lastid}", name="update")
     * @param Request $request
     * @param int $lastid
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    public function update(Request $request, int $lastid)
    {
        //$giftlist = new GiftList();
        $em = $this->getDoctrine()->getManager();
        //$giftlist = new GiftList();
        //$lastGiftListId = $giftlist->getId();
        //var_dump($em->get);
        $product = $em->getRepository(GiftList::class)->find($lastid);
        $form = $this->createForm(GiftListType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {


            $data = $request->request->all();
            //$form->get('firstName')->submit('Fabien');
//var_dump($data['gift_list']['Gifts']);
            $giftNames = $data['gift_list']['Gifts'];
            foreach ($giftNames as $key => $giftName) {

                $gift = new Gift();
                $entityManager1 = $this->getDoctrine()->getManager();
                $gift->setUserId($lastid);
                $gift->setGift($giftName);
                $entityManager1->persist($gift);
                $entityManager1->flush();
            }

            // return $this->redirectToRoute('publiclist');
        }


         //var_dump($giftlist);
        //$product->setFirstName('New producddddt name!');
        //$em->persist($giftlist);
        $em->flush();
        return $em;
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function create(Request $request)
    {
       // $y = $this->router->generate(
           // 'create',
           // array('slug' => '123')
        //);
        //var_dump($uuid);
// $this->get('router')->generate('blog_show', array('slug' => 'my-blog-post'));
        //$uuid1 = Uuid::uuid1();

        //var_dump($uuid1->toString());
        //$routescontroller = new RoutesController();
        //$routescontroller->routes();
        //var_dump($routescontroller);
        $giftlist = new GiftList();






        $form = $this->createForm(GiftListType::class, $giftlist);
        $form->handleRequest($request);
//        /var_dump($form);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($giftlist);
            $entityManager->flush();

            $lastGiftListId = $giftlist->getId();



           /* $data = $request->request->all();
//var_dump($data['gift_list']['Gift']);
            $giftNames = $data['gift_list']['Gift'];
            foreach ($giftNames as $key => $giftName) {

                $gift = new Gift();
                $entityManager1 = $this->getDoctrine()->getManager();
                $gift->setUserId($lastGiftListId);
                $gift->setGift($giftName);
                $entityManager1->persist($gift);
                $entityManager1->flush();
            }*/

           // return $this->redirectToRoute('publiclist');
        }


        return $this->render('create/index.html.twig',
            ['form' => $form->createView(),
                'lastid' => 'update/'. $lastGiftListId
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

        //if (!$product) {
          //  throw $this->createNotFoundException(
               // 'No product found for id '.$id
           // );
        //}

        //return new Response('Name: '.$giftlist->getFirstname());
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

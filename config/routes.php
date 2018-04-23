<?php

namespace App\Controller;

//use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Ramsey\Uuid\Uuid;
//use Ramsey\Uuid\UuidInterface;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;

        //try {
        //$uuid4 = Uuid::uuid4();
       // $uuid = $uuid4->toString();
        //var_dump($uuid);
// $giftlist = new WishaGiftController();
//$giftlist->giftList($uuid);
//var_dump($giftlist);
//} catch (UnsatisfiedDependencyException $e) {

// Some dependency was not met. Either the method cannot be called on a
// 32-bit system, or it can, but it relies on Moontoast\Math to be present.
//echo 'Caught exception: ' . $e->getMessage() . "\n";

//}
        $routes = new RouteCollection();
        $routes->add('giftlist', new Route('/{slug}/{admin}', array(
            '_controller' => 'App\Controller\WishaGiftController::giftList',
        ), array(
            'slug' => 'giftlist',
            'admin' => '9544a316-460a-11e8-9700-0242ac120005',
        )));
//var_dump($routes);

        return $routes;

        //return $this->render('giftlist/index.html.twig', [
         //   'controller_name' => $routes,
        //]);

<?php

namespace App\Twig;


use App\Entity\Gift;
use App\Service\ReservedGiftCookieResolver;

class MainExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('isGiftReservedByMe', array($this, 'isGiftReservedByMe')),
        );
    }

    public function isGiftReservedByMe(Gift $gift, ?string $cookie): bool
    {
        return ReservedGiftCookieResolver::isReserved($cookie, $gift->getId(), $gift->getReservationToken(), $gift->getReservedAt());
    }
}
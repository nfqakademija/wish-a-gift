<?php

namespace App\Service;

use App\Controller\GiftListsController;
use Symfony\Component\HttpFoundation\Cookie;

class ReservedGiftCookieResolver
{
    public static function addGift(?string $cookieValue, $id, string $reserveToken): Cookie
    {
        $expireTime = time() + (365 * 24 * 60 * 60);

        if (null === $cookieValue) {
            $value = [$id => $reserveToken];

            return new Cookie(GiftListsController::RESERVED_GIFTS_COOKIE, json_encode($value), $expireTime);
        }

        $value = json_decode($cookieValue, true);

        if (!is_array($value)) {
            $value = [$id => $reserveToken];

            return new Cookie(GiftListsController::RESERVED_GIFTS_COOKIE, json_encode($value), $expireTime);
        }

        //var_dump($value);
        $value[$id] = $reserveToken;

        return new Cookie(GiftListsController::RESERVED_GIFTS_COOKIE, json_encode($value), $expireTime);
    }

    public static function removeGift(?string $cookieValue, $id): Cookie
    {
        // TODO
        return new Cookie(GiftListsController::RESERVED_GIFTS_COOKIE, json_encode($value));
    }

    public static function isReserved(?string $cookie, $id, string $reserveToken): bool
    {
        if (null === $cookie) {
            return false;
        }

        $value = json_decode($cookie, true);


        return isset($value[$id]) && $value[$id] === $reserveToken;
    }
}
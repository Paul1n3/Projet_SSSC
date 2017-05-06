<?php

namespace AssoSport\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AssoSportUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

<?php

use Symfony\Component\HttpFoundation\Session\Session;

class UserContext  extends FeatureContext
{
    public function __construct(Session $session)
    {
        $this->session = $session;
        $this->bundle = 'ProjectManagerUserBundle';
    }
}

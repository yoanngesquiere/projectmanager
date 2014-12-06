<?php

use Symfony\Component\HttpFoundation\Session\Session;

class ProjectContext extends FeatureContext
{
    public function __construct(Session $session)
    {
        $this->session = $session;
        $this->bundle = 'ProjectManagerProjectBundle';
    }
}

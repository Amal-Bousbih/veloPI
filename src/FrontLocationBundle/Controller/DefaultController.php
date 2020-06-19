<?php

namespace FrontLocationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrontLocationBundle:Default:index.html.twig');
    }
}

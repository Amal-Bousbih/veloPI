<?php

namespace BackLocationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BackLocationBundle:Default:index.html.twig');
    }
}

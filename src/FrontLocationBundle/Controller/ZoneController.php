<?php


namespace FrontLocationBundle\Controller;


use AppBundle\Entity\Velo;
use AppBundle\Entity\Zone;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ZoneController extends Controller
{
    public function afficherAction()
    {
        $zones_repo = $this->getDoctrine()->getRepository(Zone::class);
        $zones = $zones_repo->findAll();
        return $this->render("@FrontLocation/Default/afficher_zone.html.twig", array("zones" => $zones));
    }
}
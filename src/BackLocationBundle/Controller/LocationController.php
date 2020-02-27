<?php


namespace BackLocationBundle\Controller;

use AppBundle\Entity\Zone;
use AppBundle\Entity\Velo;
use AppBundle\Entity\Location;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LocationController extends Controller
{

    public function afficheAction(){
        $loca_repo = $this->getDoctrine()->getRepository(Location::class);
        $location = $loca_repo->findAll();
        return $this->render("@BackLocation/Default/affichage_location.html.twig", array("location" => $location));
    }
}
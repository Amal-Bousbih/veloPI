<?php


namespace FrontLocationBundle\Controller;


use AppBundle\Entity\Velo;
use AppBundle\Entity\Zone;
//use http\Env\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class VeloController extends Controller
{
    public function afficherAction($id)
    {
        $zone_repo = $this->getDoctrine()->getRepository(Zone::class);
        $zone = $zone_repo->find($id);
        $velo_repo = $this->getDoctrine()->getRepository(Velo::class);
        $velos = $velo_repo->findBy(array("zone" => $zone));

        $this ->getDoctrine()
            ->getEntityManager()
            ->getRepository(Velo::class)
            ->findBy(array(), array('debutservice' => 'desc'));

        return $this->render("@FrontLocation/Default/afficher_velo.html.twig", array("velos" => $velos));
    }

   public function rechercherAction(
       Request $request){

        $em=$this->getDoctrine()->getManager();
        $find=$em->getRepository(Velo::class)->findAll();
        if ($request->isMethod('POST')){
            $type=$request->get('type');
            $find=$em->getRepository(Velo::class)->findBy(array('type'=>$type));
        }
       return $this->render("@FrontLocation/Default/afficher_velo.html.twig", array("type" => $type));
   }



    
   
}
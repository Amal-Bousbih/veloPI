<?php


namespace BackLocationBundle\Controller;

use AppBundle\Entity\Zone;
use AppBundle\Entity\Velo;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class VeloController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $zones_repo = $this->getDoctrine()->getRepository(Zone::class);
        $em = $this->getDoctrine()->getManager();
        $zones = $zones_repo->findAll();
        if ($request->isMethod("POST")) {
            $zone_id = $request->get("zone");
            $zone = $zones_repo->find($zone_id);
            $velo = new Velo();
            $velo->setNom($request->get("nom"));
            $time = strtotime($request->get('debutservice'));
            $newformat = date('Y-m-d', $time);
            try {
                $velo->setDebutservice(new \DateTime($newformat));
            } catch (\Exception $e) {
            }
            $velo->setType($request->get("type"));
            $velo->setDisponible($request->get("disponible"));
            $velo->setZone($zone);
            $em->persist($velo);
            $em->flush();
            $velo->setZone($zone);
            $em->persist($velo);
            $em->flush();
            $locati=$em->getRepository(Zone::class)->find($velo->getZone()->getId());
            $locati->setStock(
                ($locati->getStock())+1);
            $em->flush();

        }
        return $this->render("@BackLocation/Default/ajouter_velo.html.twig", array("zones" => $zones));
    }

    public function afficherAction()
    {
        $velo_repo = $this->getDoctrine()->getRepository(Velo::class);
        $velos = $velo_repo->findAll();
        return $this->render("@BackLocation/Default/afficher_velos.html.twig", array("velos" => $velos));
    }

    public function update2Action($idz, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $velos = $em->getRepository(Velo::class)->find($idz);
        $zones_repo = $this->getDoctrine()->getRepository(Zone::class);
        $em = $this->getDoctrine()->getManager();
        $zones = $zones_repo->findAll();
        if ($request->isMethod("POST")) {

            $zone_id = $request->get("zone");
            $zone = $zones_repo->find($zone_id);
            $velos->getId($idz);


            $time = strtotime($request->get('debutservice'));
            $newformat = date('Y-m-d', $time);
            try {
                $velos->setDebutservice(new \DateTime($newformat));
            } catch (\Exception $e) {
            }
            $velos->setNom($request->get("nom"));
            $velos->setType($request->get("type"));
            $velos->setDisponible($request->get("disponible"));
            $velos->setZone($zone);
            $em->merge($velos);
            $em->flush();
            return $this->redirectToRoute('back_location_afficher_velos');

        }
        return $this->render('@BackLocation/Default/update_velo.html.twig', array('velos' => $velos, "zones" => $zones));

    }

    public function indexAction(){
        return $this->render('@BackLocation/Default/calendar.html.twig');
    }
}
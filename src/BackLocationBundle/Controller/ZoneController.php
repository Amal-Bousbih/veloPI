<?php


namespace BackLocationBundle\Controller;


use AppBundle\Entity\Velo;
use AppBundle\Entity\Zone;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ZoneController extends Controller
{
    public function zoneAction($id,Request $request)
    {
        if ($request->isMethod("POST"))
        {
            $nom = $request->get("nom");
            $stock = $request->get("stock");
            $zone = new Zone();
            $zone->setNom($nom);
            $zone->setStock($stock);
            $em = $this->getDoctrine()->getManager();
            $em->persist($zone);
            $em->flush();

        }
        return $this->render("@BackLocation/Default/ajouter_zone.html.twig");
    }

    public function afficherAction()
    {
        $zones_repo = $this->getDoctrine()->getRepository(Zone::class);
        $zones = $zones_repo->findAll();
        return $this->render("@BackLocation/Default/afficher_zones.html.twig", array("zones" => $zones));
    }

    public function updateAction(Request $request , $id)
    {

        $em = $this->getDoctrine()->getManager();
        $zones = $em->getRepository(Zone::class)->find($id);
        if ($request->isMethod("POST"))
        {
            $zones->setNom($request->get("nom"));
            $zones->setStock($request->get("stock"));
            $em->merge($zones);
            $em->flush();
            return $this->redirectToRoute('back_location_afficher_zones');
        }
        return $this->render('@BackLocation/Default/update.html.twig', array('zones' => $zones));

    }

    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $zon=$em->getRepository(Zone::class)->find($id);
        $em->remove($zon);
        $em->flush();
        return $this->redirectToRoute('back_location_afficher_zones');

    }
}
<?php


namespace LocationBundle\Controller;

use AppBundle\Entity\Location;
use AppBundle\Entity\Zone;
use AppBundle\Entity\Velo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\LocationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \DateTime;


class LocationController extends Controller
{


    public function formulaireAction($id,$idz,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $zone = $em->getRepository(Zone::class)->find($id);
        $velo = $em->getRepository(Velo::class)->find($idz);


        if ($request->isMethod('POST')) {
            $location = new Location();
            $time = strtotime($request->get('datedebut'));
            $newformat = date('Y-m-d', $time);
            try {
                $location->setDatedebut(new \DateTime($newformat));
            } catch (\Exception $e) {
            }
            $time = strtotime($request->get('datefin'));
            $newformat = date('Y-m-d', $time);
            try {
                $location->setDatefin(new \DateTime($newformat));
            } catch (\Exception $e) {
            }

                if ($location->getDatedebut() > $location->getDatefin()) {
                    
                } else {
                    $location->setZone($zone);
                    $location->setVelo($velo);
                    //$location->setDatedebut(0);
                    $em->persist($location);
                    $em->flush();


            $locations=$em->getRepository(Velo::class)->find($location->getVelo()->getId($idz));
            $locations->setDisponible(
                $locations->getDisponible());
            if ($locations->getDisponible()==0) {

                echo ('Formulaire enregistrer');
            }else {
                echo ('le vélo est non disponible');
            }
                }

            $locatio=$em->getRepository(Zone::class)->find($location->getZone()->getId($id));
            $locatio->setStock(
                ($locatio->getStock())-1);
            $em->flush();
            $locati=$em->getRepository(Velo::class)->find($location->getVelo()->getId($idz));
            $locati->setDisponible(
                ($locati->getDisponible())+1);
            $em->flush();
        }

        return $this->render('@Location/Default/formulaire.html.twig');


    }

}
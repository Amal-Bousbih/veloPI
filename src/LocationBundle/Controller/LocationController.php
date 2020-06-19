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

    /**
     * Adds a flash message to the current session for type.
     *
     * @param string $type The type
     * @param string $message The message
     *
     * @return void
     * @throws \LogicException
     */

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

                    $this->addFlash('info', 'Date Debut doit etre inferieur a la date fin!');

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

                $this->addFlash('info', 'Formulaire Ajouté!');

            }else {

                $this->addFlash('info', 'Le Vélo Non disponible!');
            }
                }

            $locatio=$em->getRepository(Zone::class)->find($zone->getId($id));
            $locatio->setStock(
                ($locatio->getStock())-1);
            $em->flush();
            $locati=$em->getRepository(Velo::class)->find($velo->getId($idz));
            $locati->setDisponible(
                ($locati->getDisponible())-1);
            $em->flush();
        }

        return $this->render('@Location/Default/formulaire.html.twig');


    }

}
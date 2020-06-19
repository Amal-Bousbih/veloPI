<?php

namespace EspritApiBundle\Controller;


use AppBundle\Entity\Location;
use AppBundle\Entity\User;
use AppBundle\Entity\Velo;
use AppBundle\Entity\Zone;
use EspritApiBundle\Entity\Task;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class TaskControllerController extends Controller
{
    public function allAction (){
        $tasks = $this->getDoctrine()->getManager()->getRepository(Zone::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function findAction($id){
        $tasks = $this->getDoctrine()->getManager()->getRepository(Task::class)->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function newAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $zone = new Zone();
        $zone->setNom($request->get('nom'));
        $zone->setStock($request->get('stock'));
        $em->persist($zone);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($zone);
        return new JsonResponse($formatted);

    }
    public function ListVeloAction (){
        $vel = $this->getDoctrine()->getManager()->getRepository('AppBundle:Velo')->findAll();
        $vl1 = $this->getDoctrine()->getManager()->getRepository('AppBundle:Zone');
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($vel);
        return new JsonResponse($formatted);
    }

        public function AfficherLocationAction (){
        $tasks = $this->getDoctrine()->getManager()->getRepository(Location::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function AjoutVeloAction(Request $request){
        $zones_repo = $this->getDoctrine()->getRepository(Zone::class);
        $em = $this->getDoctrine()->getManager();
        $zones = $zones_repo->findAll();

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
            $velo->setPrix($request->get('prix'));
            $em->persist($velo);
            $em->flush();
            //$velo->setZone($zone);
            $em->persist($velo);
            $em->flush();

            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($velo);
            return new JsonResponse($formatted);

    }

    public function AddLocationAction(Request $request){
        $em = $this->getDoctrine()->getManager();
       $zones_repo = $em->getRepository(Zone::class);
        $zones = $zones_repo->findAll();
        $velo_1 = $em->getRepository(Velo::class);
        $velos = $velo_1->findAll();

        $zone_id = $request->get("zone");
        $zone = $zones_repo->find($zone_id);
        $velo_id = $request->get("velo");
        $velo = $velo_1 ->find($velo_id);

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


        $location->setZone($zone);
        $location->setVelo($velo);


        $em->persist($location);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($location);
        return new JsonResponse($formatted);
        }

    public function loginuserAction(Request $request)
    {
        $username = $request->get('username');
        $user = $this->getDoctrine()->getManager()
            ->getRepository(User::class)
            ->findOneBy(array("usernameCanonical"=>$username));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    public function ListUserAction (){
        $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    public function updateUserAction( Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('id'));

        $user->setremember($request->get("remember"));
        $em->persist($user);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);

    }
    public function getuserfromidAction($username,Request $request)
    {
        $user_repo = $this->getDoctrine()->getRepository(User::class);
        $user = $user_repo->findBy(array('username' => $username));


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    public function getidfromZoneAction($nom,Request $request)
    {
        $zone_repo = $this->getDoctrine()->getRepository(Zone::class);
        $zone1 = $zone_repo->findBy(array('nom' => $nom));


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($zone1);
        return new JsonResponse($formatted);
    }

    public function getidfromVeloAction($nom,Request $request)
    {
        $velo_repo = $this->getDoctrine()->getRepository(Velo::class);
        $velo1 = $velo_repo->findBy(array('nom' => $nom));


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($velo1);
        return new JsonResponse($formatted);
    }

    public function getVelofromZoneAction($zone,Request $request)
    {
        $velo_repo = $this->getDoctrine()->getRepository(Velo::class);
        $velo1 = $velo_repo->findBy(array('zone' => $zone));


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($velo1);
        return new JsonResponse($formatted);
    }

    public function getidfromZone2Action($nom,Request $request)
    {
        $zone_repo = $this->getDoctrine()->getRepository(Zone::class);
        $zone1 = $zone_repo->findBy(array('nom' => $nom));


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($zone1);
        return new JsonResponse($formatted);
    }

    public function ShowMobileSingleAction($idz,Request $request)
    {
        $velo = $this->getDoctrine()->getRepository(Velo::class)->find($idz);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($velo);
        return new JsonResponse($formatted);



    }


}

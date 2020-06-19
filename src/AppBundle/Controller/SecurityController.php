<?php


namespace AppBundle\Controller;
use AppBundle\Entity\Velo;
use AppBundle\Entity\Zone;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    /**
     * @Route("/")
     */
    public function redirectAction()
    {
        $authChecker = $this->container->get('security.authorization_checker');
        if($authChecker->isGranted('ROLE_ADMIN')){
            return $this->render('@BackLocation/Default/afficher_zones.html.twig');

        }else if($authChecker->isGranted('ROLE_USER')) {
            return $this->render('@FrontLocation/Default/afficher_zone.html.twig');
        }else {
                return $this->render('@FOSUser/Security/login.html.twig');
            }
        }

}
<?php


namespace BackLocationBundle\Controller;

use AppBundle\Entity\Velo;
use AppBundle\Entity\Zone;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use AppBundle\Entity\Location;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatController extends Controller
{
    public function StatAction()
    {
        $pieChart = new PieChart();
        $em = $this->getDoctrine()->getManager();
        $classes = $em->getRepository(Zone::class)->findAll();
        $totalstock = 0;
        foreach ($classes as $class) {
            $totalstock = $totalstock + $class->getStock();
        }
        $data = array();
        $stat = ['zone', 'nom'];
        $nb = 0;
        array_push($data, $stat);
        foreach ($classes as $classe) {
            $stat = array();
            array_push($stat, $classe->getNom(), (($classe->getStock()) * 100) / $totalstock);
            $nb = ($classe->getStock() * 100) / $totalstock;
            $stat = [$classe->getNom(), $nb];
            array_push($data, $stat);
        }
        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('Pourcentages des Zone par Quantité de Stock ');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        return $this->render('@BackLocation/Default/Stat.html.twig', array('piechart' =>
            $pieChart));
    }
}
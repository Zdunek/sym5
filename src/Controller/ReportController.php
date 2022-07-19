<?php

namespace App\Controller;

use App\Entity\Export;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class ReportController extends AbstractController
{

    /**
     * @Route("/", name="app_report")
     */
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $local = $request->query->get('local', 'Brak');
        $dateFrom = $request->query->get('dateFrom',null);
        $dateTo = $request->query->get('dateTo', null);
        $entityManager = $doctrine->getManager();
        $dateFromVal = null;
        $dateToVal = null;
        if($dateFrom !== null) {
            $dateFromVal =new \DateTime('@'.strtotime($dateFrom));
        }
        if($dateTo !== null) {
            $dateToVal =new \DateTime('@'.strtotime($dateTo));
        }
        $localsDB = $entityManager
            ->getRepository(Export::class)
        ;
        $locals = $localsDB->createQueryBuilder('p')
            ->groupBy('p.local_name')
            ->select('p.local_name')
            ->getQuery()
            ->getResult()
            ;
        $func = function(array $value): string {
            return $value['local_name'];
        };
        $locals = array_map($func, $locals);
        array_unshift($locals, 'Brak');
        $locals = array_combine($locals, $locals);
        $form = $this->createFormBuilder()
            ->add('local', ChoiceType::class, array("label" => "Lokal:", 'choices' => $locals, 'data' => $local))
            ->add('datetimeFrom', DateType::class, array("label" => "Od:", 'widget'=>'single_text', 'data' => $dateFromVal))
            ->add('datetimeTo', DateType::class, array("label" => "Do:", 'widget'=>'single_text', 'data' => $dateToVal))
            ->getForm()
            ->createView()
        ;


        // search
        $exports = $entityManager
            ->getRepository(Export::class)->createQueryBuilder('p');
        if($local != 'Brak'){
            $exports
                ->andWhere('p.local_name = :local_name')
                ->setParameter('local_name', $local)
            ;
        }
        if($dateFrom != null){
            $exports
                ->andWhere('p.export_datetime > :dateFrom')
                ->setParameter('dateFrom', $dateFrom)
            ;
        }
        if($dateTo != null){
            $exports
                ->andWhere('p.export_datetime < :dateTo')
                ->setParameter('dateTo', $dateTo)
            ;
        }
        $exports = $exports->getQuery()->getResult();


        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
            'exports' => $exports,
            'form' => $form,
        ]);
    }
}

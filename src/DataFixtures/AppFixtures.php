<?php

namespace App\DataFixtures;

use App\Entity\Export;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $generator = Factory::create("pl_PL");
        for ($i = 0; $i < 50; $i++) {

            $export = new Export();
            $export->setExportName('Raport  '.$i);
            $export->setExportDatetime($generator->dateTimeThisYear($max = 'now', $timezone = null));
            $export->setUserName($generator->userName);
            $export->setLocalName($generator->streetName);
            $manager->persist($export);
        }
        $manager->flush();
    }
}

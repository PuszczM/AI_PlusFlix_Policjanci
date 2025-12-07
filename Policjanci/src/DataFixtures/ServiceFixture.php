<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $services = [
            ['apple', 'Apple TV+', '/img/service/apple.png'],
            ['disney', 'Disney Plus', '/img/service/disney.png'],
            ['hbo', 'HBO Max', '/img/service/hbo.png'],
            ['netflix', 'Netflix', '/img/service/netflix.png'],
            ['prime', 'Prime Video', '/img/service/prime.png'],
            ['skyshowtime', 'SkyShowtime', '/img/service/skyshowtime.png'],
        ];

        foreach ($services as [$shortName, $fullName, $logoPath]) {
            $service = new Service();
            $service->setShortName($shortName)
                ->setFullName($fullName)
                ->setLogoPath($logoPath);
            $manager->persist($service);

            $this->addReference('service_'.$shortName, $service);
        }

        $manager->flush();
    }
}

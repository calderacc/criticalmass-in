<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Criticalmass\CitySlug\Handler\CitySlugHandler;
use App\Entity\City;
use App\Entity\Ride;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RideFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist($this->createRide('hamburg', new \DateTime('2011-06-24 19:00:00'), null, 53.5, 10.5));
        $manager->persist($this->createRide('hamburg', new \DateTime('2011-06-25 19:00:00'), null, 53.5, 10.5));
        $manager->persist($this->createRide('hamburg', new \DateTime('2011-06-26 19:00:00'), null, 53.5, 10.5));
        $manager->persist($this->createRide('hamburg', new \DateTime('2011-06-27 19:00:00'), null, 53.5, 10.5));
        $manager->persist($this->createRide('hamburg', new \DateTime('2011-06-28 19:00:00'), null, 53.5, 10.5));
        $manager->persist($this->createRide('hamburg', new \DateTime('2011-06-29 19:00:00'), null, 53.5, 10.5));
        $manager->persist($this->createRide('hamburg', new \DateTime('2011-06-30 19:00:00'), null, 53.5, 10.5));
        $manager->persist($this->createRide('hamburg', new \DateTime('2050-09-24 19:00:00'), null, 53.5, 10.5));
        $manager->persist($this->createRide('hamburg', new \DateTime('2035-06-24 19:00:00'), 'kidical-mass-hamburg-2035', 53.5, 10.5));
        $manager->persist($this->createRide('hamburg', new \DateTime('2011-03-25 19:00:00'), null, 53.5, 10.5));
        $manager->persist($this->createRide('hamburg', new \DateTime('2011-06-24 19:00:00'), null, 53.5, 10.5));
        $manager->persist($this->createRide('hamburg', new \DateTime('2011-07-29 19:00:00'), null, 53.5, 10.5));

        $manager->flush();
    }

    protected function createRide(string $citySlug, \DateTime $dateTime, string $rideSlug = null, float $latitude, float $longitude): Ride
    {
        $ride = new Ride();
        $ride
            ->setCity($this->getReference(sprintf('city-%s', $citySlug)))
            ->setTitle(sprintf('Critical Mass %s', $dateTime->format('d.m.Y')))
            ->setDateTime($dateTime)
            ->setSlug($rideSlug)
            ->setLatitude($latitude)
            ->setLongitude($longitude);

        $this->setReference(sprintf('ride-%s-%d', $citySlug, $dateTime->format('U')), $ride);

        return $ride;
    }

    public function getDependencies(): array
    {
        return [
            CityFixtures::class,
        ];
    }
}

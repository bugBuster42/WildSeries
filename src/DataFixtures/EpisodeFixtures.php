<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();


        for ($i = 0; $i < 550; $i++) {
            $newEpisode = new Episode();
            $newEpisode->setNumber(($i % 10) + 1);
            $newEpisode->setTitle($faker->sentence(3));
            $newEpisode->setSynopsis($faker->paragraphs(3, true));
            $newEpisode->setSeason($this->getReference('season_' . $i % 55));
            $manager->persist($newEpisode);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}

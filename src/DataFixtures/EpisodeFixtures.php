<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Episode;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();


        for ($i = 0; $i < 550; $i++) {
            $newEpisode = new Episode();
            $slug = $this->slugger->slug($faker->sentence(3));
            $newEpisode->setNumber(($i % 10) + 1);
            $newEpisode->setSlug($slug);
            $newEpisode->setTitle($faker->sentence(3));
            $newEpisode->setSynopsis($faker->paragraphs(3, true));
            $newEpisode->setSeason($this->getReference('season_' . $i % 55));
            $newEpisode->setDuration($faker->numberBetween(10, 60));
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

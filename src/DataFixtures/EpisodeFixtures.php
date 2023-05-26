<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $episodes = [
            [
                'title' => 'Descenso',
                'number' => '1',
                'synopsis' => 'Chilean drug chemist Cockroach brings his product to Colombian smuggler Pablo Escobar. DEA agent Steve Murphy joins the war on drugs in Bogota.',
                'season' => '1',
            ],
            [
                'title' => 'The Sword of Simón Bolivar',
                'number' => '2',
                'synopsis' => 'Communist radical group M-19 makes a move against the narcos, while Murphy gets an education in Colombian law enforcement from his new partner Peña.',
                'season' => '1',
            ],
            [
                'title' => 'The Men of Always',
                'number' => '3',
                'synopsis' => 'Murphy encounters the depths of government corruption when he and Peña try to derail Escobar\'s political ambitions by proving he\'s a narco.',
                'season' => '1',
            ],
            [
                'title' => 'Free at Last',
                'number' => '1',
                'synopsis' => 'In the aftermath of a massive military effort to take Pablo into custody, the family reunites while enemies worry. Steve and Connie fight about safety.',
                'season' => '2',
            ],
            [
                'title' => 'Cambalache',
                'number' => '2',
                'synopsis' => 'Tata gets impatient with life on the run. Pablo responds to President Gaviria\'s reward offer. Steve and Javier meet their new boss.',
                'season' => '2',
            ],
            [
                'title' => 'Our Man in Madrid',
                'number' => '3',
                'synopsis' => 'President Gaviria has a new job for an old colleague. The Search Bloc\'s new tactics shake up Pablo, but also unsettle Steve and Javier.',
                'season' => '2',
            ],

        ];


        foreach ($episodes as $episode) {
            $newEpisode = new Episode();
            $newEpisode->setNumber($episode['number']);
            $newEpisode->setTitle($episode['title']);
            $newEpisode->setSynopsis($episode['synopsis']);
            $newEpisode->setSeason($this->getReference('season_' . $episode['season']));
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

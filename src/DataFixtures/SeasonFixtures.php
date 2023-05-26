<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $seasons = [
            [
                'number' => '1',
                'year' => '2O15',
                'description' => 'Dans les années 1980, Pablo Escobar, un petit contrebandier colombien, décide de se lancer dans la production et l\'exportation de cocaïne dont la rentabilité va lui permettre de fonder le puissant Cartel de Medellin.',
                'program' => 'program_Narcos',
            ],
            [
                'number' => '2',
                'year' => '2O16',
                'description' => 'Après son évasion de la prison, la Cathédrale, Pablo Escobar et sa famille deviennent des fugitifs permanents. Le narco trafiquant continue pourtant ses affaires. Les forces de police, toujours avec Javier Peña et Steve Murphy, le traquent sans relâche. Mais de nouveaux éléments entrent en jeu.',
                'program' => 'program_Narcos',
            ],
        ];



        foreach ($seasons as $season) {
            $newSeason = new Season();
            $newSeason->setNumber($season['number']);
            $newSeason->setYear($season['year']);
            $newSeason->setDescription($season['description']);
            $newSeason->setProgram($this->getReference($season['program']));
            $manager->persist($newSeason);
            $this->addReference('season_' . $season['number'], $newSeason);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}

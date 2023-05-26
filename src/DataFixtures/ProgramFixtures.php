<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $programs = [
            [
                'title' => 'Walking Dead',
                'synopsis' => 'Des zombies envahissent la terre',
                'category' => 'category_Action',
                'country' => 'England',
                'year' => '2020',
            ],
            [
                'title' => 'The Recruit',
                'synopsis' => 'D\'avocat à la CIA à espion international',
                'category' => 'category_Action',
                'country' => 'USA',
                'year' => '2023',
            ],
            [
                'title' => 'Lupin',
                'synopsis' => 'Le gentleman cambrioleur se venge d\'une injustice famillale',
                'category' => 'category_Action',
                'country' => 'France',
                'year' => '2022',
            ],
            [
                'title' => 'Narcos',
                'synopsis' => 'Histoire du célébre narcotrafiquant de Medellin',
                'category' => 'category_Aventure',
                'country' => 'USA',
                'year' => '2015',
            ],
            [
                'title' => 'La Casa de Papel',
                'synopsis' => 'Un génie et 8 voleurs font le braquage du siècle',
                'category' => 'category_Aventure',
                'country' => 'Spain',
                'year' => '2020',
            ],
            [
                'title' => 'Squid Game',
                'synopsis' => 'Un jeu impitoyable pour rembourser ses dettes',
                'category' => 'category_Aventure',
                'country' => 'Korea',
                'year' => '2021',
            ],
            [
                'title' => 'Naruto',
                'synopsis' => 'Un orphelin qui veut devenir ninja',
                'category' => 'category_Animation',
                'country' => 'Japan',
                'year' => '2015',
            ],
            [
                'title' => 'Tokyo Ghoul',
                'synopsis' => 'Invasion de créatures amatrices de chair fraiche à l\'apparence humaine',
                'category' => 'category_Animation',
                'country' => 'Japan',
                'year' => '2020',
            ],
            [
                'title' => 'Cobra',
                'synopsis' => 'Aventurier au trésor armé de son bras laser et de sa coequipiere androide',
                'category' => 'category_Animation',
                'country' => 'Japan',
                'year' => '1980',
            ],
            [
                'title' => 'The Walking Dead',
                'synopsis' => 'Un monde apocalyptique sous l\'emprise des Zombies',
                'category' => 'category_Horreur',
                'country' => 'USA',
                'year' => '2020',
            ],
            [
                'title' => 'Stranger Things',
                'synopsis' => 'Des experiences secretes, des forces surnaturelles, et une fillette',
                'category' => 'category_Fantastique',
                'country' => 'USA',
                'year' => '2021',
            ],
        ];

        foreach ($programs as $key => $program) {
            $newProgram = new Program();
            $newProgram->setTitle($program['title']);
            $newProgram->setSynopsis($program['synopsis']);
            $newProgram->setCountry($program['country']);
            $newProgram->setYear($program['year']);
            $newProgram->setCategory($this->getReference($program['category']));
            $manager->persist($newProgram);
            $this->addReference('program_' . $key, $newProgram);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}

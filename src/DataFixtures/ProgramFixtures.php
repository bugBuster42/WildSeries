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
            ],
            [
                'title' => 'Narcos',
                'synopsis' => 'Histoire du célébre narcotrafiquant de Medellin',
                'category' => 'category_Aventure',
            ],
            [
                'title' => 'Naruto',
                'synopsis' => 'Un orphelin qui veut devenir ninja',
                'category' => 'category_Animation',
            ],
            [
                'title' => 'The Walking Dead',
                'synopsis' => 'Un monde apocalyptique sous l\'emprise des Zombies',
                'category' => 'category_Horreur',
            ],
            [
                'title' => 'Stranger Things',
                'synopsis' => 'Des experiences secretes, des forces surnaturelles, et une fillette',
                'category' => 'category_Fantastique',
            ],
        ];

        foreach ($programs as $program) {
            $newProgram = new Program();
            $newProgram->setTitle($program['title']);
            $newProgram->setSynopsis($program['synopsis']);
            $newProgram->setCategory($this->getReference($program['category']));
            $manager->persist($newProgram);
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

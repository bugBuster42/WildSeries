<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Actor;
use App\Entity\Program;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const NUM_ACTORS = 10;
    const NUM_PROGRAMS_PER_ACTOR = 3;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $programs = $manager->getRepository(Program::class)->findAll();

        for ($i = 0; $i < self::NUM_ACTORS; $i++) {
            $newActor = new Actor();
            $newActor->setName($faker->lastName());

            $randomPrograms = $faker->randomElements($programs, self::NUM_PROGRAMS_PER_ACTOR);

            foreach ($randomPrograms as $program) {
                $newActor->addProgram($program);
            }

            $manager->persist($newActor);
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

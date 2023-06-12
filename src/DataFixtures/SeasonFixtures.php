<?php

namespace App\DataFixtures;

use App\Entity\Season;
use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)

    {
        $faker = Factory::create();

        $programs = $manager->getRepository(Program::class)->findAll();

        foreach ($programs as $program) {
            $referenceIndex = 0;
            for ($i = 0; $i < 5; $i++) {
                $season = new Season();
                $season->setNumber($faker->numberBetween(1, 5));
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraphs(3, true));
                $season->setProgram($program);
                $this->setReference('saison_' . $referenceIndex++, $season);

                $manager->persist($season);
            }
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

<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMS = [
        ['Walking dead', 'Des zombies envahissent la terre', 'category_Action'],
        ['Superman', 'Un super héros sauve la terre', 'category_Action'],
        ['Le visage d\'alex', 'Un meurtrier fait des ravages', 'category_Horreur'],
        ['Brice de Joss', 'Il souhaite devenir surfeur', 'category_Fantastique'],
        ['JF', 'Un super-héros qui sauve des wilders', 'category_Thrillers']
    ];

    public function load(ObjectManager $manager)
    
    {
        foreach (self::PROGRAMS as list($v1, $v2, $v3)) {
            $program = new Program();
            $program->setTitle($v1);
            $program->setSynopsis($v2);
            $program->setCategory($this->getReference($v3));
            $manager->persist($program);
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


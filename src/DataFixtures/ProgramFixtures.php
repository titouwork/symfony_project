<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMS = [
        ['Walking dead', 'Des zombies envahissent la terre', 'category_Action', 'US', 2012 ],
        ['Superman', 'Un super héros sauve la terre', 'category_Action', 'US', 2002],
        ['Le visage d\'alex', 'Un meurtrier fait des ravages', 'category_Horreur', 'FR', 1986],
        ['Brice de Joss', 'Il souhaite devenir surfeur', 'category_Fantastique', 'FR', 1993],
        ['JF', 'Un super-héros qui sauve des wilders', 'category_Thrillers', 'FR', 2023],
        ['Shrek', 'Un ogre et ses aventures', 'category_Animation', 'FR', 2009]
    ];

    public function load(ObjectManager $manager)
    
    {   
        $i = 0;
        foreach (self::PROGRAMS as list($v1, $v2, $v3, $v4, $v5)) {
            $program = new Program();
            $program->setTitle($v1);
            $program->setSynopsis($v2);
            $program->setCategory($this->getReference($v3));
            $program->setCountry($v4);
            $program->setYear($v5);
            $this->setReference('program_' . $i++, $program);
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


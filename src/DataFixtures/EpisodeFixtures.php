<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Random\Engine\Secure;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {   
        $faker = Factory::create();
        $numbersEpisode= 0;
        $seasons = $manager->getRepository(Season::class)->findAll();

        foreach ($seasons as $season){
        for ($i=0; $i<10; $i++) {
            $episode = new Episode();
            $episode->setTitle( $faker->text(10));
            $episode->setNumber($numbersEpisode++);
            $episode->setSynopsis($faker->paragraphs(3, true));
            $episode->setSeason($season);
            $manager->persist($episode);
        }
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

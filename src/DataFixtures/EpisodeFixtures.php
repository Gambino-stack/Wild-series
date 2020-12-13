<?php

namespace App\DataFixtures;


use App\Service\Slugify;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr-Fr');

        for ($i = 0; $i < 80; $i++) {
            $episode = new Episode();
            $episode->setNumber($faker->numberBetween(1,100));
            $episode->setTitle($faker->sentence);
            $episode->setSynopsis($faker->text(100));
            $episode->setSeasonId($this->getReference('season_' . rand(0,14)));
            $slug = $this->slugify->generate($episode->getTitle());
            $episode->setSlug($slug);
            $manager->persist($episode);
            $this->addReference('episode_' . $i, $episode);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}

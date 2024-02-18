<?php
namespace App\DataFixtures;

use App\Entity\Anime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager as ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture 
{
    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i < 49 ; $i ++){
        $anime = new Anime();
        $anime->setName( $this->faker->word());
        $anime->setEpisodes(mt_rand(1, 1000));
        $anime->setGenre('Shonen');
        $anime->setPeriod(mt_rand(1970, 2024));
        $manager->persist($anime);
        $manager->flush();
    }
    }
}
<?php
namespace App\DataFixtures;

use App\Entity\Anime;
use App\Entity\Genre;
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
    { //Animes
        $animes = [];
        for($i = 0; $i < 50 ; $i ++){
        $anime = new Anime();
        $anime->setName( $this->faker->word());
        $anime->setEpisodes(mt_rand(1, 1300));
        $anime->setPeriod(mt_rand(1970, 2024));

        $animes[] = $anime;
        $manager->persist($anime);
    }
    // Catégories
    for($j = 0; $j < 6 ; $j ++){
        $genre = new Genre ();
        $genre->setName( $this->faker->word());
        $genre->setDescription($this->faker->text(240));
        for($k = 0; $k < mt_rand(5, 35); $k ++){ 
            $genre->addAnime($animes[mt_rand(1, count($animes) -1)]);
        }

        $manager->persist($genre);
       
    } 
    $manager->flush();
    }
}
<?php
namespace App\DataFixtures;

use App\Entity\Anime;
use App\Entity\Category;
use App\Repository\Anime\AnimeRepository as AnimeAnimeRepository;
use App\Repository\AnimeRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager as ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture 
{
    private Generator $faker;

    public function __construct( private AnimeRepository $animeRepository, private UserRepository $userRepository)
    {
        
    }
    public function load(ObjectManager $manager): void
    { 
        $this->faker = Factory::create('fr_FR');
        

 // Catégories
        $categories = [];  
        for($j = 0; $j < 5 ; $j ++){
        $category = new Category ();
        $category->setName( $this->faker->word())
                ->setDescription($this->faker->paragraph());
                
        $categories[] = $category; 
        $manager->persist($category);
   
   }
 
 

            //Animes
            $animes = [];
            for($i = 0; $i < 50 ; $i ++){
            $anime = new Anime();
            $anime  ->setName( $this->faker->word())
                ->setEpisodes(mt_rand(1, 1300))
                ->setPeriod(mt_rand(1970, 2024))
                ->setCategory($categories[mt_rand(0, count($categories) - 1) ]);
                
            
            $animes[] = $anime;
            $manager->persist($anime);
            
            
    
            
        }
       

        $manager->flush();
    }
}
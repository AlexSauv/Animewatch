<?php
namespace App\DataFixtures;

use App\Entity\Note;
use App\Entity\User;
use App\Entity\WatchList;
use App\Entity\Anime;
use App\Entity\Category;
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
                ->setDescription($this->faker->paragraph())
                ->setImage($this->faker->imageUrl());
               
                
        $categories[] = $category; 
        $manager->persist($category);
   
   }
 
 

            //Animes
            $animes = [];
            for($i = 0; $i < 100 ; $i ++){
            $anime = new Anime();
            $anime  ->setName( $this->faker->word())
                ->setEpisodes(mt_rand(1, 1300))
                ->setPeriod(mt_rand(1970, 2024))
                ->setDescription($this->faker->text())
                ->setCategory($categories[mt_rand(0, count($categories) - 1) ])
                ->setImage($this->faker->imageUrl());
                
            
            $animes[] = $anime;
            $manager->persist($anime);
            
            }

          
        
         
                
            // WatchLists
            $watchlists = [];  
            for($a = 0; $a < 20 ; $a ++){
            $watchlist = new WatchList();
 
            $manager->persist($watchlist);
            $watchlists[] = $watchlist;
            }
            
            foreach ($watchlists as $watchlist) {
                for ($b=0; $b < mt_rand(1, 10); $b ++){ 
                $watchlist->addAnime($animes[mt_rand(0, count($animes) - 1)]);
              
                }}
                    
                
        
            
            
            
                      // User
                      $users = [];
                      for($j = 0; $j < 100 ; $j ++){
                      $user = new User();
                      $user->setFullName( $this->faker->name())
                      ->setPseudo(mt_rand(0, 1) === 1 ? $this->faker->firstName() : null)
                      ->setEmail($this->faker->email())
                      ->setRoles(['ROLE_USER'])
                      ->setPlainPassword('password')
                      ->setWatchList($watchlists[mt_rand(0,count($watchlists) - 1)]);
                      $users[] = $user;
              
              
                      $manager->persist($user);   
                  }
        
                foreach ($animes as $anime) {
                    for ($i=0; $i < mt_rand(1, 4); $i++) { 
                        $note = new Note();
                        $note->setNote(mt_rand(1,5))
                        ->setUser($users[mt_rand(0,count($users) - 1)])
                        ->setAnime($anime);

                        $manager->persist($note);
                    }
               
                }
       

        $manager->flush();
    }
}
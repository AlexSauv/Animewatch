<?php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\WatchList;
use App\Repository\AnimeRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager as ObjectManager;
use Faker\Factory;
use Faker\Generator;

class WatchlistFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct( private AnimeRepository $animeRepository, private UserRepository $userRepository)
    {
        
    }
    public function load(ObjectManager $manager): void
    { 
        $this->faker = Factory::create('fr_FR');

        

 // WatchLists
        
        $watchlists = [];  
        for($a = 0; $a < 10 ; $a ++){
        $watchlist = new WatchList ();

        $manager->persist($watchlist);
        $watchlists[] = $watchlist;
        
        }
        $animes = $this->animeRepository->findAll();
        
        foreach ($watchlists as $watchlist) {
            for ($b=0; $b < mt_rand(1, 5); $b ++){ 
            $watchlist->addAnime(
                $animes[mt_rand(0, count($animes) - 1)]);
            }
            
        }

        
            // User
            $users = [];
            for($j = 0; $j < 50 ; $j ++){
            $user = new User();
            $user->setFullName( $this->faker->name())
            ->setPseudo(mt_rand(0, 1) === 1 ? $this->faker->firstName() : null)
            ->setEmail($this->faker->email())
            ->setRoles(['ROLE_USER'])
            ->setPlainPassword('password')
            ->setWatchList($watchlists[mt_rand(0, count($watchlists) - 1) ]);
            $users[] = $user;
    
    
            $manager->persist($user);   
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [AppFixtures::class];
    }
}
<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Message;
use symfony\Component\PasswordHasher\UserPasswordHasherInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;
        
    public function __construct(){
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 10;$i ++){
            $message = new Message();
            $message->setTitre(substr($this->faker->sentence(3),30));
            $message->setDatePoste($this->faker->dateTimeThisYear());      
            $message->setContenu($this->faker->paragraph());    
            $message->setUser($this->getReference('user'.mt_rand(0,9)));
            $this->addReference('message'.$i,$message);
            $manager->persist($message);
        }

        for($i = 0; $i < 10;$i ++){
            $message = new Message();
            $message->setTitre(substr($this->faker->sentence(3),30));
            $message->setDatePoste($this->faker->dateTimeThisYear());      
            $message->setContenu($this->faker->paragraph());    
            $message->setUser($this->getReference('user'.mt_rand(0,9)));
            $message->setParent($this->getReference('message'.mt_rand(0,9)));
            $manager->persist($message);
        }
        $manager->flush();
    }

    public function getDependencies(){
        return[UserFixtures::class];        
    }
}

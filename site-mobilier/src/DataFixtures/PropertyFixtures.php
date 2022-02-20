<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for($i=1;$i<= 100;$i++){

            $property=new Property();
            $property->setTitle("voloany hahah")
                     ->setPrice(200000)
                     ->setDescription("lololo lololo")
                     ->setSurface(300)
                     ->setRooms(5)
                     ->setBedrooms(30)
                     ->setFloor(6)
                     ->setHeat(1)
                     ->setCity("tana")
                     ->setAddress("lolo lolo")
                     ->setPostalCode("tyty");

            $manager->persist($property);

        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;


class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
        $faker=\Faker\Factory::create('fr_FR');

        // $product = new Product();
        // $manager->persist($product);

        //Category faké
        for($i=1;$i<= 3;$i++){
            $category= new Category();
            $category->setTitle($faker->sentence())
                     ->setDescription($faker->paragraph());
            $manager->persist($category);

            for($j=1;$j<= mt_rand(4,6);$j++){
                $article= new Article();

                //$content='<p>'; 
                //$content='<p>'.join('<p>',$faker->paragraph(5)).'</p>';
                //$content.='</p>';
                $article->setTitle($faker->sentence())
                        ->setContent($faker->paragraph())
                        ->setImage($faker->imageUrl())
                        //->setCreatedAt($faker->dateTimeImmutableBetween('-6 months'))
                        ->setCategory($category)
                        ->setCreatedAt(new \DateTimeImmutable());
    
                $manager->persist($article);
                //commentaire aticle
                for($k=1;$k<= mt_rand(4,6);$k++){
                      $comment=new Comment();
                      $now= new \DateTimeImmutable();
                      $interval=$now->diff($article->getCreatedAt());
                      $days=$interval->days;
                      $minimum='-'.$days.' days'; // -100 days
                      //$content='<p>'.join('<p>',$faker->paragraph(5)).'</p>';
                      $comment->setAuthor($faker->name)
                              ->setContent($faker->sentence())
                              //->setCreatedAt($faker->dateTimeBetween($minimum))
                              ->setArticle($article)
                              ->setCreateAt(new \DateTimeImmutable());

                      $manager->persist($comment);
                }
            }

        }
        

        $manager->flush();
    }
}

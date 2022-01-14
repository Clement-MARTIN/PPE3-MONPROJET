<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Categorie;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create("fr_FR");
        $cateListe = ["Animalerie", "Applis & Jeux", "Auto & Moto", "Bagages",
                "Beauté et Parfum", "Bijoux", "Bricolage", "Bébés & Puériculture",
            "Chaussures et Sacs", "Cuisine & Maison", "DVD & Blu-ray", "Epicerie",
            "Fournitures de bureau", "Electroménager", "High-Tech", "Hygiène & Santé",
            "Informatique", "Instruments de musique", "Jardin", "Jeux & Jouets",
            "Jeux Video", "Livres", "Logiciels", "Luminaires & Eclairage","Mécanique",
            "Mode","Montres","Musique","Musique: CD & Vinyles",
            "Musique classique","Secteur industriel et scientifique","Sports & Loisirs","Vétements et accessoires"];

        $m = 0;
        $cates = [];
        for ($j = 0; $j <= 32; $j++){
            $cate = new Categorie();
            $cate->setNameCat($cateListe[$m]);
            $m += 1;
            $manager->persist($cate);
            array_push($cates, $cate);
        }


        for($i = 0; $i <= 300; $i++){
            $article = new Article();
            $name = $faker->sentence();
            $description = $faker->paragraph(3);
            $origine = $faker->country;
            $article->setName($name)
                ->setDescription($description)
                ->setPrix(mt_rand(0, 20000)/100)
                ->setFraisDePort(mt_rand(0, 50)/10)
                ->setQuantite(mt_rand(0, 50000)/100)
                ->setOrigine($origine)
                ->setNote(mt_rand(0, 50)/10)
                ->setIdCat($cates[mt_rand(0,31)]);
            $manager->persist($article);

        }
        $manager->flush();
    }
}

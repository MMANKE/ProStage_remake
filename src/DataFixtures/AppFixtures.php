<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Entity\Stage;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

       $DU = new Formation();
       $DU->setNom("DU TIC");
       $DU->setNomComplet("Diplôme Universitaire Technologies de l'Information et de la Communication");
       $manager->persist($DU);

       $DUT = new Formation();
       $DUT->setNom("DUT Info");
       $DUT->setNomComplet("Diplôme Universitaire Technologique Informatique");
       $manager->persist($DUT);

       $LP = new Formation();
       $LP->setNom("LP Prog Avancée ");
       $LP->setNomComplet("Licence Professionnelle Programmation Avancée");
       $manager->persist($LP);

       $faker = \Faker\Factory::create('fr_FR');

              $google = new Entreprise();
              $google->setNom("Google");
              $google->setActivite("Dominer le web");
              $google->setAdresse("12 rue Google LA USA");
              $google->setSiteWeb("www.google.fr");

              $manager->persist($google);

              for($i = 0; $i < 10; $i++){
                $temp = new Entreprise();
                $temp->setNom($faker->company);
                $temp->setActivite($faker->realText(60));
                $temp->setAdresse($faker->streetAddress);
                $temp->setSiteWeb($faker->url);
                $tableauEntreprises[] = $temp;
                $manager->persist($temp);
              }

              $stage = new Stage();
              $stage->setTitre("Mise à jour des webservices de monitoring des serveurs");
              $stage->setDomaine("Télécom/réseaux");
              $stage->setEmail("contact@google.fr");
              $stage->addFormation($DUT);
              $stage->setEntreprise($google);
              $manager->persist($stage);

              for($i = 0; $i < 10; $i++){
                $temp = new Stage();
                $temp->setTitre($faker->realText(60));
                $temp->setDomaine($faker->realText(120));
                $temp->setEmail($faker->companyEmail);
                $temp->setEntreprise($tableauEntreprises[$i]);
                $rnd = $faker->numberBetween($min = 0, $max = 2);
                switch($rnd){
                  case 0:
                    $temp->addFormation($DU);
                    break;
                  case 1:
                    $temp->addFormation($LP);
                    break;
                  case 2:
                    $temp->addFormation($DUT);
                    break;
                }
                $manager->persist($temp);
              }
       // Envoyer en BD tous les objets persistés
       $manager->flush();
    }
}

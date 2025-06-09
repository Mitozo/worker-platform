<?php
// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\FileDetails;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FileDetailsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // create 2 FileDetails! Bam!
        for ($i = 0; $i < 2; $i++) {
            $fileDetails = new FileDetails();
            $fileDetails->setExtension('xlsx ');
            $fileDetails->setSheetsName(["observable_sheets" => ["Guideline", "Customers", "Products", "Summary"]]);
            $fileDetails->setUuidKey('work_unit_uuid');
            $manager->persist($fileDetails);
        }

        $manager->flush();
    }
}
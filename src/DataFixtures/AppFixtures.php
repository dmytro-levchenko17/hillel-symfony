<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Post;
use App\Entity\PostTag;
use App\Entity\Question;
use App\Entity\Tag;
use App\Factory\AnswerFactory;
use App\Factory\ProductFactory;
use App\Factory\QuestionFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
    //    QuestionFactory::createMany(20);

    //    QuestionFactory::new()
    //        ->unpublished()
    //        ->many(5)
    //        ->create()
    //    ;

       AnswerFactory::createMany(300);
       AnswerFactory::new()
           ->needsApproval()
           ->many(50)
           ->create()
       ;

        $manager->flush();
    }
}
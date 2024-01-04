<?php

namespace Database\SeedsDao;

require_once 'vendor/autoload.php';

use Database\DataAccess\DAOFactory;
use Models\Post;
use Faker\Factory;
use Models\DataTimeStamp;

class ThreadsDaoSeeder{

    public function seed(): void
    {
        $postDao = DAOFactory::getPostDAO();
        $thread = $this->createDummyThread();
        $postDao->create($thread);
    }

    public function createDummyThread(): Post
    {
        $faker = Factory::create();
        $min_year = strtotime('1990-01-01 00:00:00');
        $max_year = strtotime('2023-12-01 00:00:00');
        $randomTimeStampCreated = mt_rand($min_year, $max_year);
        $randomTimeStampUpdated = mt_rand($randomTimeStampCreated, $max_year);
        $imagePath = null;
        $thumbnailPath = null;
        $timestamp = new DataTimeStamp($randomTimeStampCreated, $randomTimeStampUpdated);

        $thread = new Post(
            $faker->realTextBetween(160, 1000, 5),
            $faker->realTextBetween(1, 50, 5),
            '/thread/' . $faker->slug(),
            null,
            null,
            $imagePath,
            $thumbnailPath,
            $timestamp
        );

        return $thread;
    }
}
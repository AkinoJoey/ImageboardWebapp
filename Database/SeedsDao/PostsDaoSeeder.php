<?php

namespace Database\SeedsDao;

require_once 'vendor/autoload.php';

use Database\DataAccess\DAOFactory;
use Models\Post;
use Faker\Factory;
use Models\DataTimeStamp;
use Carbon\Carbon;

class PostsDaoSeeder{

    public function seed(): void
    {
        $postDao = DAOFactory::getPostDAO();
        $posts = $this->createDummyPosts();
        array_map(fn($post)=>$postDao->create($post), $posts);
    }

    public function createDummyPosts(): array{
        $faker = Factory::create();
        $min_year = strtotime('1990-01-01 00:00:00');
        $max_year = strtotime('2023-12-01 00:00:00');
        $defaultItemCount = 50;
        $data = [];

        // スレッドのダミー
        for($i = 0; $i < $defaultItemCount; $i++){
            $randomTimeStampCreated = mt_rand($min_year, $max_year);
            $randomTimeStampUpdated = mt_rand($randomTimeStampCreated, $max_year);
            $createdAt = Carbon::createFromTimestamp($randomTimeStampCreated)->toDateString();
            $updatedAt = Carbon::createFromTimestamp($randomTimeStampUpdated)->toDateString();
            $timestamp = new DataTimeStamp($createdAt, $updatedAt);
            $imagePath = null;
            $thumbnailPath = null;

            $thread = new Post(
                $faker->realTextBetween(10, 1000, 5),
                $faker->realTextBetween(1, 50, 5),
                '/thread/' . $faker->slug(),
                null,
                null,
                $imagePath,
                $thumbnailPath,
                $timestamp
            );

            $data[] = $thread;
        }

        // コメントのダミー
        for ($i = 0; $i < $defaultItemCount; $i++) {
            $randomTimeStampCreated = mt_rand($min_year, $max_year);
            $randomTimeStampUpdated = mt_rand($randomTimeStampCreated, $max_year);
            $createdAt = Carbon::createFromTimestamp($randomTimeStampCreated)->toDateString();
            $updatedAt = Carbon::createFromTimestamp($randomTimeStampUpdated)->toDateString();
            $timestamp = new DataTimeStamp($createdAt, $updatedAt);
            $imagePath = null;
            $thumbnailPath = null;

            $reply = new Post(
                $faker->realTextBetween(10, 50, 5),
                $faker->realTextBetween(1, 20, 5),
                null,
                $faker->numberBetween(1, 49),
                null,
                $imagePath,
                $thumbnailPath,
                $timestamp
            );

            $data[] = $reply;
        }
        

        return $data;
    }

}

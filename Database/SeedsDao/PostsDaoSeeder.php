<?php

namespace Database\SeedsDao;

require_once 'vendor/autoload.php';

use Database\DataAccess\DAOFactory;
use Models\Post;
use Faker\Factory;

class PostsDaoSeeder{

    public function seed(): void
    {
        $postDao = DAOFactory::getPostDAO();
        $posts = $this->createDummyPosts();
        array_map(fn($post)=>$postDao->create($post), $posts);
    }

    public function createDummyPosts(): array{
        $faker = Factory::create();
        $data = [];
        $defaultItemCount = 50;

        // スレッドのダミー
        for($i = 0; $i < $defaultItemCount; $i++){
            $imagePath = null;
            $thumbnailPath = null;

            $thread = new Post(
                $faker->realTextBetween(160, 1000, 5),
                $faker->realTextBetween(1, 50, 5),
                '/thread/' . $faker->slug(),
                null,
                null,
                $imagePath,
                $thumbnailPath,
                null
            );

            $data[] = $thread;
        }

        // コメントのダミー
        for ($i = 0; $i < $defaultItemCount; $i++) {
            $imagePath = null;
            $thumbnailPath = null;

            $reply = new Post(
                $faker->realTextBetween(20, 140, 5),
                $faker->realTextBetween(1, 20, 5),
                null,
                $faker->numberBetween(0, 49),
                null,
                $imagePath,
                $thumbnailPath,
                null
            );

            $data[] = $reply;
        }
        

        return $data;
    }

}

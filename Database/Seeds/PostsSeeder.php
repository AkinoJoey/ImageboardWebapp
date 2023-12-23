<?php

namespace Database\Seeds;

require_once 'vendor/autoload.php';

use Database\AbstractSeeder;
use Faker\Factory;
use Carbon\Carbon;

class PostsSeeder extends AbstractSeeder{
    protected ?string $tableName = 'posts';
    protected array $tableColumns = [
        [
            'data_type' => '?int',
            'column_name' => 'reply_to_id'
        ],
        [
            'data_type' => '?string',
            'column_name' => 'subject'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'content'
        ],
        [
            'data_type' => '?string',
            'column_name' => 'image_path'
        ],
        [
            'data_type' => '?string',
            'column_name' => 'thumbnail_path'
        ],
        [
            'data_type' => '?string',
            'column_name' => 'url'
        ],
        [
            'data_type' => 'DateTime',
            'column_name' => 'created_at'
        ],
        [
            'data_type' => 'DateTime',
            'column_name' => 'updated_at'
        ],
    ];

    public function createRowData(): array
    {
        $faker = Factory::create();
        $data = [];
        $min_year = strtotime('1990-01-01 00:00:00');
        $max_year = strtotime('2023-12-01 00:00:00');

        for ($i = 0; $i < 1000; $i++) {
            $randomTimeStampCreated = mt_rand($min_year, $max_year);
            $randomTimeStampUpdated = mt_rand($randomTimeStampCreated, $max_year);

            // 50%の確率でnullにする
            $imagePath = '/Public/images/tangerine.png';
            $thumbnailPath = $imagePath;

            // id 1から100までメインスレッド
            $row = [
                    null,
                    $faker->realTextBetween(1, 50, 5),
                    $faker->realTextBetween(160, 1000, 5),
                    $imagePath,
                    $thumbnailPath,
                    '/thread/' . $faker->slug(),
                    Carbon::createFromTimestamp($randomTimeStampCreated)->toDateTime(),
                    Carbon::createFromTimestamp($randomTimeStampUpdated)->toDateTime(),
            ];

            // id 101 から200までコメント
            // $row = [
            //     $faker->numberBetween(1, 100), //reply to id
            //     $faker->realTextBetween(1, 20, 5),
            //     $faker->realTextBetween(20, 140, 5),
            //     null,
            //     null,
            //     null,
            //     Carbon::createFromTimestamp($randomTimeStampCreated)->toDateTime(),
            //     Carbon::createFromTimestamp($randomTimeStampUpdated)->toDateTime(),
            // ];

            $data[] = $row;
        }

        return $data;
    }
}
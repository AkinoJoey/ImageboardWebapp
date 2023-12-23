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

            $imagePath = 'bf/bfc6a1d034457e10cda64b649409ebbf224c4261b2b445d3acb7e9300dddbde6.jpeg';
            $thumbnailPath = 'bf/bfc6a1d034457e10cda64b649409ebbf224c4261b2b445d3acb7e9300dddbde6_thumbnail.jpeg';

            // id 1から100までメインスレッド
            // $row = [
            //         null,
            //         $faker->realTextBetween(1, 50, 5),
            //         $faker->realTextBetween(160, 1000, 5),
            //         $imagePath,
            //         $thumbnailPath,
            //         '/thread/' . $faker->slug(),
            //         Carbon::createFromTimestamp($randomTimeStampCreated)->toDateTime(),
            //         Carbon::createFromTimestamp($randomTimeStampUpdated)->toDateTime(),
            // ];

            $imagePath = 'ab/ab31cded011645c46ded35b9db2a79f7250e7672522b6117cdb58592f498413e.png';
            $thumbnailPath = 'ab/ab31cded011645c46ded35b9db2a79f7250e7672522b6117cdb58592f498413e_thumbnail.png';

            $row = [
                $faker->numberBetween(1, 1000), //reply to id
                $faker->realTextBetween(1, 20, 5),
                $faker->realTextBetween(20, 140, 5),
                $imagePath,
                $thumbnailPath,
                null,
                Carbon::createFromTimestamp($randomTimeStampCreated)->toDateTime(),
                Carbon::createFromTimestamp($randomTimeStampUpdated)->toDateTime(),
            ];

            $data[] = $row;
        }

        return $data;
    }
}
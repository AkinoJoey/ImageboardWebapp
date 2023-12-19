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
            'data_type' => 'int',
            'column_name' => 'reply_to_id'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'subject'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'content'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'image_path'
        ],
        [
            'data_type' => 'string',
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

            // 50％の確率でnullにする
            $randomProbability = mt_rand() / mt_getrandmax();
            $replyToId = $randomProbability <= 0.5 ? null : $faker->numberBetween(1, 1000);
            $url = $replyToId == null ?  '/thread/' . $faker->slug():null;

            $row = [
                $replyToId,
                $faker->text(300),
                $faker->text(10000),
                '2f/2fe986aa0cfcf08d24dabec7b3df343a91970d43ad2f41da09f745ff72243c7f.jpeg',
                $url,
                Carbon::createFromTimestamp($randomTimeStampCreated)->toDateTime(),
                Carbon::createFromTimestamp($randomTimeStampUpdated)->toDateTime(),
            ];

            $data[] = $row;
        }

        return $data;
    }
}
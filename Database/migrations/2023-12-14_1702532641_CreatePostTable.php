<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreatePostTable implements SchemaMigration
{
    public function up(): array
    {
        return ["create table if not exists posts (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    reply_to_id INT,
                    subject VARCHAR(50),
                    content TEXT,
                    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    updated_at DATETIME NOT nULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);"];
    }

    public function down(): array
    {
        return ["DROP TABLE posts"];
    }
}
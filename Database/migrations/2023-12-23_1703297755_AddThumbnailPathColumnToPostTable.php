<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class AddThumbnailPathColumnToPostTable implements SchemaMigration
{
    public function up(): array
    {
        return ["ALTER TABLE posts ADD COLUMN thumbnail_path VARCHAR(255) AFTER image_path;"];
    }

    public function down(): array
    {
        return ["ALTER TABLE posts DROP COLUMN thumbnail_path;"];
    }
}
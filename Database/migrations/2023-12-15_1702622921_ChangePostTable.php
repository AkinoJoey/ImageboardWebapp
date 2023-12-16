<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class ChangePostTable implements SchemaMigration
{
    public function up(): array
    {
        return ["ALTER TABLE posts ADD COLUMN image_path VARCHAR(255) AFTER content;"];
    }

    public function down(): array
    {
        return ["ALTER TABLE posts DROP COLUMN image_path;"];
    }
}
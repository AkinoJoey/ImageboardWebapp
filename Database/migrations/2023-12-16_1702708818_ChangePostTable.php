<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class ChangePostTable implements SchemaMigration
{
    public function up(): array
    {
        return ["ALTER TABLE posts ADD COLUMN url VARCHAR(255) AFTER image_path;"];
    }

    public function down(): array
    {
        return ["ALTER TABLE posts DROP COLUMN url;"];
    }
}

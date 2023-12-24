<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class AlterPostTableContentColumn implements SchemaMigration
{
    public function up(): array
    {
        return ["ALTER TABLE posts MODIFY content MEDIUMTEXT NOT NULL;"];
    }

    public function down(): array
    {
        return ["ALTER TABLE posts MODIFY content TEXT;"];
    }
}
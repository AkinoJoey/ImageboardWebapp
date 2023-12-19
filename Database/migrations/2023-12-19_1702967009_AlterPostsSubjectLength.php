<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class AlterPostsSubjectLength implements SchemaMigration
{
    public function up(): array
    {
        return ["ALTER TABLE posts MODIFY subject VARCHAR(1200);"];
    }

    public function down(): array
    {
        return ["ALTER TABLE posts MODIFY subject VARCHAR(255);"];
    }
}
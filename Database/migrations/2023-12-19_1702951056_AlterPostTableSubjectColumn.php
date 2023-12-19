<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class AlterPostTableSubjectColumn implements SchemaMigration
{
    public function up(): array
    {
        return ["ALTER TABLE posts MODIFY subject VARCHAR(255);"];
    }

    public function down(): array
    {
        return ["ALTER TABLE posts MODIFY subject VARCHAR(50);"];
    }
}
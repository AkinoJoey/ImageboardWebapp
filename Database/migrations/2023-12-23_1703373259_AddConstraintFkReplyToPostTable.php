<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class AddConstraintFkReplyToPostTable implements SchemaMigration
{
    public function up(): array
    {
        return [
            "ALTER TABLE posts
                ADD CONSTRAINT fk_reply_to
                FOREIGN KEY (reply_to_id) REFERENCES posts(id) ON DELETE CASCADE;"
        ];
    }

    public function down(): array
    {
        return ["ALTER TABLE posts DROP FOREIGN KEY fk_reply_to"];
    }
}
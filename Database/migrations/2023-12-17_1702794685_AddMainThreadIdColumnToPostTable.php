<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class AddMainThreadIdColumnToPostTable implements SchemaMigration
{
    public function up(): array
    {
        return [
            "ALTER TABLE posts
                ADD COLUMN main_thread_id INT,
                ADD CONSTRAINT fk_main_thread
                FOREIGN KEY (reply_to_id) REFERENCES posts(id) ON DELETE CASCADE;"
        ];
    }

    public function down(): array
    {
        return [
            "ALTER TABLE posts
                DROP FOREIGN KEY fk_main_thread,
                DROP COLUMN main_thread_id;"
        ];
    }
}
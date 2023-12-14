<?php
namespace Database\DataAccess\Implementations;

use Database\DataAccess\Interfaces\PostDAO;
use Database\DatabaseManager;

class PostDAOImpl implements PostDAO{
    public function create(Post $postData): bool{
        if ($postData->getId() !== null) throw new \Exception('Cannot create a post with an existing ID. id: ' . $postData->getId());

        $mysqli = DatabaseManager::getMysqliConnection();
        $query = "INSERT INTO posts(reply_to_id, subject, content) values(?, ?, ?)";
        
    }
}
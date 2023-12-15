<?php
namespace Database\DataAccess\Implementations;

use Database\DataAccess\Interfaces\PostDAO;
use Database\DatabaseManager;
use Models\Post;
use Models\DataTimeStamp;

// TO:DO implements PostDAO
class PostDAOImpl {
    public function create(Post $postData): bool
    {
        if ($postData->getId() !== null) throw new \Exception('Cannot create a post with an existing ID. id: ' . $postData->getId());
        return $this->createOrUpdate($postData);
    }

    public function getById(int $id): ?Post
    {
        $mysqli = DatabaseManager::getMysqliConnection();
        $post = $mysqli->prepareAndFetchAll("SELECT * FROM posts WHERE id = ?", 'i', [$id])[0] ?? null;

        return $post === null ? null : $this->resultToPost($post);
    }

    public function update(Post $postData): bool
    {
        if ($postData->getId() === null) throw new \Exception('Post specified has no ID.');

        $current = $this->getById($postData->getId());
        if ($current === null) throw new \Exception(sprintf("Post %s does not exist.", $postData->getId()));

        return $this->createOrUpdate($postData);
    }
    public function createOrUpdate(Post $postData): bool{
        $mysqli = DatabaseManager::getMysqliConnection();

        $query = 
            <<<SQL
            INSERT INTO posts(id, reply_to_id, subject, content, image_path) VALUES(?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE id = ?,
            reply_to_id = VALUES(reply_to_id),
            subject = VALUES(subject),
            content = VALUES(content),
            image_path = VALUES(image_path)
        SQL;

        $result = $mysqli->prepareAndExecute(
            $query,
            'iisss', 
            [
                $postData->getId(),
                $postData->getReplyToId(),
                $postData->getSubject(),
                $postData->getContent(), 
                $postData->getImagePath()
            ],
        );

        if (!$result) return false;

        if ($postData->getId() === null) {
            $postData->setId($mysqli->insert_id);
            $timeStamp = $postData->getTimeStamp() ?? new DataTimeStamp(date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
            $postData->setTimeStamp($timeStamp);
        }

        return true;
    }

    private function resultToPost(array $data): Post
    {
        return new Post(
            content: $data['content'],
            subject: $data['subject'],
            id: $data['id'],
            replyToId: $data['replyToId'],
            imagePath: $data['imagePath'],
            timeStamp: new DataTimeStamp($data['created_at'], $data['updated_at'])
        );
    }
}
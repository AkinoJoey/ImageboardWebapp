<?php
namespace Database\DataAccess\Implementations;

use Database\DataAccess\Interfaces\PostDAO;
use Database\DatabaseManager;
use Models\Post;
use Models\DataTimeStamp;

class PostDAOImpl implements PostDAO {
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

    public function delete(int $id) : bool {
        $mysqli = DatabaseManager::getMysqliConnection();
        return $mysqli->prepareAndExecute("DELETE FROM posts WHERE id = ?", 'i', [$id]);
    }

    public function createOrUpdate(Post $postData): bool{
        $mysqli = DatabaseManager::getMysqliConnection();

        $query = 
            <<<SQL
            INSERT INTO posts(id, reply_to_id, subject, content, image_path, thumbnail_path ,url) VALUES(?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE id = ?,
            reply_to_id = VALUES(reply_to_id),
            subject = VALUES(subject),
            content = VALUES(content),
            image_path = VALUES(image_path),
            thumbnail_path = VALUES(thumbnail_path),
            url = VALUES(url)
        SQL;

        $result = $mysqli->prepareAndExecute(
            $query,
            'iisssssi', 
            [
                $postData->getId(),
                $postData->getReplyToId(),
                $postData->getSubject(),
                $postData->getContent(), 
                $postData->getImagePath(),
                $postData->getThumbnailPath(),
                $postData->getUrl(),
                $postData->getId()
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
            replyToId: $data['reply_to_id'],
            imagePath: $data['image_path'],
            thumbnailPath: $data['thumbnail_path'],
            url: $data['url'],
            timeStamp: new DataTimeStamp($data['created_at'], $data['updated_at'])
        );
    }

    private function resultsToPosts(array $results): array
    {
        $posts = [];

        foreach ($results as $result) {
            $posts[] = $this->resultToPost($result);
        }

        return $posts;
    }

    public function getByUrl(string $url): ?Post
    {
        $mysqli = DatabaseManager::getMysqliConnection();
        $post = $mysqli->prepareAndFetchAll("SELECT * FROM posts WHERE url = ?", 's', [$url])[0] ?? null;

        return $post === null ? null : $this->resultToPost($post);
    }

    public function getAllThreads(int $offset, int $limit): array{
        $mysqli = DatabaseManager::getMysqliConnection();

        $query = "SELECT * FROM posts WHERE reply_to_id IS NULL ORDER BY created_at DESC LIMIT ?, ?";

        $results = $mysqli->prepareAndFetchAll($query, 'ii', [$offset, $limit]);
        return $results === null ? [] : $this->resultsToPosts($results);
    }

    public function getReplies(Post $postData, int $offset, int $limit): array{
        $mysqli = DatabaseManager::getMysqliConnection();

        $query = "SELECT * FROM posts WHERE reply_to_id = ? LIMIT ?, ?";

        $results = $mysqli->prepareAndFetchAll($query, 'iii', [$postData->getId(), $offset, $limit]);
        return $results === null ? [] : $this->resultsToPosts($results);
    }
        
}
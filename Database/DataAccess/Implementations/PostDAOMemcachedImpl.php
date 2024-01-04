<?php

namespace Database\DataAccess\Implementations;

use Database\DataAccess\Interfaces\PostDAO;
use Database\DatabaseManager;
use Models\DataTimeStamp;
use Models\Post;
use Memcached;
use DateTime;

class PostDAOMemcachedImpl implements PostDAO{
    private Memcached $memcached;

    public function __construct() {
        $this->memcached = DatabaseManager::getMemcachedConnection();
    }

    private function postToResult(Post $postData): array
    {
        return [
            'content' => $postData->getContent(),
            'subject' => $postData->getSubject(),
            'url' => $postData->getUrl(),
            'reply_to_id' => $postData->getReplyToId(),
            'id' => $postData->getId(),
            'image_path' => $postData->getImagePath(),
            'thumbnail_path' => $postData->getThumbnailPath(),
            'created_at' => $postData->getTimeStamp()->getCreatedAt(),
            'updated_at' => $postData->getTimeStamp()->getUpdatedAt(),
        ];
    }

    private function resultToPost(array $data): Post{
        $timestamp = isset($data['created_at']) && isset($data['updated_at']) ? new DataTimeStamp(
            $data['created_at'],
            $data['updated_at']
        ) : null;

        return new Post(
            content: $data['content'],
            subject: $data['subject']?? null,
            url: $data['url']?? null,
            replyToId: $data['reply_to_id'] ?? null,
            id: $data['id'] ?? null,
            imagePath: $data['image_path'],
            thumbnailPath: $data['thumbnail_path'],
            timeStamp: $timestamp,
        );
    }

    public function create(Post $postData): bool{
        if ($postData->getId() !== null) throw new \Exception('Cannot create a post data with an existing ID. id: ' . $postData->getId());

        // 保存されたアイテム数に基づくid
        $stats = $this->memcached->getStats();
        $firstServerKey = key($stats);
        if ($stats === false) throw new \Exception("Failed to retrieve cache stats.");
        $itemCount = $stats[$firstServerKey]['curr_items'];

        $postData->setId($itemCount);
        $now = (new DateTime())->format('Y-m-d H:i:s');
        $postData->setTimeStamp(new DataTimeStamp($now, $now));
        return $this->memcached->set("Post_{$postData->getId()}", json_encode($this->postToResult($postData)));
    }
    public function getById(int $id): ?Post{
        $result = $this->memcached->get("Post_$id");
        return $result ? $this->resultToPost(json_decode($result, true)) : null;
    }
    public function update(Post $postData): bool{
        if ($postData->getId() === null) throw new \Exception('Post specified has no ID.');

        $postData->getTimeStamp()->setUpdatedAt((new DateTime())->format('Y-m-d H:i:s'));
        return $this->memcached->set("Post_{$postData->getId()}", json_encode($this->postToResult($postData)));
    }
    public function delete(int $id): bool{
        return $this->memcached->delete("Post_$id");
    }
    public function createOrUpdate(Post $postData): bool{
        if ($postData->getId() !== null) return $this->update($postData);
        else return $this->create($postData);
    }

    public function getAllThreads(int $offset, int $limit): array{
        $keys = $this->memcached->getAllKeys();
        $postKeys = array_filter($keys, fn ($key) => str_starts_with($key, "Post_"));

        $keys = sort($keys, SORT_STRING);

        $selectedKeys = array_slice($postKeys, $offset, $limit);
        $posts = [];
        foreach($selectedKeys as $key){
            $result = $this->memcached->get($key);
            $post = $this->resultToPost(json_decode($result, true));

            if($post->getReplyToId() === null){
                $posts[] = $post;
            }
        }

        return $posts;
    }

    public function getReplies(Post $postData, int $offset, int $limit): array{
        $keys = $this->memcached->getAllKeys();
        $postKeys = array_filter($keys, fn ($key) => str_starts_with($key, "Post_"));

        $keys = sort($keys, SORT_STRING);

        $selectedKeys = array_slice($postKeys, $offset, $limit);
        $replies = [];
        foreach ($selectedKeys as $key) {
            $result = $this->memcached->get($key);
            $post = $this->resultToPost(json_decode($result, true));

            if ($post->getReplyToId() === $postData->getId()) {
                $replies[] = $post;
            }
        }

        return $replies;
    }

    public function getByUrl(string $url): ?Post{
        $allThreads = $this->getAllThreads(0, PHP_INT_MAX);

        foreach($allThreads as $thread){
            if($thread->getUrl() === $url){
                return $thread;
            }
        }

        return null;
    }
}
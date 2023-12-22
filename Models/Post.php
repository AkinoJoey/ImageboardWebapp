<?php

namespace Models;

use Models\Interfaces\Model;
use Models\Traits\GenericModel;

class Post implements Model{
    use GenericModel;

    public function __construct(
        private string $content,
        private ?string $subject,
        private ?string $url,
        private ?int $replyToId = null,
        private ?int $id = null,
        private ?string $imagePath = null,
        private ?string $thumbnailPath = null,
        private ?DataTimeStamp $timeStamp = null
    ) {
    }
    

    public function getId(): ?int{
        return $this->id;
    }

    public function setId(int $id) : void {
        $this->id = $id;
    }

    public function getReplyToId(): ?int
    {
        return $this->replyToId;
    }

    public function setReplyToId(int $replyToId): void
    {
        $this->$replyToId = $$replyToId;
    }
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getContent() : string {
        return $this->content;
    }

    public function setContent(string $content) : void {
        $this->content = $content;
    }

    public function getImagePath() : ?string {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): void{
        $this->imagePath = $imagePath;
    }

    public function getThumbnailPath(): ?string
    {
        return $this->thumbnailPath;
    }

    public function setThumbnailPath(string $thumbnailPath): void
    {
        $this->thumbnailPath = $thumbnailPath;
    }

    public function getTimeStamp(): ?DataTimeStamp
    {
        return $this->timeStamp;
    }

    public function setTimeStamp(DataTimeStamp $timeStamp): void
    {
        $this->timeStamp = $timeStamp;
    }

    public function getUrl() : ?string {
        return $this->url;
    }

    public function setUrl(string $url) : void {
        $this->url = $url;
    }
}
<?php 

namespace Helpers;

use Models\Post;
use Database\DataAccess\Interfaces\PostDAO;
use Response\Render\JSONRenderer;


class RoutesHelper {

    public static function saveImageAndThumbnail(Post $post, string $tmpPath, string $mime, PostDao $postDao) : array {
        // ファイル名の作成
        $id = (string)$post->getId();
        $createdAt = $post->getTimeStamp()->getCreatedAt();
        $extension = explode('/', $mime)[1];;
        $hash = hash('sha256', $id . $createdAt);
        $filename = $hash . '.' . $extension;
        $uploadDir =   './uploads/';
        $subdirectory = substr($filename, 0, 2);
        $imagePath = $uploadDir .  $subdirectory . '/' . $filename;

        // アップロード先のディレクトリがない場合は作成
        if (!is_dir(dirname($imagePath))) mkdir(dirname($imagePath), 0755, true);
        // アップロードにした場合は失敗のメッセージを送る
        if (!move_uploaded_file($tmpPath, $imagePath)) return (['success' => false, 'message' => '画像のアップロードに失敗しました。']);

        $imagePathFromUploadDir = $subdirectory . '/' . $filename;
        $post->setImagePath($imagePathFromUploadDir);

        // サムネ用画像の作成
        if ($extension == 'gif') {
            $thumbnailPath =  $subdirectory . '/' .  $hash . '_thumbnail.jpeg';
            $command = "magick {$imagePath}[0] -resize '512x512'  {$uploadDir}{$thumbnailPath}";
        } else {
            $thumbnailPath = $subdirectory . '/' . $hash . '_thumbnail.' . $extension;
            $command = "magick {$imagePath} -resize '512x512'  {$uploadDir}{$thumbnailPath}";
        }

        if (!exec($command)) return (['success' => false, 'message' => 'エラーが発生しました。']);

        $post->setThumbnailPath($thumbnailPath);
        $postDao->update($post);

        return ['success' => true];
    }
}
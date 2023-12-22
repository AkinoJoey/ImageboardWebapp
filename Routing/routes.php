<?php

use Database\DataAccess\Implementations\PostDAOImpl;
use Models\Post;
use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;
use Carbon\Carbon;
use Helpers\ValidationHelper;

return [
    '' => function () : HTMLRenderer {
        $postDao = new PostDAOImpl();
        $temporaryMax = 200;
        $allPosts = $postDao->getAllThreads(0, $temporaryMax);

        $allComment = [];

        foreach($allPosts as $post){
            // 「すべてのコメント」の表示の有無を決めるために、最大6つまで取り出す
            $allComment[] = $postDao->getReplies($post, 0, 6);
        }

        return new HTMLRenderer('component/top', ['posts'=> $allPosts, 'allComment'=> $allComment]);
    },
    'submit' => function () : HTMLRenderer | JSONRenderer {
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            return new HTMLRenderer('component/submit');

        }elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
            $title = strlen($_POST['title']) == 0 ? null : $_POST['title'];
            $body = $_POST['body'];

            // validation
            if(!is_null($title)){
                $isValidTitle = ValidationHelper::title($title);
                if ($isValidTitle['success'] == false) return new JSONRenderer($isValidTitle);
            }
            $isValidBody = ValidationHelper::body($body, 'main');
            if ($isValidBody['success'] == false) return new JSONRenderer($isValidBody);

            // 画像がある場合
            if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
                // 画像の情報
                $tmpPath = $_FILES['image']['tmp_name'];
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->file($tmpPath);
                $byteSize = filesize($tmpPath);

                $isValidImage = ValidationHelper::image($mime, $byteSize);
                if ($isValidImage['success'] == false) return new JSONRenderer($isValidImage);
            }

            // ユニークなURLを作成
            $url = '/thread/' . hash('sha256', uniqid(mt_rand(), true));
            $post = new Post($body, $title, $url);
            $postDao = new PostDAOImpl();
            $success = $postDao->create($post);

            if (!$success) {
                throw new Exception('データの作成に失敗しました。');
            }

            // 画像がある場合の挙動
            if (isset($mime)) {

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
                if (!move_uploaded_file($tmpPath, $imagePath)) return new JSONRenderer(['success' => false, 'message' => '画像のアップロードに失敗しました。']);
                
                $imagePathFromUploadDir = $subdirectory . '/' . $filename;
                $post->setImagePath($imagePathFromUploadDir);
                $postDao->update($post);

                // サムネ用画像の作成
                if($extension == 'gif'){
                    $thumbnailFromUploadDir =  $uploadDir .  $subdirectory . '/' .  $hash . '_thumbnail.jpg';
                    $command = "magick {$imagePath}[0] -resize 400  {$thumbnailFilename}";
                }else{
                    $thumbnailFilename = $uploadDir .  $subdirectory . '/' . $hash . '_thumbnail.' . $extension;
                    $command = "magick {$imagePath} -resize 400  {$thumbnailFilename}";
                }
                
                if(exec($command) === false) throw new Exception("サムネの作成に失敗しました。{$thumbnailFilename}");

                $post->setThumbnailPath($thu)
            
            }

            return new JSONRenderer(['success' => true, 'url' => $url]);
        }
    },
    'thread' => function () : HTMLRenderer{
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

            $postDao = new PostDAOImpl();
            $post = $postDao->getByUrl($url);

            $title = $post->getSubject();
            $body = $post->getContent();
            $imagePath = $post->getImagePath();

            $createdAt = $post->getTimeStamp()->getCreatedAt();
            $postedBy = Carbon::parse(($createdAt))->diffForHumans();

            $temporaryMax = 500;
            $comments = $postDao->getReplies($post, 0, $temporaryMax);

            return new HTMLRenderer('component/thread',['title' => $title, 'body' => $body, 'imagePath' => $imagePath, 'postedBy'=>$postedBy ,'comments' => $comments]);
        }
    },
    'comment' => function () : JSONRenderer {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // To:Do validation
            $url = $_POST['url'];
            $postDao = new PostDAOImpl();
            $mainPost = $postDao->getByUrl($url);
            $mainPostId = $mainPost->getId();

            $title = strlen($_POST['title']) == 0 ? null : $_POST['title'];
            $body = $_POST['body'];

            // validation
            if (!is_null($title)) {
                $isValidTitle = ValidationHelper::title($title);
                if ($isValidTitle['success'] == false
                ) return new JSONRenderer($isValidTitle);
            }

            $isValidBody = ValidationHelper::body($body, 'comment');
            if ($isValidBody['success'] == false) return new JSONRenderer($isValidBody);

            // 画像がある場合
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // 画像の情報
                $tmpPath = $_FILES['image']['tmp_name'];
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->file($tmpPath);
                $byteSize = filesize($tmpPath);

                $isValidImage = ValidationHelper::image($mime, $byteSize);
                if ($isValidImage['success'] == false
                ) return new JSONRenderer($isValidImage);
            }


            $commentPost = new Post($body, $title, null, $mainPostId);
            $success = $postDao->create($commentPost);

            if (!$success) {
                throw new Exception('データの作成に失敗しました。');
            }

            // 画像がある場合の挙動
            if (isset($mime)) {
                // ファイル名の作成
                $id = (string)$commentPost->getId();
                $createdAt = $commentPost->getTimeStamp()->getCreatedAt();
                $extension = explode('/', $mime)[1];
                $filename = hash('sha256', $id . $createdAt) . '.' . $extension;
                $uploadDir =   './uploads/';
                $subdirectory = substr($filename, 0, 2);
                $imagePath = $uploadDir .  $subdirectory . '/' . $filename;

                // アップロード先のディレクトリがない場合は作成
                if (!is_dir(dirname($imagePath))) mkdir(dirname($imagePath), 0755, true);
                // アップロードにした場合は失敗のメッセージを送る
                if (!move_uploaded_file($tmpPath, $imagePath)) return new JSONRenderer(['success' => false, 'message' => 'アップロードに失敗しました。']);

                $imagePathFromUploadDir = $subdirectory . '/' . $filename;
                $commentPost->setImagePath($imagePathFromUploadDir);
                $postDao->update($commentPost);
            }
            return new JSONRenderer(['success' => true, 'url' => $url]);
        }
    }
];
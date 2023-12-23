<?php

use Carbon\Carbon;

?>

<article>
    <hgroup>
        <div>
            <img src="/images/user_icon.svg" width="40px" alt="user icon">
            <sup><?= 'Posted by ' . htmlspecialchars($postedBy) ?></sup>
            <!-- title -->
            <?php if (!is_null($post->getSubject())) : ?>
                <h2 class="mb-0"><?= htmlspecialchars($post->getSubject()) ?></h2>
            <?php endif; ?>
        </div>
        <!-- body -->
        <p><?= htmlspecialchars($post->getContent()) ?></p>
        <div class="row center-xs">
            <!-- img -->
            <?php if (!is_null($post->getImagePath())) : ?>
                <div class="row center-xs">
                    <a href="<?= '/uploads/' . htmlspecialchars($post->getImagePath()) ?>">
                        <img class="thumbnail" src="<?= '/uploads/' . htmlspecialchars($post->getThumbnailPath())  ?>" alt="uploaded image">
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </hgroup>

    <footer>
        <!-- reply -->
        <p>投稿に返信:</p>
        <div>
            <article id="reply-card" class="mt-0 mb-0">
                <form class="mb-0" id="reply-form" enctype="multipart/form-data" method="POST">
                    <input type="text" id="title" name="title" placeholder="タイトル">
                    <textarea type="textarea" id="body" name="body" placeholder="内容" required></textarea>
                    <label for="image">画像を選択：</label>

                    <div class="row between-xs mh-0">

                        <div>
                            <input type="file" id="image" name="image" accept="image/png, image/jpeg , image/gif">
                        </div>
                        <div class="">
                            <button class="mb-0 mw-6" type="submit">返信</button>

                        </div>
                    </div>
                </form>
            </article>
        </div>

        <h2>Comments</h2>
        <?php foreach ($comments as $comment) : ?>
            <div class="mb-3">
                <div class="row mh-0">
                    <img src="/images/user_icon.svg" alt="user icon">
                    <small><?= htmlspecialchars(Carbon::parse($comment->getTimeStamp()->getCreatedAt())->diffForHumans()) ?></small>

                    <?php if (!is_null($comment->getSubject())) : ?>
                        <h4 class="mb-0 ml-4"><?= htmlspecialchars($comment->getSubject()) ?></h4>
                    <?php endif; ?>
                </div>
                <p><?= $comment->getContent() ?></p>
                <!-- img -->
                <?php if (!is_null($comment->getImagePath())) : ?>
                    <div class="row center-xs">
                        <a href="<?= '/uploads/' . htmlspecialchars($comment->getImagePath()) ?>">
                            <img class="thumbnail" src="<?= '/uploads/' . htmlspecialchars($comment->getThumbnailPath())  ?>" alt="uploaded image">
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

    </footer>
</article>

<script src="/js/comment.js"></script>
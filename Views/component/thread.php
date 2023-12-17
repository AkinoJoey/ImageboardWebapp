<article>
    <hgroup>
        <div>
            <img src="/images/user_icon.svg" width="40px" alt="user icon">
            <!-- title -->
            <?php if (!is_null($title)) : ?>
                <h2 class="mb-0"><?= htmlspecialchars($title) ?></h2>
            <?php endif; ?>
        </div>
        <!-- body -->
        <p><?= htmlspecialchars($body) ?></p>
        <div class="row center-xs">
            <!-- img -->
            <?php if (!is_null($imagePath)) : ?>
                <img class="w-35" src="<?= '/uploads/' . htmlspecialchars($imagePath) ?>" alt="uploaded image">
            <?php endif; ?>
        </div>
    </hgroup>
    <a href="#"><img src="/images/comment.svg" alt="comment icon" title="返信"></a>

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
        <div class="mb-3">
            <div class="row mh-0">
                <img src="/images/user_icon.svg" alt="">
                <h4 class="mb-0 ml-4">title</h4>
            </div>
            <p>Go to Safari > Settings > Websites > Notifications, and remove or change all sites to not allow Notifications.</p>
        </div>

        <?php foreach($comments as $comment): ?>
            <div class="mb-3">
                <div class="row mh-0">
                    <img src="/images/user_icon.svg" alt="">
                    <h4 class="mb-0 ml-4"><?= $comment->getSubject() ?></h4>
                </div>
                <p><?= $comment->getContent() ?></p>
            </div>
        <?php endforeach; ?>

    </footer>
</article>

<script>
    console.log(<?php echo var_dump($comments) ?>);
</script>
<script src="/js/comment.js"></script>
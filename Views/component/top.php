<?php

use Carbon\Carbon;

?>

<!-- post -->
<article class="mt-3">
    <a href="/submit"><input type="text" placeholder="今日何かあった？"></a>
</article>

<!-- thread -->
<?php foreach ($posts as $post) : ?>
    <article class="thread">
        <a class="expandLink" href="<?= $post->getUrl() ?>"></a>
        <hgroup>
            <div>
                <img src="/images/user_icon.svg" width="40px" alt="">
                <sup class="black"><?= 'Posted by ' . htmlspecialchars(Carbon::parse($post->getTimeStamp()->getCreatedAt())->diffForHumans()) ?></sup>

                <?php if (!is_null($post->getSubject())) : ?>
                    <h2 class="mb-0"><?= htmlspecialchars($post->getSubject()) ?></h2>
                <?php endif; ?>
            </div>
            <p><?= htmlspecialchars($post->getContent()) ?></p>
            <?php if (!is_null($post->getImagePath())) : ?>
                <div class="row center-xs">
                    <img class="w-35" src="<?= '/uploads/' . htmlspecialchars($post->getImagePath())  ?>" alt="">
                </div>
            <?php endif; ?>

        </hgroup>
        <img src="/images/comment.svg" alt="" title="返信">

        <footer>
            <h2>Comments</h2>
            <?php foreach ($allComment as $comments) : ?>
                <?php foreach ($comments['comments'] as $comment) : ?>
                    <?php if ($post->getId() == $comment->getReplyToId()) : ?>
                        <div class="mb-3">
                            <div class="row mh-0">
                                <img src="/images/user_icon.svg" alt="user icon">
                                <small><?= htmlspecialchars(Carbon::parse($comment->getTimeStamp()->getCreatedAt())->diffForHumans()) ?></small>
                                <h4 class="mb-0 ml-4"><?= $comment->getSubject() ?></h4>
                            </div>
                            <p><?= $comment->getContent() ?></p>
                            <!-- img -->
                            <?php if (!is_null($comment->getImagePath())) : ?>
                                <div class="row center-xs">
                                    <img class="w-35" src="<?= '/uploads/' . htmlspecialchars($comment->getImagePath()) ?>" alt="uploaded image">
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach ?>

                <?php if ($comments['hasMoreComments']) : ?>
                        <hr>
                        <a>
                            <p class="text-align-center mb-0 mt-1">すべてのコメント</p>
                        </a>
                    <?php endif; ?>

            <?php endforeach; ?>

        </footer>
    </article>

<?php endforeach; ?>
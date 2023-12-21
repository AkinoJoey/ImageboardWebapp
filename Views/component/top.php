<?php

use Carbon\Carbon;

?>

<!-- post -->
<article class="mt-3">
    <a href="/submit"><input id="submit-field" type="text" placeholder="今日何かあった？"></a>
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
                <div class="row center-xs top-element">
                    <a href="<?= '/uploads/' . $post->getImagePath() ?>">
                        <img class="w-35" src="<?= '/uploads/' . htmlspecialchars($post->getImagePath())  ?>" alt="uploaded image">
                    </a>
                </div>

            <?php endif; ?>

        </hgroup>
        <a class="top-element" href="<?= $post->getUrl() ?>">
            <img src="/images/comment.svg" alt="comment icon" title="返信">
        </a>

        <footer>
            <h2>Comments</h2>
            <?php foreach ($allComment as $comments) : ?>
                <?php for ($i = 0; $i < count($comments); $i++) : ?>
                    <?php if ($post->getId() == $comments[$i]->getReplyToId()) : ?>
                        <div class="mb-3">
                            <div class="row mh-0">
                                <img src="/images/user_icon.svg" alt="user icon">
                                <small><?= htmlspecialchars(Carbon::parse($comments[$i]->getTimeStamp()->getCreatedAt())->diffForHumans()) ?></small>
                                <h4 class="mb-0 ml-4"><?= $comments[$i]->getSubject() ?></h4>
                            </div>
                            <p><?= $comments[$i]->getContent() ?></p>
                            <!-- img -->
                            <?php if (!is_null($comments[$i]->getImagePath())) : ?>
                                <div class="row center-xs">
                                    <img class="w-35" src="<?= '/uploads/' . htmlspecialchars($comments[$i]->getImagePath()) ?>" alt="uploaded image">
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (count($comments) > 5 && $i === 4) : ?>
                            <hr>
                            <a href="<?= $post->getUrl() ?>" class="top-element">
                                <p class="text-align-center mb-0 mt-1">すべてのコメント</p>
                            </a>
                            <?php break; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endfor; ?>
            <?php endforeach; ?>

        </footer>
    </article>

<?php endforeach; ?>
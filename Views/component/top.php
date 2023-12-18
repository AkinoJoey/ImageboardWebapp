<?php 

use Carbon\Carbon;

?>

<!-- post -->
<article class="mt-3">
    <a href="/submit"><input type="text" placeholder="今日何かあった？"></a>
</article>

<!-- thread -->
<?php foreach ($posts as $post) : ?>
    <a class="text-decoration-none" href="<?= $post->getUrl() ?>">
        <article class="thread">
            <hgroup>
                <div>
                    <img src="/images/user_icon.svg" width="40px" alt="">
                    <sup class="black" ><?= 'Posted by ' . htmlspecialchars(Carbon::parse($post->getTimeStamp()->getCreatedAt())->diffForHumans()) ?></sup>

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
            <a href="<?= $post->getUrl() ?>"><img src="/images/comment.svg" alt="" title="返信"></a>

            <footer>
                <h2>Comments</h2>
                <?php foreach ($allComment as $comments) : ?>
                    <?php foreach ($comments as $comment) : ?>
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
                <?php endforeach; ?>

                <hr>
                <a href="<?= $post->getUrl() ?>">
                    <p class="text-align-center mb-0 mt-1">すべてのコメント</p>
                </a>

            </footer>
        </article>
    </a>

<?php endforeach; ?>


<article class="thread">
    <hgroup>
        <div class="">
            <img src="/images/user_icon.svg" width="40px" alt="">
            <h2 class="mb-0">title</h2>
        </div>
        <p>body texbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textbody textt</p>
        <div class="row center-xs">
            <img class="w-35" src="/images/4.5MB.jpg" alt="">
        </div>
    </hgroup>
    <a href="#"><img src="/images/comment.svg" alt="" title="返信"></a>

    <footer>
        <h2>Comments</h2>
        <div class="mb-3">
            <div class="row mh-0">
                <img src="/images/user_icon.svg" alt="">
                <h4 class="mb-0 ml-4">title</h4>
            </div>
            <p>Go to Safari > Settings > Websites > Notifications, and remove or change all sites to not allow Notifications.</p>
        </div>
        <div class="mb-3">
            <div class="row mh-0">
                <img src="/images/user_icon.svg" alt="">
                <h4 class="mb-0 ml-4">title</h4>
            </div>
            <p>犬ワロタ</p>
        </div>
        <div class="mb-3">
            <div class="row mh-0">
                <img src="/images/user_icon.svg" alt="">
                <h4 class="mb-0 ml-4">title</h4>
            </div>
            <p>Go to Safari > Settings > Websites > Notifications, and remove or change all sites to not allow Notifications.</p>
        </div>
        <div class="mb-3">
            <div class="row mh-0">
                <img src="/images/user_icon.svg" alt="">
                <h4 class="mb-0 ml-4">title</h4>
            </div>
            <p>Go to Safari > Settings > Websites > Notifications, and remove or change all sites to not allow Notifications.</p>
        </div>

        <hr>
        <a href="">
            <p class="text-align-center mb-0 mt-1">すべてのコメント</p>
        </a>

    </footer>
</article>
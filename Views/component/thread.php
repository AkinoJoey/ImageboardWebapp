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
                <img class="w-35" src="<?= htmlspecialchars($imagePath) ?>" alt="uploaded image">
            <?php endif; ?>
        </div>
    </hgroup>
    <a href="#"><img src="/images/comment.svg" alt="comment icon" title="返信"></a>

    <!-- TO:DO comments -->
</article>
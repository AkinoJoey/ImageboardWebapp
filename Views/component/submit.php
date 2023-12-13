<h4 class="mt-3 mb-min">話題を投稿する</h4>
<hr>
<article class="mt-1">
    <form method="POST">
        <input type="text" id="title" name="title" placeholder="タイトル">
        <textarea type="textarea" id="body" name="body" placeholder="内容" required style="height: 150px"></textarea>
        <img class="image-icon" id="image-icon" src="/images/pic.svg" alt="">
        <input class="d-none" type="file" id="image-input" name="image-input" accept="image/png, image/jpeg , image/gif">
        <div style="height: 15px;" id="image-preview"></div>
    </form>
</article>

<script src="/js/submit.js" ></script>
<h4 class="mt-3 mb-min">話題を投稿する</h4>
<hr>
<article class="mt-1">
    <form id="thread-form" enctype="multipart/form-data" method="POST">
        <input type="text" id="title" name="title" placeholder="タイトル">
        <textarea type="textarea" id="body" name="body" placeholder="内容" required></textarea>
        <label for="image">画像を選択：</label>
        <input type="file" id="image" name="image" accept="image/png, image/jpeg , image/gif">
        <div class="row end-xs mh-0">
            <button class="mb-0 mw-6" type="submit">作成</button>
        </div>
    </form>
</article>

<script src="/js/submit.js"></script>
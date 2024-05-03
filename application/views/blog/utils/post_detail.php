<div class="card mt-3">
    <div class="card-header">
        <img src="<?= image_post($post->post_id) ?>">
    </div>
    <div class="card-body">
        <h1><?= $post->title ?></h1>
        <?= $post->content ?>
        <a class="btn btn-danger" href="<?= base_url() . 'blog/category/' . $post->c_url_clean ?>"><?= $post->category ?></a>
    </div>

</div>
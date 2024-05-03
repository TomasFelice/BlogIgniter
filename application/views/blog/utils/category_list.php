<?php foreach ($categories as $key => $category): ?>
    <a class="dropdown-item" href="#" data-id="<?= $category->category_id ?>">
        <?= $category->name ?>
    </a>
<?php endforeach; ?>
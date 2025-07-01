<div class="main_zone">
    <?php if (isset($descriptions)): ?>
        <?php foreach ($descriptions as $key => $item): ?>
            <div class="main_header_zone" >
                <a href="/booking/service?id=<?= $item['id']?>" style="text-decoration: none;">
                    <div class="card" style="width: 18rem;">
                        <img src=<?= htmlentities($item['img']) ?> class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text"><?= htmlentities($item['description']) ?></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>
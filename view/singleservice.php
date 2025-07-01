<?php if($_COOKIE['accessToken']): ?>
<div>
    <a href="/booking">Back Home Page</a>
</div>
<div class="service_zone">
    <div class="container_side">
        <?php if ($service): ?>
            <div class="img_side">
                <img src=<?= htmlentities($service['img']) ?> alt="" class="img">
            </div>
            <ul class="inside_info">
                <h1 class="smooth"><?= htmlentities($service['name']) ?></h1>
                <li><?= htmlentities($service['description']) ?></li>
                <li><?= htmlentities($service['duration']) . ' Minutes' ?></li>
                <li><?= htmlentities($service['price']) . '$' ?></li>
                <li>
                    <button type="button" class="button">
                        <a href="/booking/book?id=<?= $service['id'] ?>&service=<?= $service['name'] ?>" class="link">
                            Book Service Now
                        </a>
                    </button>
                </li>
            </ul>
        <?php endif ?>
    </div>
</div>
<?php else:?>
<?php header('Location: /booking/login'); exit;?>
<?php endif ?>
<script>
    window.onload =function(){
        const smooth = document.querySelector('.smooth');
        if(smooth){
            smooth.scrollIntoView({behavior:'smooth',block:"center"});
        }
    };
</script>
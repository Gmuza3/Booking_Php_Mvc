<header>
    <?php require_once '../view/header_nav/header.php' ?>
</header>
<h1 style="width: 100%; display:flex;justify-content:center; padding-top: 30px;font-weight: 600;
    font-family:Georgia, 'Times New Roman', Times, serif;">
    Services
</h1>
<main>
    <?php require_once '../view/main/main.php' ?>
</main>
<div id="modal" class="modal" style="display:none;">
    <div class="modal-body">
        <h5 style="width: 100%;">User Edited Successfully!</h5>
        <button onclick="document.getElementById('modal').style.display='none';">Close</button>
    </div>
</div>

<script>
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('status') === 'success') {
            document.getElementById('modal').style.display = 'block';
        }
    };
</script>
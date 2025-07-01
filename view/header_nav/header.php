<nav class="navbar navbar-expand-lg bg-body-tertiary" style="width:100%">
    <div class="container-fluid">
        <h1><i>Salon</i></h1>
        <div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navbarScroll">
            <ul class="navbar-nav d-flex align-items-center gap-3" style="--bs-scroll-height: 100px;">
                <?php if (!empty($_COOKIE['accessToken'])): ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/booking/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/booking/profile">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/booking/logout">Log out</a>
                    </li>
                <?php endif ?>
                <?php if (empty($_COOKIE['accessToken'])): ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/booking/login">Login</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/booking/register">Register</a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>
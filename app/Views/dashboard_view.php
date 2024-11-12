<?= $this->extend('layouts/base'); ?>
<?= $this->section('content') ?>

<div class="dis">
    <!-- Sidebar -->
    <?= $this->include('partials/sidebar') ?>

    <!-- Main Content -->
    <div class="content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Notifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Messages</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Dashboard Content -->
        <div class="container mt-4">
            <?php if (session()->has('google_user')): 
                $uinfo = session()->get('google_user');
                ?>
                <div class="jumbotron">
                <img src="<?= $uinfo['profile_pic']?>" height="100" width="100">
                <p>Name:<?= $uinfo['first_name']?> <?= $uinfo['last_name']?></p>
                <p>Email: <?= $uinfo['email']?></p>
                </div>
            <?php else: ?>
                <h2>Welcome, <?= ucfirst($userdata->username) ?></h2>
                <h2>Phone No, <?= $userdata->phone ?></h2>
                <p>This is your dashboard where you can find an overview of recent activity.</p>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Profile</h5>
                            <p class="card-text">View and edit your profile.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Settings</h5>
                            <p class="card-text">Customize your dashboard settings.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Analytics</h5>
                            <p class="card-text">View analytics and reports.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?= $this->endSection(); ?>
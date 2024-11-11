<div class="sidebar d-flex flex-column p-3">
    <h4 class="text-center">Dashboard</h4>
    <hr>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link " href="#">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (current_url() == base_url('/dashboard/login_activity')) ? 'active' : '' ?>" href="<?= base_url('/dashboard/login_activity') ?>">Login Activity</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Settings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="#">Analytics</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (current_url() == base_url('/dashboard/logout')) ? 'active' : '' ?>" href="<?= base_url('/dashboard/logout') ?>">Logout</a>
        </li>
    </ul>
</div>
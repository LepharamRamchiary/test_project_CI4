<?= $this->extend('layouts/base'); ?>
<?= $this->section('content') ?>

<div class="dis">
    <!-- Sidebar -->
    <?= $this->include('partials/sidebar') ?>

    <!-- Main Content -->
    <div class="content">
        <!-- Dashboard Content -->
        <div class="container mt-4">
            <h2>Login Activity</h2>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Unique ID (uniid)</th>
                            <th>Agent</th>
                            <th>IP Address</th>
                            <th>Login Time</th>
                            <th>Logout Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($login_info) > 0): ?>
                            <?php foreach ($login_info as $activity): ?>
                                <tr>
                                    <td><?= htmlspecialchars($activity->id) ?></td>
                                    <td><?= htmlspecialchars($activity->uniid) ?></td>
                                    <td><?= htmlspecialchars($activity->agent) ?></td>
                                    <td><?= htmlspecialchars($activity->ip) ?></td>
                                    <td><?= date("l dS M Y h:i:s a", strtotime(htmlspecialchars($activity->login_time))) ?></td>
                                    <td><?= htmlspecialchars($activity->logout_time) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <h5>Sorry! No information found</h5>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?= $this->endSection(); ?>
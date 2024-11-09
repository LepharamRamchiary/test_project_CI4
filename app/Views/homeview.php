<?= $this->extend('layouts/base'); ?>
<?= $this->section('content') ?>


<!-- Hero Section -->
<div class="hero-section">
    <h1>Welcome to My Website</h1>
    <p>Your one-stop platform for amazing features.</p>
    <a href="<?= base_url()?>login" class="btn btn-light">Login</a>
    <a href="<?= base_url()?>register" class="btn btn-outline-light">Register</a>
</div>

<?= $this->endSection() ?>
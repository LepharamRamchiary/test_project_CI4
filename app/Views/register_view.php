<?php 
$page_session = \Config\Services::session();
?>

<?= $this->extend('layouts/base'); ?>
<?= $this->section('content') ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 400px;
            margin-top: 50px;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            width: 100%;
        }
    </style>
</head>

<body>


    <!-- Register Form -->
    <div class="container">
        <h2 class="text-center">Register</h2>

        <?php if($page_session->getTempdata('success')):?>
            <div class="alert alert-success"><?= $page_session->getTempdata('success')?></div>
        <?php endif; ?>

        <?php if($page_session->getTempdata('error')):?>
            <div class="alert alert-danger"><?= $page_session->getTempdata('error')?></div>
        <?php endif; ?>

        <?php echo form_open(); ?>

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username" value="<?= set_value('username') ?>">
            <span class="text-danger"><?= display_error($validation, 'username') ?></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?= set_value('email') ?>">
            <span class="text-danger"><?= display_error($validation, 'email') ?></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone No</label>
            <input type="text" class="form-control" name="phone" value="<?= set_value('phone') ?>">
            <span class="text-danger"><?= display_error($validation, 'phone') ?></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" >
            <span class="text-danger"><?= display_error($validation, 'password') ?></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="conf_password" >
            <span class="text-danger"><?= display_error($validation, 'conf_password') ?></span>
        </div>
        <input type="submit" class="btn btn-primary" value="Register" name="register">

        <?php echo form_close(); ?>

        <p class="text-center mt-3">Already have an account? <a href="<?= base_url() ?>login">Login here</a></p>
    </div>
    <?= $this->endSection() ?>
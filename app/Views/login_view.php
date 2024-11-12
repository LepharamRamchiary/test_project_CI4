<?= $this->extend('layouts/base'); ?>
<?= $this->section('content') ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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



    <!-- Login Form -->
    <div class="container">
        <h2 class="text-center">Login</h2>

        <?php if (isset($validation)): ?>
            <div class="alert alert-danger">
                <?= $validation->listErrors(); ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getTempdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getTempdata('error'); ?>
            </div>
        <?php endif; ?>




        <?php echo form_open(); ?>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?= set_value('email') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
        </div>

        <input type="submit" class="btn btn-primary" name="login" value="Login">


        <?php if (isset($loginButton)): ?>
            <div class="form-group mt-3">
                <a href="<?= $loginButton ?>"><img height="35" width="35" src="<?= base_url() ?>public/assets/google.png"><span style="padding-left: 10px;">Login with Google</span></a>
            </div>

        <?php endif; ?>
        <?php echo form_close(); ?>

        <p class="text-center mt-3">Don't have an account? <a href="<?= base_url() ?>register">Register here</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    
    
</body>

</html>


<?= $this->endSection() ?>
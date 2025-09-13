<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
        <h1 class="h4 text-center mb-4">Login</h1>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($this->session->flashdata('error')) ?></div>
        <?php endif; ?>

        <form id="loginForm" method="post" action="<?= site_url('auth/login') ?>">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" required class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" required class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>

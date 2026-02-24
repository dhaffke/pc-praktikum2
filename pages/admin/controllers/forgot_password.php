<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-sm-10 col-md-6 col-lg-4">

            <div class="card shadow border-0">
                <div class="card-body p-4">

                    <h4 class="text-center mb-3">Recover Password</h4>

                    <p class="text-muted small text-center mb-4">
                        Enter the email address you used when registering.
                        We will help you reset your password.
                    </p>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="?forgot_password">

                        <div class="mb-3">
                            <label class="form-label">Email address</label>
                            <input type="email"
                                   name="email"
                                   class="form-control form-control-lg"
                                   required>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit"
                                    name="forgot-password-btn"
                                    class="btn btn-primary btn-lg">
                                Send Recovery Link
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="<?= $URL ?>admin" class="small text-decoration-none">
                                Back to login
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
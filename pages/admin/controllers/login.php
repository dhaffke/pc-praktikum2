<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">

            <div class="card shadow-lg border-0">
                <div class="card-body p-4">

                    <h4 class="text-center mb-4">Login</h4>

                    <form action="" method="post">

                        <?php if (!empty($_SESSION['message'])): ?>
                            <div class="alert <?= htmlspecialchars($_SESSION['alert-class'] ?? 'alert-info', ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') ?>
                            </div>
                            <?php unset($_SESSION['message'], $_SESSION['alert-class']); ?>
                        <?php endif; ?>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username or Email</label>
                            <input type="text"
                                   name="username"
                                   class="form-control form-control-lg"
                                   required>
                        </div>


                        <div class="mb-3">
                            <label for="password" class="form-label">Passwort</label>
                            <input type="password"
                                   name="password"
                                   class="form-control form-control-lg"
                                   required>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit"
                                    name="login-admin-btn"
                                    class="btn btn-primary btn-lg">
                                Login
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="<?php $URL ?>?forgot_password" class="small text-decoration-none">
                                Passwort vergessen?
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-sm-10 col-md-6 col-lg-4">

            <div class="card shadow border-0">
                <div class="card-body p-4">

                    <h4 class="text-center mb-3">Message</h4>

                    <?php if (!empty($_SESSION['message'])): ?>
                        <div class="alert <?= htmlspecialchars($_SESSION['alert-class']) ?>">
                            <?= $_SESSION['message'] ?>
                        </div>
                        <?php
                        unset($_SESSION['message'], $_SESSION['alert-class']);
                        ?>
                    <?php endif; ?>

                    <div class="text-center">
                        <a href="<?= $URL ?>admin" class="small text-decoration-none">
                            Back to login
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

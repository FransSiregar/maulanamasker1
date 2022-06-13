<?= $this->extend('auth/template') ?>
<?= $this->section('content') ?>

<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Register</h3>
                    </div>
                    <div class="card-body">
                        <?= view('Myth\Auth\Views\_message_block') ?>
                        <form action="<?= route_to('register') ?>" method="post">
                            <?= csrf_field() ?>
                            <form>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control<?php if (session('errors.firstname')) : ?>is-invalid<?php endif ?>" name="firstname" type="text" placeholder="Enter your first name" value="<?= old('firstname') ?>" />
                                            <label for=" inputFirstName">First name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control <?php if (session('errors.lastname')) : ?>is-invalid<?php endif ?>" name="lastname" type="text" placeholder="Enter your last name" value="<?= old('lastname') ?>" />
                                            <label for="inputLastName">Last name</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" type="email" placeholder="<? lang('Auth.email') ?>" value="<?= old('lastname') ?>" />
                                    <label for="inputEmail">Email</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<? lang('Auth.username') ?>" value="<?= old('username') ?>" />
                                    <label for="inputEmail">Username</label>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<? lang('Auth.password') ?>" autocomplete="off" />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input type="password" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<? lang('Auth.repeatPassword') ?>" autocomplete="off" />
                                            <label for="inputPasswordConfirm">Confirm Password</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
                                    </div>
                                </div>
                            </form>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <p><?= lang('Auth.alreadyRegistered') ?> <a href="<?= route_to('login') ?>">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>
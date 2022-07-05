<?= $this->extend('auth/templates/index'); ?>

<?= $this->section('content'); ?>

<div class="container">

    <div class="card o-hidden border-0 col-lg-6 mx-auto shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4"><?= lang('Auth.register') ?></h1>
                        </div>

                        <?= view('Myth\Auth\Views\_message_block') ?>

                        <form action="<?= route_to('register') ?>" method="post" class="user">

                            <?= csrf_field() ?>

                            <div class="form-group">
                                <input type="text" class="form-control form-control-user  <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" id="inputUsernamae" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
                            </div>

                            <div class="form-group">
                                <input type="text" name="fullName" class="form-control form-control-user  <?php if (session('errors.fullName')) : ?>is-invalid<?php endif ?>" id="inputNamaLengkap" placeholder="Full Name" value="<?= old('fullName') ?>">
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-user  <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" id="inputNoTelepon" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                                <small id="emailHelp" class="form-text text-muted"><?= lang('Auth.weNeverShare') ?></small>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" name="password" class="form-control form-control-user <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                                </div>

                                <div class="col-sm-6">
                                    <input type="password" name="pass_confirm" class="form-control form-control-user <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                                </div>
                            </div>
                            <hr>
                            <div class="float-right">
                                <a href="login.html" class="btn btn-secondary btn-sm mr-2">
                                    cancel
                                </a>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <?= lang('Auth.register') ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?= $this->endSection(); ?>
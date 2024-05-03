<div class="register-box">
    <div class="register-logo">
        <a href="<?php echo base_url() ?>blog"><?php echo APP_NAME ?></a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Registrar</p>

        <form action="" method="post">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Nombre" name="name" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Apellido" name="surname" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Usuario" name="username" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Email" name="email" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Contraseña" name="passwd" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Registrar</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <a href="login" class="text-center float-right">Ya tengo una cuenta</a>
        <br>
    </div>
    <!-- /.form-box -->
</div>
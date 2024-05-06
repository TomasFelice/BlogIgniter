<div class="login-box">
    <div class="login-logo">
        <a href=""><b><?php echo APP_NAME ?></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Iniciar sesión</p>

        <?php echo form_open('app/ajax_attempt_login', ['class' => 'std-form']); ?>
        <div class="form-group has-feedback">
            <input name="login_string" class="form-control" placeholder="Usuario o email" type="text">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input name="login_pass" class="form-control" placeholder="Contraseña" type="password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">

            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar Sesión</button>
            </div>
            <!-- /.col -->
        </div>

        <input type="hidden" id="max_allowed_attempts" value="<?php echo config_item('max_allowed_attempts'); ?>" />
        <input type="hidden" id="mins_on_hold" value="<?php echo ( config_item('seconds_on_hold') / 60 ); ?>" />

        </form>

        <a href="<?php echo base_url() ?>app/recover">Olvidé mi contraseña</a><br>
        <a href="register" class="text-center">Registrarse</a>

    </div>
    <!-- /.login-box-body -->
</div>

<script>
    $(document).ready(function () {
        $(document).on('submit', 'form', function (e) {
            $.ajax({
                type: 'post',
                cache: false,
                url: '<?php echo base_url() ?>app/ajax_attempt_login',
                data: {
                    'login_string': $('[name="login_string"]').val(),
                    'login_pass': $('[name="login_pass"]').val(),
                    'loginToken': $('[name="token"]').val()
                },
                dataType: 'json',
                success: function (response) {
                    $('[name="loginToken"]').val(response.token);
                    console.log(response);
                    if (response.status == 1) {
                        // Reirección ppor defecto
                        window.location.href = '<?php echo base_url() ?>';
                    } else if (response.status == 0 && response.on_hold) {
                        // si el usuario está en bloqueado por intentos fallidos
                        $('form').hide();
                        $('#on-hold-message').show();
                        $.toaster({
                            priority : 'warning',
                            title : 'Intentos de inicio de sesión excesivos',
                            message : ''
                        });
                    } else {
                        $.toaster({
                            priority : 'warning',
                            title : 'Login fallido',
                            message : 'Login fallido ' + response.count + ' de ' + $('#max_allowed_attempts').val()
                        });
                    }
                }
            });
            return false;
        });
    });
</script>
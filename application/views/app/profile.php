<div class="row">

    <div class="col-lg-12 mb-3 mt-3">
        <div class="box-center bg-profile">
            <img src="<?= image_user($this->session->userdata('id')) ?>" class="user-image img-profile" alt="User Image">
        </div>
    </div>

    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h4><i class='fa fa-cog'></i> Cambio de Contraseña</h4>
            </div>
            <div class="card-body">
                <!-- Creando form con Helper de CodeIgniter -->
            <?= form_open('', 'class="my_form" enctype="multipart/form-data"'); ?>
                <div class="form-group">
                    <?= form_label('Contraseña actual', 'old_pass'); ?>
                    <?php
                        $text_input = array(
                            'name' => 'old_pass',
                            'minLength' => 8,
                            'maxLength' => 72,
                            'required' => 'required',
                            'id' => 'old_pass',
                            'class' => 'form-control input-lg',
                            'value' => '',
                            'type' => 'password'
                        );

                        echo form_input($text_input);
                    ?>
                    <?= form_error('old_pass', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <?= form_label('Contraseña nueva', 'new_pass'); ?>
                    <?php
                        $text_input = array(
                            'name' => 'new_pass',
                            'minLength' => 8,
                            'maxLength' => 72,
                            'required' => 'required',
                            'id' => 'new_pass',
                            'class' => 'form-control input-lg',
                            'value' => '',
                            'type' => 'password'
                        );

                        echo form_input($text_input);
                    ?>
                    <?= form_error('new_pass', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <?= form_label('Repita la nueva contraseña', 'new_pass_verify'); ?>
                    <?php
                        $text_input = array(
                            'name' => 'new_pass_verify',
                            'minLength' => 8,
                            'maxLength' => 72,
                            'required' => 'required',
                            'id' => 'new_pass_verify',
                            'class' => 'form-control input-lg',
                            'value' => '',
                            'type' => 'password'
                        );

                        echo form_input($text_input);
                    ?>
                    <?= form_error('new_pass_verify', '<div class="text-danger">', '</div>'); ?>
                </div>
            <?= form_submit('mysubmit', 'Guardar', 'class="btn btn-primary"'); ?>
            <?= form_close(); ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4><i class='fa fa-user'></i> Datos de Usuario</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <?= form_label('Usuario', 'username'); ?>
                    <?php
                        $text_input = array(
                            'readonly' => 'readonly',
                            'class' => 'form-control input-lg',
                            'value' => $this->session->userdata('name')
                        );

                        echo form_input($text_input);
                    ?>
                    <?= form_error('username', '<div class="text-error">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <?= form_label('Email', 'email'); ?>
                    <?php
                        $text_input = array(
                            'readonly' => 'readonly',
                            'class' => 'form-control input-lg',
                            'value' => $this->session->userdata('email')
                        );

                        echo form_input($text_input);
                    ?>
                    <?= form_error('email', '<div class="text-error">', '</div>'); ?>
                </div>

                <!-- Creando form con HTML Clásico -->
                <form action="<?= base_url() ?>app/load_avatar" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="image">Avatar</label>
                            <input type="file" name="image" class="form-control input-lg">
                        </div>
                        <input type="submit" value="Enviar" class="btn btn-primary">
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    window.onload = () => {
        $('.img-profile').click(() => {
            $('[name=image]').trigger('click');
        })
    }
</script>
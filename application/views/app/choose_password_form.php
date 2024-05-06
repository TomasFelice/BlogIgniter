<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Community Auth - Choose Password Form View
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2018, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */
?>

<div class="container">

    <h1 class="text-center">Recuperación de cuenta</h1>

    <?php
    $showform = 1;

    if (isset($validation_errors)) {
        ?>

        <div class="alert alert-danger" role="alert">
            <p>
                Los siguientes errores ocurrieron cuando se intentaba cambiar la contraseña:
            </p>
            <ul>
                <?php echo $validation_errors ?>
            </ul>
            <p>
                Contraseña no actualizada
            </p>
        </div>

        <?php
    } else {
        $display_instructions = 1;
    }

    if (isset($validation_passed)) {?>
        
		<div class="alert alert-success" role="alert">
			<p>
				Contraseña actualizada con exito
			</p>
			<p>
                            Volver al login: <a href="<?php echo base_url() ?>login">login</a>
			</p>
		</div>
	

     <?php   $showform = 0;
    }
    if (isset($recovery_error)) {
        echo '
		<div style="border:1px solid red;">
			<p>
				No usable data for account recovery.
			</p>
			<p>
				Account recovery links expire after 
				' . ( (int) config_item('recovery_code_expiration') / ( 60 * 60 ) ) . ' 
				hours.<br />You will need to use the 
				<a href="/examples/recover">Account Recovery</a> form 
				to send yourself a new link.
			</p>
		</div>
	';

        $showform = 0;
    }
    if (isset($disabled)) {
        echo '
		<div style="border:1px solid red;">
			<p>
				Account recovery is disabled.
			</p>
			<p>
				You have exceeded the maximum login attempts or exceeded the 
				allowed number of password recovery attempts. 
				Please wait ' . ( (int) config_item('seconds_on_hold') / 60 ) . ' 
				minutes, or contact us if you require assistance gaining access to your account.
			</p>
		</div>
	';

        $showform = 0;
    }
    if ($showform == 1) {
        if (isset($recovery_code, $user_id)) {
            if (isset($display_instructions)) {
                if (isset($username)) {
                    ?>
                    <div class="alert alert-success" role="alert">
                        Tu usuario es <i><?php echo $username ?></i><br />
                        Por favor cambia tu contraseña:
                    </div>	
                    <?php
                } else {
                    echo '<p>Please change your password now:</p>';
                }
            }
            ?>
        </div>
        <div class="col-4 box-center">
            <div class="card">
                <div class="container-fluid">
                    <?php echo form_open(); ?>
                    <fieldset>
                        <legend>Cambiar contraseña</legend>
                        <div class="form-group">

                            <?php
                            // PASSWORD LABEL AND INPUT ********************************
                            echo form_label('Password', 'passwd', ['class' => 'form_label']);

                            $input_data = [
                                'name' => 'passwd',
                                'id' => 'passwd',
                                'class' => 'form-control input-lg',
                                'max_length' => config_item('max_chars_for_password')
                            ];
                            echo form_password($input_data);
                            ?>

                        </div>
                        <div class="form-group">

                            <?php
                            // CONFIRM PASSWORD LABEL AND INPUT ******************************
                            echo form_label('Confirm Password', 'passwd_confirm', ['class' => 'form_label']);

                            $input_data = [
                                'name' => 'passwd_confirm',
                                'id' => 'passwd_confirm',
                                'class' => 'form-control input-lg',
                                'max_length' => config_item('max_chars_for_password')
                            ];
                            echo form_password($input_data);
                            ?>

                        </div>
                    </fieldset>
                    <div>
                        <div>

                            <?php
                            // RECOVERY CODE *****************************************************************
                            echo form_hidden('recovery_code', $recovery_code);

                            // USER ID *****************************************************************
                            echo form_hidden('user_identification', $user_id);

                            // SUBMIT BUTTON **************************************************************
                            $input_data = [
                                'name' => 'form_submit',
                                'id' => 'submit_button',
                                'class' => 'btn btn-success',
                                'value' => 'Cambiar'
                            ];
                            echo form_submit($input_data);
                            ?>

                        </div>
                    </div>
                    <br>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
}
/* End of file choose_password_form.php */
/* Location: /community_auth/views/examples/choose_password_form.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">

    <h1 class="text-center">Recuperación de cuenta</h1>

    <?php
    if (isset($disabled)) {
        echo '
		<div style="border:1px solid red;">
			<p>
				Account Recovery is Disabled.
			</p>
			<p>
				If you have exceeded the maximum login attempts, or exceeded
				the allowed number of password recovery attempts, account recovery 
				will be disabled for a short period of time. 
				Please wait ' . ( (int) config_item('seconds_on_hold') / 60 ) . ' 
				minutes, or contact us if you require assistance gaining access to your account.
			</p>
		</div>
	';
    } else if (isset($banned)) {
        echo '
		<div style="border:1px solid red;">
			<p>
				Account Locked.
			</p>
			<p>
				You have attempted to use the password recovery system using 
				an email address that belongs to an account that has been 
				purposely denied access to the authenticated areas of this website. 
				If you feel this is an error, you may contact us  
				to make an inquiry regarding the status of the account.
			</p>
		</div>
	';
    } else if (isset($confirmation)) {
        ?>
        <div class="alert alert-success" role="alert">
            <p class="feedback_header">
                Revisa tu email
            </p>
        </div>
    <?php } else if (isset($no_match)) {
        ?>

        <div class="alert alert-danger" role="alert">
            <p class="feedback_header">
                Supplied email did not match any record.
            </p>
        </div>

        <?php
        $show_form = 1;
    } else {
        $show_form = 1;
    }
    ?>
</div>
<?php
if (isset($show_form)) {
    ?>

    <?php echo form_open(); ?>

    <div class="col-4 box-center">
        <div class="card">
            <div class="container-fluid">
                <fieldset>
                    <legend>Coloque su email:</legend>
                    <div class="form-group">

                        <?php
                        // EMAIL ADDRESS *************************************************
                        echo form_label('Email', 'email');

                        $input_data = [
                            'name' => 'email',
                            'id' => 'email',
                            'class' => 'form-control input-lg',
                            'maxlength' => 255
                        ];
                        echo form_input($input_data);
                        ?>

                    </div>
                </fieldset>
                <div>
                    <div>

                        <?php
                        // SUBMIT BUTTON **************************************************************
                        $input_data = [
                            'name' => 'submit',
                            'id' => 'submit_button',
                            'value' => 'Send Email',
                            'class' => 'btn btn-success'
                        ];
                        echo form_submit($input_data);
                        ?>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>

    <?php
}
/* End of file recover_form.php */
/* Location: /community_auth/views/examples/recover_form.php */
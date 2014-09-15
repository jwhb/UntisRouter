            <?php echo form_open('profile/update', array('class' => 'pure-form pure-form-stacked')); ?>

              <?php echo form_fieldset(); ?>

                <?php echo form_label('E-Mail', 'email')?>

                <?php echo form_input(array(
                    'name' => 'email',
                    'placeholder' => 'username@example.org',
                    'id' => 'email',
                    'value' => $user['email']
                )); ?>


                <?php echo form_label('First Name', 'first_name')?>

                <?php echo form_input(array(
                    'name' => 'first_name',
                    'placeholder' => 'First Name',
                    'id' => 'first_name',
                    'value' => $user['first_name']
                )); ?>


                <?php echo form_label('Last Name', 'last_name')?>

                <?php echo form_input(array(
                    'name' => 'last_name',
                    'placeholder' => 'Last Name',
                    'id' => 'last_name',
                    'value' => $user['last_name']
                )); ?>


                <br />

                <?php echo form_submit(array('class' => 'pure-button pure-button-primary', 'name' => 'update-profile', 'value' => 'Update Profile' )); ?>

              <?php echo form_fieldset_close(); ?>

            <?php echo form_close(); ?>


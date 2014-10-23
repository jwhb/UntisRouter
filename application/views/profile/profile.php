            <?php echo form_open('profile/update', array('class' => 'pure-form pure-form-stacked')); ?>

              <?php echo form_fieldset(); ?>

                <?php echo form_label('E-Mail', 'email')?>

                <?php echo form_input(array(
                    'name' => 'email',
                    'placeholder' => 'username@example.org',
                    'id' => 'email',
                    'value' => $user['email']
                )); ?>


                <?php echo form_label('Neues Passwort', 'password')?>

                <?php echo form_password(array(
                    'name' => 'password',
                    'id' => 'password',
                    'placeholder' => '(wenn &Auml;nderung gew&uuml;nscht)',
                    'disabled' => true
                )); ?>

                <br />
                <p>Fragebogen</p>
                <hr />

                <?php /* echo form_label('Vorname', 'first_name')?>

                <?php echo form_input(array(
                    'name' => 'first_name',
                    'placeholder' => 'Vorname',
                    'id' => 'first_name',
                    'value' => $user['first_name']
                )); ?>


                <?php echo form_label('Nachname', 'last_name')?>

                <?php echo form_input(array(
                    'name' => 'last_name',
                    'placeholder' => 'Last Name',
                    'id' => 'last_name',
                    'value' => $user['last_name']
                )); */ ?>


                <?php echo form_label('Meine Lieblingsf&auml;cher', 'fav_subjects')?>

                <?php $subject_count = sizeof($subjects);
                      echo form_multiselect('fav_subjects[]', $subjects, $user['subjects'], "size=\"$subject_count\""); ?>


                <?php echo form_label('Meine Hobbies', 'fav_hobbies')?>

                <?php echo form_textarea(array(
                    'name' => 'fav_hobbies',
                    'id' => 'fav_hobbies',
                    'value' => $user['fav_hobbies'],
                    'cols' => '50',
                    'rows' => '4',
                    'maxlength' => '200'
                )); ?>


                <?php echo form_label('Mein Kindheitsberufswunsch', 'fav_child_job')?>

                <?php echo form_textarea(array(
                    'name' => 'fav_child_job',
                    'id' => 'fav_child_job',
                    'value' => $user['fav_child_job'],
                    'cols' => '50',
                    'rows' => '4',
                    'maxlength' => '200'
                )); ?>


                <?php echo form_label('Mein Pl&auml;ne nach dem Abi', 'fav_occupation')?>

                <?php echo form_textarea(array(
                    'name' => 'fav_occupation',
                    'id' => 'fav_occupation',
                    'value' => $user['fav_occupation'],
                    'cols' => '50',
                    'rows' => '4',
                    'maxlength' => '200'
                )); ?>


                <?php echo form_label('Mein Lebensziel / Mein Berufswunsch', 'fav_lifegoal')?>

                <?php echo form_textarea(array(
                    'name' => 'fav_lifegoal',
                    'id' => 'fav_lifegoal',
                    'value' => $user['fav_lifegoal'],
                    'cols' => '50',
                    'rows' => '4',
                    'maxlength' => '200'
                )); ?>


                <?php echo form_label('Mein Lebensmotto / mein Lieblingszitat', 'fav_cite')?>

                <?php echo form_textarea(array(
                    'name' => 'fav_cite',
                    'id' => 'fav_cite',
                    'value' => $user['fav_cite'],
                    'cols' => '50',
                    'rows' => '4',
                    'maxlength' => '200'
                )); ?>


                <?php echo form_label('Was mir von meiner Schulzeit in Erinnerung bleibt', 'mem_events')?>

                <?php echo form_textarea(array(
                    'name' => 'mem_events',
                    'id' => 'mem_events',
                    'value' => $user['mem_events'],
                    'cols' => '50',
                    'rows' => '4',
                    'maxlength' => '200'
                )); ?>

                <br />

                <?php echo form_submit(array('class' => 'pure-button pure-button-primary', 'name' => 'update-profile', 'value' => 'Update Profile' )); ?>

              <?php echo form_fieldset_close(); ?>

            <?php echo form_close(); ?>

            <link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>assets/css/multiple-select.css">
            <script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.min.js"></script>
            <script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.multiple.select.js"></script>
            <script>
                $("select").multipleSelect({
                    width: 270,
                    selectAll: false,
                    multipleWidth: 200,
                    allSelected: 'Alle ausgew&auml;hlt',
                    countSelected: '# von % F&auml;chern ausgew&auml;hlt',
                    minumimCountSelected: 1,
                });
                $(".ms-choice").width("270px");
            </script>

            <?php $questions = $this->config->item('questions'); ?>
            <?php echo form_open((@$foreign)? '#' : 'profile/update', array('class' => 'pure-form pure-form-stacked profile-form')); ?>
              <?php echo form_fieldset(); ?> 
                <?php echo form_label('E-Mail', 'email'); ?> 
                <?php echo form_input(array(
                    'name' => 'email',
                    'placeholder' => 'username@example.org',
                    'id' => 'email',
                    'value' => $profile_user['email'],
                    'pattern' => '[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}',
                    'title' => 'g&uuml;ltige E-Mail',
                    'required' => '1'
                )); ?>

                <?php echo form_label('Altes Passwort', 'old_password'); ?> 
                <?php echo form_password(array(
                    'name' => 'old_password',
                    'id' => 'old_password',
                    'placeholder' => '(bei Passwort&auml;nderung)',
                    'pattern' => '.{8,}',
                    'title' => 'mindestens 8 Zeichen'
                )); ?> 

                <?php echo form_label('Neues Passwort', 'new_password'); ?> 
                <?php echo form_password(array(
                    'name' => 'new_password',
                    'id' => 'new_password',
                    'placeholder' => '(bei Passwort&auml;nderung)',
                    'pattern' => '.{8,}',
                    'title' => 'mindestens 8 Zeichen'
                )); ?> 
                

                <br /><p>Fragebogen</p><hr />

                <?php /* echo form_label('Frage', 'q1_q'); */ ?> 
                <?php echo form_dropdown('q1_q', $questions, $profile_user['questions'][1]['q']); ?> 
                <?php echo form_textarea(array(
                    'name' => 'q1_a',
                    'id' => 'q1_a',
                    'value' => $profile_user['questions'][1]['a'],
                    'cols' => '50',
                    'rows' => '3',
                    'maxlength' => '300'
                )); ?> 
                <br />
                
                <?php echo form_dropdown('q2_q', $questions, $profile_user['questions'][2]['q']); ?> 
                <?php echo form_textarea(array(
                    'name' => 'q2_a',
                    'id' => 'q2_a',
                    'value' => $profile_user['questions'][2]['a'],
                    'cols' => '50',
                    'rows' => '3',
                    'maxlength' => '300'
                )); ?> 
                <br />
                
                <?php echo form_dropdown('q3_q', $questions, $profile_user['questions'][3]['q']); ?> 
                <?php echo form_textarea(array(
                    'name' => 'q3_a',
                    'id' => 'q3_a',
                    'value' => $profile_user['questions'][3]['a'],
                    'cols' => '50',
                    'rows' => '3',
                    'maxlength' => '300'
                )); ?> 
                <br />
                
                <?php echo form_dropdown('q4_q', $questions, $profile_user['questions'][4]['q']); ?> 
                <?php echo form_textarea(array(
                    'name' => 'q4_a',
                    'id' => 'q4_a',
                    'value' => $profile_user['questions'][4]['a'],
                    'cols' => '50',
                    'rows' => '3',
                    'maxlength' => '300'
                )); ?> 
                <br />
                
                <?php echo form_dropdown('q5_q', $questions, $profile_user['questions'][5]['q']); ?> 
                <?php echo form_textarea(array(
                    'name' => 'q5_a',
                    'id' => 'q5_a',
                    'value' => $profile_user['questions'][5]['a'],
                    'cols' => '50',
                    'rows' => '3',
                    'maxlength' => '300'
                )); ?> 
                <br />
                
                <?php echo form_submit(array('class' => 'pure-button pure-button-primary', 'name' => 'update-profile', 'value' => 'Update Profile' )); ?> 
              <?php echo form_fieldset_close(); ?> 
            <?php echo form_close(); ?> 

            <link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>assets/css/multiple-select.css">
            <script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.min.js"></script>
            <script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.multiple.select.js"></script>
            <?php /* <script>
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
			*/ ?>
            <?php echo form_open('profile/update', array('class' => 'pure-form pure-form-stacked profile-form')); ?> 
              <?php echo form_fieldset(); ?> 
                <?php echo form_label('E-Mail', 'email'); ?> 
                <?php echo form_input(array(
                    'name' => 'email',
                    'placeholder' => 'username@example.org',
                    'id' => 'email',
                    'value' => $user['email'],
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
                

                <p><br />Fragebogen</p><hr />

                <?php echo form_label('Meine Lieblingsf&auml;cher', 'fav_subjects'); ?> 
                <?php $subject_count = sizeof($subjects);
                      echo form_multiselect('fav_subjects[]', $subjects, $user['subjects'], "size=\"$subject_count\""); ?> 

                <?php echo form_label('Meine Hobbies', 'fav_hobbies'); ?> 
                <?php echo form_textarea(array(
                    'name' => 'fav_hobbies',
                    'id' => 'fav_hobbies',
                    'value' => $user['fav_hobbies'],
                    'cols' => '50',
                    'rows' => '4',
                    'maxlength' => '200'
                )); ?> 

                <?php echo form_label('Mein Kindheitsberufswunsch', 'fav_child_job'); ?> 
                <?php echo form_textarea(array(
                    'name' => 'fav_child_job',
                    'id' => 'fav_child_job',
                    'value' => $user['fav_child_job'],
                    'cols' => '50',
                    'rows' => '4',
                    'maxlength' => '200'
                )); ?> 

                <?php echo form_label('Mein Pl&auml;ne nach dem Abi', 'fav_occupation'); ?> 
                <?php echo form_textarea(array(
                    'name' => 'fav_occupation',
                    'id' => 'fav_occupation',
                    'value' => $user['fav_occupation'],
                    'cols' => '50',
                    'rows' => '4',
                    'maxlength' => '200'
                )); ?> 

                <?php echo form_label('Mein Lebensziel / Mein Berufswunsch', 'fav_lifegoal'); ?> 
                <?php echo form_textarea(array(
                    'name' => 'fav_lifegoal',
                    'id' => 'fav_lifegoal',
                    'value' => $user['fav_lifegoal'],
                    'cols' => '50',
                    'rows' => '4',
                    'maxlength' => '200'
                )); ?> 

                <?php echo form_label('Mein Lebensmotto / mein Lieblingszitat', 'fav_cite'); ?> 
                <?php echo form_textarea(array(
                    'name' => 'fav_cite',
                    'id' => 'fav_cite',
                    'value' => $user['fav_cite'],
                    'cols' => '50',
                    'rows' => '10',
                    'maxlength' => '500'
                )); ?> 

                <?php echo form_label('Was mir von meiner Schulzeit in Erinnerung bleibt', 'mem_events'); ?> 
                <?php echo form_textarea(array(
                    'name' => 'mem_events',
                    'id' => 'mem_events',
                    'value' => $user['mem_events'],
                    'cols' => '50',
                    'rows' => '4',
                    'maxlength' => '200'
                )); ?> 

                <?php echo form_label('Motto', 'fav_abimotto'); ?> 
                <?php foreach($mottos as $m_id=>$motto): 
                  $data = array('name' => 'fav_abimotto', 'id' => "fav_abimotto_$m_id", 'value' => $m_id);
                  if($user['fav_abimotto'] == $m_id) $data['checked'] = true;
                  echo form_radio($data) . " $motto"; ?><br />
                <?php endforeach; ?> 
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

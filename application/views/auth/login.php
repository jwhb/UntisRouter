<p><?php echo lang('login_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/login");?>

  <p>
    Nutzername (vorname.nachname):
    <?php echo form_input($identity);?>
  </p>

  <p>
    Passwort:
    <?php echo form_input($password);?>
  </p>

  <p>
    angemeldet bleiben
    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
  </p>


  <p><?php echo form_submit('submit', lang('login_submit_btn'));?></p>

<?php echo form_close();?>

<!--<p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>-->

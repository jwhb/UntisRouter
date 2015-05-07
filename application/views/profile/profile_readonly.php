<table border="1" cellpadding="5">
  <?php foreach($user['questions'] as $question): ?><tr>
    <td><?php echo (strlen($question['t']))? $question['t'] : '--' ?></td>
    <td><?php echo (strlen($question['a']))? $question['a'] : '--' ?></td>
  </tr>
  <?php endforeach; ?>
</table>

<br />
<img id="userphoto1" src="<?php echo $this->config->base_url('assets/img/user_photos/' .
  ((!is_null($profile_user['photo1_id']))? $profile_user['photo1_id'] : 'placeholder.png')
); ?>" alt="User Image 1" height="514px" width="400px"/>
<img id="userphoto2" src="<?php echo $this->config->base_url('assets/img/user_photos/' .
  ((!is_null($profile_user['photo2_id']))? $profile_user['photo2_id'] : 'placeholder.png')
); ?>" alt="User Image 2" height="514px" width="400px"/>

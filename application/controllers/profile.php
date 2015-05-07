<?php

class Profile extends MY_Controller{

  public function __construct(){
    parent::__construct(false);
    $this->load->library('ion_auth');
    $this->load->helper('form');
  }

  public function index(){
      // user's own profile
      if(!$this->ion_auth->logged_in()){
          redirect('auth/login', 'refresh');
      } else {
        redirect('profile/edit', 'refresh');
      }
  }

  private function view_profile($name, $edit){
    // $edit: true=edit, false=view
    if($this->ion_auth->is_admin() !== TRUE){
      redirect('profile', 'refresh');
    } else {
      $data['user'] = $this->get_user_data('', true);
      $data['foreign'] = ($name != $data['user']['username'] && strlen($name) != 0);
      $data['profile_user'] = $this->get_user_data($name, false, true);
      $this->set_title('Profil: ' . $data['profile_user']['first_name'] . ' ' . $data['profile_user']['last_name']);

      $tpl = ($edit)? 'profile/profile' : 'profile/foreign';
      if($edit && $data['foreign']) $tpl = 'profile/profile_readonly';

      $this->template->write_view('content', $tpl, $data);
      $this->template->render();
    }
  }

  public function view($name = ''){
    // other user's profile
    if(!$this->ion_auth->logged_in()){
      redirect('auth/login', 'refresh');
    } elseif(!strlen($name)) {
      // redirect to user's public profile
      $user = $this->get_user_data('', true);
      redirect('profile/view/' . $user['username'], 'refresh');
    } else {
      $this->view_profile($name, false);
    }
  }

  public function edit($name = ''){
    // other user's profile
    if(!$this->ion_auth->logged_in()){
      redirect('auth/login', 'refresh');
    } else {
      $user = $this->get_user_data('');
      if($user['username'] == $name || !strlen($name) || $this->ion_auth->is_admin()){
        $this->view_profile($name, true);
      } else {
        redirect('profile/edit', 'refresh');
      }
    }

  }

  public function update(){
      if($this->ion_auth->logged_in()){
          if($this->input->post('update-profile')){
              $this->load->model('ion_auth_model');
              $this->load->model('subjects_model', 'subjects');
              $user = $this->get_user_data();
              
              if(strlen($this->input->post('old_password')) >= 8 && strlen($this->input->post('new_password')) >= 8){
                  $identity = $user[$this->ion_auth_model->identity_column];
                  $this->ion_auth_model->change_password($identity, $this->input->post('old_password'), $this->input->post('new_password'));
              }
              
              $ch = array();
              $chk = function($ch, $user, $field, $user_val = null){
              	  if($user_val === null) $user_val = $user[$field];
                  $new_val = $this->input->post($field);
                  if($new_val !== false && $new_val != $user_val){
                      $ch[$field] = $new_val;
                  }
                  return $ch;
              };
      
              $ch = $chk($ch, $user, 'first_name');
              $ch = $chk($ch, $user, 'last_name');
              $ch = $chk($ch, $user, 'email');
              $ch = $chk($ch, $user, 'q1_q', $user['questions'][1]['q']);
              $ch = $chk($ch, $user, 'q1_a', $user['questions'][1]['a']);
              $ch = $chk($ch, $user, 'q2_q', $user['questions'][2]['q']);
              $ch = $chk($ch, $user, 'q2_a', $user['questions'][2]['a']);
              $ch = $chk($ch, $user, 'q3_q', $user['questions'][3]['q']);
              $ch = $chk($ch, $user, 'q3_a', $user['questions'][3]['a']);
              $ch = $chk($ch, $user, 'q4_q', $user['questions'][4]['q']);
              $ch = $chk($ch, $user, 'q4_a', $user['questions'][4]['a']);
              $ch = $chk($ch, $user, 'q5_q', $user['questions'][5]['q']);
              $ch = $chk($ch, $user, 'q5_a', $user['questions'][5]['a']);
              
              if(sizeof($ch)){
                  $this->ion_auth_model->update($user['id'], $ch);
              }
      
              $sel_subjects = $this->input->post('fav_subjects');
              if($sel_subjects != $user['fav_subjects']){
                  $this->subjects->update_user_subjects($user['id'], $sel_subjects);
              }
          }
      }
      redirect('profile', 'refresh');
  }
  

  public function list_users(){
      if(!$this->ion_auth->logged_in()){
          redirect('auth/login', 'refresh');
      } else {
          $data['user'] = $this->get_user_data();
          
          $this->load->model('ion_auth_model');
          $users = array();
          foreach($this->ion_auth_model->users()->result() as $user){
              $users[] = array(
                  'id' => $user->id,
                  'username' => $user->username,
                  'first_name' => $user->first_name,
                  'last_name' => $user->last_name,
              );
          }
          $data['users'] = $users;
          $data['is_mod'] = $this->ion_auth->is_admin();

          $this->set_title('Nutzerliste');
          $this->template->write_view('content', 'profile/user_list', $data);
          $this->template->render();
      }
  }

  public function add_comment(){
      if($this->ion_auth->logged_in()){
          if($this->input->post('add-comment')){
              $this->load->model('ion_auth_model');
              $this->load->model('comments_model', 'comments');
              $user = $this->get_user_data();
              $for_user = $this->ion_auth->user($this->input->post('for_user'))->row();
              $comment = $this->input->post('comment');
              $hidden = $this->input->post('hidden') == 'hidden';

              if(strlen($comment)){
                  $this->comments->add_comment($user['id'], $for_user->id, $comment, $hidden);
              }
          }
      }
      redirect('profile/view/' . $for_user->username, 'refresh');
  }

  public function delete_comment($comment_id){
      if($this->ion_auth->logged_in()){
          $this->load->model('comments_model', 'comments');
          $user = $this->get_user_data();
          if(!$this->comments->may_alter($user['id'], $comment_id)){
              echo("You must not delete others' comments!");
              exit();
          } else {
              $this->comments->delete_comment($comment_id);
          }
      }
      redirect('profile/list_users', 'refresh');
  }

  public function photos(){
      if(!$this->ion_auth->logged_in()){
          redirect('auth/login', 'refresh');
      } else {
          $data['user'] = $this->get_user_data();
          
          $this->set_title('Meine Fotos');
          $this->template->write_view('content', 'profile/photos', $data);
          $this->template->render();
      }
  }

  public function upload_photo($id){
    if(!$this->ion_auth->logged_in()){
      redirect('auth/login', 'refresh');
    } elseif($id != 1 && $id != 2) {
      $this->output->set_status_header(400, 'Invalid file id.');
      return false;
    } elseif(empty($_FILES) || $_FILES["file"]["error"]) {
      $this->output->set_status_header(402, 'No files received.');
      return false;
    } else {
        $user = $this->get_user_data();
        $username = $user['username'];

        define('ds', DIRECTORY_SEPARATOR);

        $fileName = $_FILES['file']['name'];
        $rand = uniqid();
        $dest_file = "$username-$id-$rand.jpg";
        $dir = getcwd() . ds;
        $folder_prefix = 'assets' . ds . 'img' . ds . 'user_photos' . ds;
        $dest =  $folder_prefix . $dest_file;
        if(!move_uploaded_file($_FILES['file']['tmp_name'], $dest)) {
          $this->output->set_status_header(500, 'Could not process uploaded file.');
          return false;
        } else {
          unlink($dir . $folder_prefix . $user['photo' . $id . '_id']);
          $this->load->model('ion_auth_model');
          $this->ion_auth_model->update($user['id'], array('photo' . $id . '_id' => $dest_file));
          echo htmlentities(str_replace(ds, '/', $this->config->base_url($dest)));
        }
    }
  }
}

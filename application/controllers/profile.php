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
          $this->load->model('subjects_model', 'subjects');
          $data['user'] = $this->get_user_data('', true);
          $data['subjects'] = $this->subjects->get_subject_names();
          $this->set_title('Profil: ' . $data['user']['first_name'] . ' ' . $data['user']['last_name']);

          $this->template->write_view('content', 'profile/profile', $data);
          $this->template->render();
      }
  }

  public function view($name = ''){
      // other user's profile
      if(!$this->ion_auth->logged_in()){
          redirect('auth/login', 'refresh');
      } elseif(!strlen($name)) {
          // redirect to user profile
          redirect('profile', 'refresh');
      } else {
          $data['user'] = $this->get_user_data();
          $data['other_user'] = $this->get_user_data($name, false, true);
          if(isset($data['other_user']['first_name'])){
              $this->set_title('Profil: ' . $data['other_user']['first_name'] . ' ' . $data['other_user']['last_name']);
          } else {
              $this->set_title('Profil nicht gefunden');
          }

          $this->template->write_view('content', 'profile/foreign', $data);
          $this->template->render();
      }
  }

  public function update(){
      if($this->ion_auth->logged_in()){
          if($this->input->post('update-profile')){
              $this->load->model('ion_auth_model');
              $this->load->model('subjects_model', 'subjects');
              $user = $this->get_user_data();
              $ch = array();
      
              $chk = function($ch, $user, $field){
                  $new_val = $this->input->post($field);
                  if($new_val !== false && $new_val != $user[$field]){
                      $ch[$field] = $new_val;
                  }
                  return $ch;
              };
      
              $ch = $chk($ch, $user, 'first_name');
              $ch = $chk($ch, $user, 'last_name');
              $ch = $chk($ch, $user, 'email');
              $ch = $chk($ch, $user, 'fav_hobbies');
              $ch = $chk($ch, $user, 'fav_child_job');
              $ch = $chk($ch, $user, 'fav_occupation');
              $ch = $chk($ch, $user, 'fav_lifegoal');
              $ch = $chk($ch, $user, 'fav_cite');
              $ch = $chk($ch, $user, 'mem_events');
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

              if(strlen($comment)){
                  $this->comments->add_comment($user['id'], $for_user->id, $comment);
              }
          }
      }
      redirect('profile/view/' . $for_user->username, 'refresh');
  }
  
}

<?php

class Profile extends MY_Controller{

  public function __construct(){
    parent::__construct(false);
    $this->load->library('ion_auth');
    $this->load->helper('form');
  }

  public function index(){
      if(!$this->ion_auth->logged_in()){
          redirect('auth/login', 'refresh');
      } else {
          $data['user'] = $this->get_user_data();

          $this->set_title('Profil: ' . $data['user']['first_name'] . ' ' . $data['user']['last_name']);

          $this->template->write_view('content', 'profile/profile', $data);
          $this->template->render();
      }
  }

  public function update(){
      if($this->input->post('update-profile')){
		  $this->load->model('ion_auth_model');

          $user = $this->get_user_data();
          $ch = array();

          $chk = function($ch, $user, $field){
              $new_val = $this->input->post($field);
              if($new_val != $user[$field]
                && strlen($new_val) > 3
              ){
                  $ch[$field] = $new_val;
              }
              return $ch;
          };
          $ch = $chk($ch, $user, 'first_name');
          $ch = $chk($ch, $user, 'last_name');
          $ch = $chk($ch, $user, 'email');

          if(sizeof($ch)){
              $this->ion_auth_model->update($user['id'], $ch);
          }
      }

      redirect('profile', 'refresh');
  }

}

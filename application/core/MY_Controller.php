<?php

class MY_Controller extends CI_Controller {

  protected function set_title($title = 'Page') {
    $this->template->write('title', $title);
  }

  public function __construct($load_subst_data = false) {
    parent::__construct();
    if($load_subst_data){
        $this->load->model('substitution_model', 'substitutions');
        $data['grades'] = $this->substitutions->get_uniques();
    }

    $this->load->library('ion_auth');
    $this->lang->load('auth');


    $data['user'] = $this->get_user_data();

    $data['menu'] = $this->config->item('page_menu');
    $data['controller'] = strtolower($this->uri->rsegment(1));
    if($this->uri->total_rsegments() > 1 && $data['controller'] == 'grades') $data['controller'] .= strtolower( $this->uri->slash_segment(2, 'leading'));

    $this->template->write_view('sidebar', 'sidebar', $data, TRUE);
  }

  function index() {
    $this->template->render();
  }

  protected function get_user_data(){
      $user_data = $this->ion_auth->user()->row();
      if(sizeof($user_data)){
          $user = array(
            'username' => $user_data->username,
            'id' => $user_data->id,
            'loggedin' => $user_data->active,
            'email' => $user_data->email,
            'first_name' => $user_data->first_name,
            'last_name' => $user_data->last_name
          );
      } else {
          $user = array(
              'loggedin' => false
          );
      }
      return $user;
  }

  protected function get_all_user_data(){
      return $this->ion_auth->user()->row();
  }

}

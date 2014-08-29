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

    $user = $this->ion_auth->user()->row();
    $data['user'] = array();
    if($user){
        $data['user'] = array(
            'username' => $user->username,
            'loggedin' => $user->active,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name
        );
    }

    $data['menu'] = $this->config->item('page_menu');
    $data['controller'] = strtolower($this->uri->rsegment(1));
    if($this->uri->total_rsegments() > 1 && $data['controller'] == 'grades') $data['controller'] .= strtolower( $this->uri->slash_segment(2, 'leading'));

    $this->template->write_view('sidebar', 'sidebar', $data, TRUE);
  }

  function index() {
    $this->template->render();
  }

}

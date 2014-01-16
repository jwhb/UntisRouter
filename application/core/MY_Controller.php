<?php

class MY_Controller extends CI_Controller {
    
  protected function set_title($title = 'Page') {
    $this->template->write('title', $title);
  }
  
  public function __construct() {
    parent::__construct();
    $this->load->model('substitution_model', 'substitutions');
    
    $data['menu'] = $this->config->item('page_menu');
    $data['controller'] = strtolower($this->uri->rsegment(1));
    if($this->uri->total_rsegments() > 1 && $data['controller'] == 'grades') $data['controller'] .= strtolower( $this->uri->slash_segment(2, 'leading'));
    $data['grades'] = $this->substitutions->get_uniques();
    
    $this->template->write_view('sidebar', 'sidebar', $data, TRUE);
  }
  
  function index() {
    $this->template->render();
  }

}

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

  protected function get_photo_url($photo_id){
    $this->load->helper('url');
    return(site_url("assets/img/user_photos/$photo_id"));
  }

  protected function get_user_data($username = '', $with_subjects = false, $with_comments = false){
      $user = null;
      if(!strlen($username)){
          $user = $this->ion_auth->user()->row();
      } else {
		  $user = $this->ion_auth->where('username', $username)->users()->row();
      }
      
      $questions = $this->config->item('questions');
      
      if(sizeof($user)){
          $is_mod = $this->ion_auth->in_group('moderators', $user->id) || $this->ion_auth->in_group('admin', $user->id);
          $user = array(
            'username' => $user->username,
            'id' => $user->id,
            'loggedin' => $user->active,
            'is_mod' => $is_mod,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            
            'photo1_id' => $user->photo1_id,
            'photo2_id' => $user->photo2_id,
            'photo1_url' => (strlen($user->photo1_id))? $this->get_photo_url($user->photo1_id) : false,
            'photo2_url' => (strlen($user->photo2_id))? $this->get_photo_url($user->photo2_id) : false,
          		
          	'questions' => array(
          		1 => array('q' => $user->q1_q, 'a' => $user->q1_a, 't' => $questions[$user->q1_q]),
          		2 => array('q' => $user->q2_q, 'a' => $user->q2_a, 't' => $questions[$user->q2_q]),
          		3 => array('q' => $user->q3_q, 'a' => $user->q3_a, 't' => $questions[$user->q3_q]),
          		4 => array('q' => $user->q4_q, 'a' => $user->q4_a, 't' => $questions[$user->q4_q]),
          		5 => array('q' => $user->q5_q, 'a' => $user->q5_a, 't' => $questions[$user->q5_q]),
          	)
          );
          if($with_subjects){
              $this->load->model('subjects_model', 'subjects');
              $user['subjects'] = $this->subjects->by_user_id($user['id'], true);
          }
          if($with_comments){
              $this->load->model('comments_model', 'comments');
              $user['comments'] = $this->comments->by_user_id($user['id']);
          }
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

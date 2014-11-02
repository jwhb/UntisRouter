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

  protected function get_user_data($username = '', $with_subjects = false, $with_comments = false){
      $user = null;
      if(!strlen($username)){
          $user = $this->ion_auth->user()->row();
      } else {
		  $user = $this->ion_auth->where('username', $username)->users()->row();
      }
      
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

            'fav_subjects' => $user->fav_subjects,
            'fav_hobbies' => $user->fav_hobbies,
            'fav_child_job' => $user->fav_child_job,
            'fav_occupation' => $user->fav_occupation,
            'fav_lifegoal' => $user->fav_lifegoal,
            'fav_cite' => $user->fav_cite,
            'mem_events' => $user->mem_events,
            'fav_abimotto' => $user->fav_abimotto
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

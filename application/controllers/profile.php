<?php

class Profile extends MY_Controller{

  public function __construct(){
    parent::__construct(false);
    $this->load->library('ion_auth');
  }

  public function index(){
      if(!$this->ion_auth->logged_in()){
          redirect('auth/login', 'refresh');
      }else{
          $data['user'] = $this->get_user_data();

          $this->set_title('Profil: ' . $data['user']['first_name'] . ' ' . $data['user']['last_name']);

          $this->template->write_view('content', 'profile/profile', $data);
          $this->template->render();
      }
  }

  public function view($grade, $d, $m, $y){
    $today = new DateTime('today');
    $date = $this->get_date($d, $m, $y, true);
    $data['grade'] = $grade;
    $data['dates'] = $this->get_date_neighbors($date);

    if(!$date){
      $this->set_title('Ung&uuml;ltiges Datum');
      $this->template->write_view('content', 'substitutions/invalid_date', $data, true);
    }elseif(($today->getTimestamp() - $date->getTimestamp()) >= $this->config->item('public_access_time') && $this->config->item('public_access_time') != 0){
      //Exceeded public access time
      $this->set_title('Zugriff verweigert');
      $this->template->write_view('content', 'substitutions/exceeded_public_access', $data, true);
    }else{

      //Get substitution text
      $this->load->model('substtext_model', 'substtext');
      $substtext = $this->substtext->get_by('date', $date->format('Y-m-d'));
      if(strlen(@$substtext->text)) $data['substtext'] = $substtext->text;

      if($grade == 'all'){
        $this->set_title('Alle Stufen');
        $data['substitutions'] = $this->substitutions->order_by('grade asc, time')->get_many_by(array('date' => $date->format('Y-m-d')));
        $this->template->write_view('content', 'substitutions/list', $data, true);
      }else{
        $substitutions = $this->substitutions->order_by('time')->get_many_by(array('grade' => $grade, 'date' => $date->format('Y-m-d')));

        if(sizeof($substitutions) > 0){
          //Entries found
          $this->set_title(strtoupper($grade));

          $data['substitutions'] = $substitutions;

          $this->template->write_view('content', 'substitutions/single', $data, true);
        }else{
          //No entries found
          $this->set_title('Keine Eintr&auml;ge');

          $data['grade'] = $grade;
          //$data['substitutions'] = $this->substitutions->order_by('time')->get_all();

          $this->template->write_view('content', 'substitutions/not_found', $data, true);
        }
      }
    }
    $this->template->write_view('content', 'substitutions/datenav', $data);
    $this->template->render();
  }

}

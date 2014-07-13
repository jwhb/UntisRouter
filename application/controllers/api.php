<?php
require_once (APPPATH . 'libraries/REST_Controller.php');

class Api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('substitution_model', 'substitutions');
        $this->load->model('substtext_model', 'substtext');
    }

    private function getGradeColor($grade) {
        $grade = $grade{0};
        $groups = ['5' => 1, '6' => 2, '7' => 3, '8' => 4, '9' => 5, 'E' => 6, 'Q' => 7];
        return (isset($groups[$grade])) ? $groups[$grade] : 0;
    }

    function substitutions_get() {
        $grade = $this->get('grade');
        $date = ($this->get('date'))? $this->get('date') : 'ahead';
        $sql_date = ($date != 'ahead')? $date : $this->substitutions->get_today_string();

        $substitutions = $this->substitutions->get_grade($grade, $date);
        $notes = $this->substtext->order_by('date')->get_many_by('date', $sql_date);
        $this->response(array('substitutions' => $substitutions, 'notes' => $notes), 200);
    }

    function grades_get() {
        $grades = $this->substitutions->get_uniques();
        foreach ($grades as $id => $grade) {
            $grades[$id] = array('id' => $id, 'name' => $grade, 'group' => $this->getGradeColor($grade));
        }

        $this->response($grades, 200);
    }
}

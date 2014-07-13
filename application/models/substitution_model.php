<?php

class Substitution_model extends MY_Model {

    public $before_create = array('created_at', 'updated_at');

    public $before_update = array('updated_at');

    public function get_today_string() {
        $date = new DateTime('today');
        return $date->format('Y-m-d');
    }

    public function get_uniques() {
        $grades = array();
        $table = $this->table();
        $query = $this->db->query("SELECT DISTINCT grade FROM $table ORDER BY grade ASC");
        foreach ($query->result() as $row) {
            $grades[] = $row->grade;
        }
        return ($grades);
    }

    public function delete_empty() {
        $this->delete_many_by_many(array('time' => '', 'teacher' => ''));
    }

    public function get_all_ahead() {
        $today = $this->get_today_string();
        $data = $this->order_by('date asc, grade asc, time')->get_many_by("date >= '$today'");
        return ($data);
    }

    public function get_grade($grade = 'all', $date = 'ahead') {
        if ($date == 'ahead') {
            $date = $this->get_today_string();
            $where['date >='] = $date;
        } elseif ($date != 'all') {
            $where['date'] = $date;
        }
        if ($grade != 'all') {
            $where['grade ='] = $grade;
        }
        $data = $this->order_by('date asc, grade asc, time')->get_many_by($where);
        return ($data);
    }
}

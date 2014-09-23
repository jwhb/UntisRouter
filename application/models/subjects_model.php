<?php

class Subjects_model extends MY_Model {

    public function by_user_id($id, $show_all = false) {
        $query = $this->db->query('SELECT subjects.id, subjects.name FROM subjects JOIN users_subjects ON subjects.id = users_subjects.subject_id WHERE user_id = ' . $id . ' ORDER BY name ASC');
        $subjects = array();
        foreach ($query->result() as $row)
            $subjects[$row->id] = $row->name;
        return $subjects;
    }

    public function get_subject_names(){
        $sql_subjects = $this->get_all();
        $subjects = array();
        foreach($sql_subjects as $subject){
            $subjects[] = $subject->name;
        }
        return $subjects;
    }

}

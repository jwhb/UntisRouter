<?php

class Subjects_model extends MY_Model {

    protected function array_delete($array, $element) {
        return array_diff($array, [$element]);
    }

    public function by_user_id($user_id, $ids_only = false) {
        $query = $this->db->query('SELECT subjects.id, subjects.name FROM subjects JOIN users_subjects ON subjects.id = users_subjects.subject_id WHERE user_id = ' . $user_id . ' ORDER BY name ASC');
        $subjects = array();
        foreach ($query->result() as $row)
            ($ids_only) ? $subjects[] = $row->id : $subjects[$row->id] = $row->name;
        return $subjects;
    }

    public function get_subject_names() {
        $sql_subjects = $this->get_all();
        $subjects = array();
        foreach ($sql_subjects as $subject) {
            $subjects[$subject->id] = $subject->name;
        }
        return $subjects;
    }

    public function update_user_subjects($user_id, $new_subjects = array()) {
        $old = $this->by_user_id($user_id, true);
        $add = array();
        foreach ($new_subjects as $i => $new_id) {
            if (! in_array($new_id, $old)) {
                $add[] = $new_id;
            } else {
                $old = $this->array_delete($old, $new_id);
            }
        }

        foreach($old as $old_id){
            $old_id = mysql_real_escape_string($old_id);
            $query = $this->db->query("DELETE FROM users_subjects WHERE user_id = $user_id AND subject_id = $old_id");
        }

        foreach($add as $add_id){
            $add_id = mysql_real_escape_string($add_id);
            $query = $this->db->query("INSERT INTO users_subjects (user_id, subject_id) VALUES ($user_id, $add_id)");
        }
    }
}

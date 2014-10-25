<?php

class Comments_model extends MY_Model {

    protected function array_delete($array, $element) {
        return array_diff($array, [$element]);
    }

    public function by_user_id($user_id, $for_user = true) {
        $from_for_user = ($for_user) ? 'user_for_id' : 'user_from_id';
        $query = $this->db->query("SELECT * FROM users_comments WHERE $from_for_user = $user_id ORDER BY time ASC");
        $comments = array();
        foreach ($query->result() as $row)
            $comments[$row->id] = $row;
        return $comments;
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

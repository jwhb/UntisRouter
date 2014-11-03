<?php

class Comments_model extends MY_Model {

    protected function array_delete($array, $element) {
        return array_diff($array, [$element]);
    }

    public function by_user_id($user_id, $for_user = true) {
        $from_for_user = ($for_user) ? 'user_for_id' : 'user_from_id';
        $query = $this->db->query("SELECT users_comments.*, users.username AS username_from FROM users_comments JOIN users WHERE $from_for_user = $user_id AND users.id = users_comments.user_from_id AND deleted = 0 ORDER BY time ASC");
        $comments = array();
        foreach ($query->result() as $row)
            $comments[$row->id] = $row;
        return $comments;
    }

    public function add_comment($user_from_id, $user_for_id, $comment_text, $hidden) {
        $user_from_id = mysql_real_escape_string($user_from_id);
        $user_for_id = mysql_real_escape_string($user_for_id);
        $comment_text = mysql_real_escape_string(strip_tags($comment_text));
        $hidden = mysql_real_escape_string($hidden);
        
        $time = (new DateTime())->getTimestamp();
        $query = $this->db->query("INSERT INTO users_comments (user_from_id, user_for_id, time, text, hidden) VALUES ($user_from_id, $user_for_id, $time, '$comment_text', '$hidden')");
    }

    public function delete_comment($comment_id) {
        $comment_id = mysql_real_escape_string($comment_id);
        $query = $this->db->query("UPDATE users_comments SET deleted = 1 WHERE id = '$comment_id'");
    }

    public function may_alter($user_id, $comment_id) {
        $user_id = mysql_real_escape_string($user_id);
        $comment_id = mysql_real_escape_string($comment_id);
        
        $this->load->library('ion_auth');
        $is_mod = $this->ion_auth->in_group('moderator', $user_id) || $this->ion_auth->in_group('admin', $user_id);
        
        $query = $this->db->query("SELECT * FROM users_comments WHERE id = '$comment_id'");
        $comment = $query->row();
        return($comment->user_from_id == $user_id || $is_mod);
    }
}

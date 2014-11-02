<?php

class Mottos_model extends MY_Model {

    public function get_motto_names() {
        $sql_mottos = $this->get_all();
        $mottos = array();
        foreach ($sql_mottos as $motto) {
            $mottos[$motto->id] = $motto->text;
        }
        return $mottos;
    }

}

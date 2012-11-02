<?php

class CourseGroup extends CI_Model {
    public function getAll() {
        return $this->db->limit(10000)->get('courseGroups')->result();
    }
    
}

?>

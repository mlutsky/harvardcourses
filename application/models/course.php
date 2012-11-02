<?php

class Course extends CI_Model {
    public function getInfo($id) {
        $courseinfo = $this->db->get_where('courses', array('id' => $id), 6000, 0)->result();
        $coursegroup = $this->db->select('*')->from('courses_courseGroups')->where('courses_courseGroups.course_id', $id)->join('courseGroups', 'courseGroups.id = courses_courseGroups.courseGroup_id')->get()->result();
        $gened = $this->db->select('*')->from('courses_geneds')->where('courses_geneds.course_id', $id)->join('geneds', 'geneds.id = courses_geneds.gened_id')->get()->result();
        $faculty = $this->db->select('*')->from('courses_faculty')->where('courses_faculty.course_id', $id)->join('faculty', 'faculty.id = courses_faculty.faculty_id')->get()->result();
        $time = $this->db->select('*')->from('courses_schedules')->where('courses_schedules.course_id', $id)->join('schedules', 'schedules.id = courses_schedules.schedule_id')->get()->result();
        $location = $this->db->select('*')->from('courses_locations')->where('courses_locations.course_id', $id)->join('locations', 'locations.id = courses_locations.location_id')->get()->result();
        $return = array('courseinfo' => $courseinfo, 'coursegroup' => $coursegroup, 'gened' => $gened, 'faculty' => $faculty, 'time' => $time, 'location' => $location);
        return $return;
    }
    
    public function getCoursesByCourseGroup($courseGroup) {
        return $this->db->select('*')->from('courseGroups')->where('name', $courseGroup)->join('courses_courseGroups','courses_courseGroups.courseGroup_id = courseGroups.id')->join('courses', 'courses.id = courses_courseGroups.course_id')->get()->result();
    }
    
    public function getCoursesByGenEd($gened) {
        return $this->db->select('*')->from('geneds')->where('name', $gened)->join('courses_geneds','courses_geneds.gened_id = geneds.id')->join('courses', 'courses.id = courses_geneds.course_id')->get()->result();
    }
    
    public function getCoursesByTime($time, $day) {
        $array = array('beginTime' => $time, 'day' => $day);
        return $this->db->select('*')->from('schedules')->where($array)->join('courses_schedules','courses_schedules.schedule_id = schedules.id')->join('courses', 'courses.id = courses_schedules.course_id')->get()->result();
    }
    
    public function getCoursesByFaculty($faculty) {
        return $this->db->select('*')->from('faculty')->where('lastName', $faculty)->join('courses_faculty','courses_faculty.faculty_id = faculty.id')->join('courses', 'courses.id = courses_faculty.course_id')->get()->result();
    }
    
    public function getCoursesByRandom() {
        return $this->db->select('*')->from('courses')->order_by('id','random')->limit(4)->get()->result();
    }
    
    public function getCoursesBySearch($query) {
        $courseinfo = $this->db->select('*')->from('courses')->like('title', $query)->or_like('catNum', $query)->or_like('courseNum', $query)->or_like('description', $query)->get()->result();
        $coursegroup = $this->db->select('*')->from('courseGroups')->like('full_name', $query)->join('courses_courseGroups','courses_courseGroups.courseGroup_id = courseGroups.id')->join('courses', 'courses.id = courses_courseGroups.course_id')->get()->result();
        $gened = $this->db->select('*')->from('geneds')->like('name', $query)->join('courses_geneds','courses_geneds.gened_id = geneds.id')->join('courses', 'courses.id = courses_geneds.course_id')->get()->result();
        $faculty = $this->db->select('*')->from('faculty')->like('lastName', $query)->join('courses_faculty','courses_faculty.faculty_id = faculty.id')->join('courses', 'courses.id = courses_faculty.course_id')->get()->result();
        $return = array();
        $results = array($courseinfo, $coursegroup, $gened, $faculty);
        foreach ($results as $result){
            foreach ($result as $class){
                array_push($return, $class);
            }
        }
        return $return;
    }
        
        
    
    
    
}

?>

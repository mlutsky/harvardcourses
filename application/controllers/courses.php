<?php
//test
class Courses extends CI_Controller {
    public function index() {
        /*$this->load->model('Course');
        $courses = $this->Course->getCoursesByGenEd('Aesthetic and Interpretive Understanding');

        var_dump($courses);

        exit;*/
        $this->load->view('courses/header.php', array('page' => 'main'));
        $this->load->view('courses/main.php');
        $this->load->view('courses/footer.php', array('selected'=> 'browsing'));
    }
    
    public function courseGroups() {
        $this->load->model('CourseGroup');
        $courseGroups = $this->CourseGroup->getAll();
        $this->load->view('courses/header.php', array('page' => 'coursegroups'));
        $this->load->view('courses/courseGroups.php', array('courseGroups' => $courseGroups));
        $this->load->view('courses/footer.php', array('selected'=> 'browsing'));
    }
    
    public function geneds() {
        $this->load->model('Gened');
        $geneds = $this->Gened->getAll();
        $this->load->view('courses/header.php', array('page' => 'geneds'));
        $this->load->view('courses/geneds.php', array('geneds' => $geneds));
        $this->load->view('courses/footer.php', array('selected'=> 'browsing'));
    }
    
    public function courseGroupCourses() {
        $this->load->model('Course');
        $d = $this->uri->segment(3);
        $courses = $this->Course->getCoursesByCourseGroup($d);
        $this->load->view('courses/header.php', array('page' => 'coursegroupcourses'));
        $this->load->view('courses/listview.php', array('header' => $d,'courses' => $courses, 'search' => 'false'));
        $this->load->view('courses/footer.php', array('selected'=> 'browsing'));
    }
    
    public function genedCourses() {
        $this->load->model('Course');
        $d = $this->uri->segment(3);
        $d = str_replace("%20", " ", $d);
        $courses = $this->Course->getCoursesByGenEd($d);
        $this->load->view('courses/header.php', array('page' => 'genedcourses'));
        $this->load->view('courses/listview.php', array('header' => $d, 'courses' => $courses, 'search' => 'false'));
        $this->load->view('courses/footer.php', array('selected'=> 'browsing'));
    }
    
    public function timeCourses() {
        $this->load->model('Course');
        $day = $this->input->post('day');
        $time = $this->input->post('time');
        $courses = $this->Course->getCoursesByTime($time, $day);
        $this->load->view('courses/header.php', array('page' => 'timecourses'));
        $this->load->view('courses/listview.php', array('header' => 'results', 'courses' => $courses, 'search' => 'true'));
        $this->load->view('courses/footer.php', array('selected'=> 'browsing'));
    }
    
    public function searchCourses() {
        $this->load->model('Course');
        $query = $this->input->post('search');
        $courses = $this->Course->getCoursesBySearch($query);
        $this->load->view('courses/header.php', array('page' => 'searchcourses'));
        $this->load->view('courses/listview.php', array('header' => 'results', 'courses' => $courses, 'search' => 'true'));
        $this->load->view('courses/footer.php', array('selected'=> 'browsing'));
    }
    
     public function randomCourses() {
        $this->load->model('Course');
        $courses = $this->Course->getCoursesByRandom();
        $this->load->view('courses/header.php', array('page' => 'randomcourses'));
        $this->load->view('courses/listview.php', array('header' => '4 random courses:', 'courses' => $courses, 'search' => 'false'));
        $this->load->view('courses/footer.php', array('selected'=> 'browsing'));
    }

     public function course() {
         $this->load->model('Course');
         $course = $this->uri->segment(3);
         $back = $this->uri->segment(4);
         $courses = $this->Course->getInfo($course);
         $this->load->view('courses/header.php', array('page' => 'course', 'back' => $back));
         $this->load->view('courses/coursetemplate.php', array('courses' => $courses));
         $this->load->view('courses/footer.php', array('selected'=> 'browsing'));
     }
    
    public function timeSearch() {
        $this->load->view('courses/header.php', array('page' => 'timesearch'));
        $this->load->view('courses/time.php');
        $this->load->view('courses/footer.php', array('selected'=> 'browsing'));
    }
    
    public function shopping() {
        $this->load->view('courses/header.php', array('page' => 'shopping'));
        $this->load->view('courses/footer.php', array('selected'=> 'shopping'));
    }
    
     public function taking() {
        $this->load->view('courses/header.php', array('page' => 'taking'));
        $this->load->view('courses/footer.php', array('selected'=> 'taking'));
    }
    
    public function recentlyViewed() {
        $this->load->view('courses/header.php', array('page' => 'recentlyViewed'));
        $this->load->view('courses/footer.php', array('selected'=> 'browsing'));
    }
       
        
}

?>

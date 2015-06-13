<?php

class UserControllerTest extends CIUnit_Framework_TestCase
{
    private $user_controller;
    private $user;

    protected function setUp()
    {
        $this->get_instance()->load->library('../controllers/api/user.php');
        $this->user_controller = new User();
        $this->get_instance()->load->model('User_model', 'user');
        $this->user = $this->get_instance()->user;
    }
    
    public function testIndex()
    {
        $students = $this->user->getStudents();
        $json = json_encode($students);

        //capture the echoed output in a variable
        ob_start();
        $this->user_controller->index();
        $val = ob_get_clean();

        //set the response back to html to avoid echoing in json
        header('Content-Type: text/html');
        $this->assertEquals($json, $val);
    }

    public function testUpdate()
    {
        //pass incorrect parameter
        $_POST['ids'] = 1;

        //capture the echoed output in a variable
        ob_start();
        $this->user_controller->update();
        $this->assertEquals('failed', ob_get_clean());
    }
}
?>
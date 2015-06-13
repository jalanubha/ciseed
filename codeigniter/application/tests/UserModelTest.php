<?php

class UserModelTest extends CIUnit_Framework_TestCase
{
    private $user;
    
    protected function setUp()
    {
        $this->get_instance()->load->model('User_model', 'user');
        $this->user = $this->get_instance()->user;
    }
    
    public function testGetStudents()
    {
        $students = $this->user->getStudents();
        $this->assertInternalType('array', $students);
        $this->assertGreaterThan(0, count($students));
    }

    public function testStudentExists()
    {
        $students = $this->user->getStudents();
        $this->assertEquals(true, $this->user->studentExists($students[0]['user_name']));
        $this->assertEquals(false, $this->user->studentExists('#sdfsdf'));
    }

    public function testUpdateStudents() {
        $students = $this->user->getStudents();
        $this->user->updateStudents($students);
        $updated = $this->user->getStudents();
        $this->assertEquals($students, $updated);
    }
}
?>
<?php

class User_model extends CI_Model
{

    public function __construct ()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
    * @method: getStudents
    * @return array: array of student objects with id, name and pass
    */

    public function getStudents ()
    {
        //read from sql table
        $query = $this->db->get('student');
        return $query->result_array();
    }

    /**
    * @method studentExists: checks if a student exists in the system
    * @param $name (string): name of the student
    * @return boolean: true if student exists, false otherwise
    */

    public function studentExists($name) 
    {
        $this->db->where('user_name', $name);
        $query = $this->db->get('student');
        if ($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
    * @method updateStudents: performs batch update of usernames and passwords
    * @param $student (array): array of student ids
    * @return mixed: count of rows updated or False if failed
    */

    public function updateStudents($students)
    {
        //this return NULL even if update is successful due to codeigniter known issue
        return $this->db->update_batch('student', $students, 'id');
    }
}

?>
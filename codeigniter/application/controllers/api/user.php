<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
		parent::__construct();
		 $this->load->model('user_model');
	}

	/**
	 * @method index: returns the list of students
	 * @return json: list of students in json format
	 */
	public function index()
	{
		$this->db->select('id, user_name, password');
		$ret = $this->user_model->getStudents();

		header('Content-Type: application/json');
    	echo json_encode( $ret );
	}

	/**
    * @method update: Updates the usernames and password to a random string
    * @param $len (int): length of the returned string
    * @return string: a random string of $len characters
    */
	public function update()
	{	
		//get the ids
		$ids = $this->input->post('ids');
		
		if(is_array($ids) && count($ids) > 0) 
		{
			$students = array();

			//generate new username and password for every student
			foreach ($ids as $key => $value)
			{
				//generate and check the user doesn't already exists
				$username = $this->getRandomString();
				while($this->user_model->studentExists($username))
				{
					$username = getRandomString();
				}

				$student = array(
					'id' => $value, 
					'user_name' => $username, 
					'password' => $this->getRandomString()
				);
				array_push($students, $student);
			}

			//perform batch update
			$ret = $this->user_model->updateStudents($students);

			if($ret) {
				echo "updated";
			}
		}
    	echo 'failed';
	}

	/**
    * @method getRandomString: generates a random string of specified length
    * @param $len (int): length of the returned string
    * @return string: a random string of $len characters
    */
	private function getRandomString($len = 8) 
	{
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@';
	    $clen = strlen($chars);
	    $result = '';

	    for ($counter = 0; $counter < $len; $counter++) 
	    {
	        $result .= $chars[rand(0, $clen - 1)];
	    }
	    return $result;
	}
}

/* End of file user.php */
/* Location: ./application/controllers/api/user.php */
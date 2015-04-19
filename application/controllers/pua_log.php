<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pua_log extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function index()
	{
		$this->load->view('jadda');
	}
	public function approaches(){
		$method = $this->input->server('REQUEST_METHOD');
		echo $method;	
		switch($method){
			case 'POST': $this->post_approach();break;
		}
	}

	private function post_approach(){
		//$this->load->database();
	 	//$mysqli = mysqli_connect("localhost", "root", "tyranids", "hitsquad_app");
		//if (mysqli_connect_errno($mysqli)) {
		//    echo "Failed to connect to MySQL: " . mysqli_connect_error();
		//}
		//$query = "insert into approaches (date,user_id) values (0, 0)";
		//$mysqli_query($query);
		//$this->db->query($query);
		$this->load->database();	
		$data = array( 'date' => time(), 'user_id' => 0);	
		$this->db->insert('approaches', $data);
	}
	public function dates(){
		$method = $this->input->server('REQUEST_METHOD');
		switch($method){
			case 'POST': $this->post_date();break;
		}
	}
	private function post_date(){
		$this->load->database();	
		$data = array( 'date' => time(), 'user_id' => 0);	
		$this->db->insert('dates',$data);	
	}
	public function kisscloses(){
		switch($this->input->server('REQUEST_METHOD')){
			case 'POST': $this->post_kissclose();break;
		}
	}
	private function post_kissclose(){
		$this->load->database();	
		$data = array( 'date' => time(), 'user_id' => 0);	
		$this->db->insert('kisscloses',$data);	
	}
	public function fuckcloses(){
		switch($this->input->server('REQUEST_METHOD')){
			case 'POST': $this->post_fuckclose();break;
		}
	}
	private function post_fuckclose(){
		$this->load->database();	
		$data = array('date' => time(), 'user_id' => 0);
		$this->db->insert('fuckcloses',$data);	
	}
//	public function metric(){
//		$points_from_close = function($row,$halftime) {
//			return $row*10 / (2*(time()-$row->date)/$halftime);
//		}
//		$row_summer_generator($halftime) {
//			$row_summer = function($row1,$row2)) use (&$points_from_approach, $halftime){
//				return $points_from_close($row1, $halftime) + $points_from_close($row2,$halftime);
//			};
//			return &$row_summer;	
//		}
//		$halftime_approach = 1000*60*60*24; //one day
//		$halftime_date = 1000*60*60*24*15; //15 days
//		$halftime_kissclose = 1000*60*60*24*30; //30 days
//		$halftime_fuckclose = 1000*60*60*24*365; //one year
//
//		$this->db->where('uid', 0);
//		$query_approaches = $this->db->get('approaches');
//		$points_approaches = array_foldl($query_approaches->result(), $row_summer_generator($halftime_approaches));
//
//
//		$this->db->where('uid', 0);
//		$query_date = $this->db->get('date');
//		$points_date = array_foldl($query_approaches->result(), $row_summer_generator($halftime_date));
//
//		$this->db->where('uid', 0);
//		$query_kisscloses = $this->db->get('kisscloses');
//		$points_kisscloses = array_foldl($query_kisscloses->result(), $row_summer_generator($halftime_kisscloses));
//
//		$this->db->where('uid', 0);
//		$query_fuckcloses = $this->db->get('fuckcloses');
//		$points_fuckcloses = array_foldl($query_fuckcloses->result(), $row_summer_generator($halftime_kisscloses));
//		
//		$points = $points_approaches + $points_kisscloses + $points_date + $points_fuckcloses; 
//		
//		$data = array('points' => $points);
//
//		$this->load_view('metric_view', $data);
//	}
}

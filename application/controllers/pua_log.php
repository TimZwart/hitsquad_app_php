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
	private function login_check()
	{
		if(!$this->session->userdata('logged_in')) {
			redirect('login', 'refresh');
		}
	}
	public function index()
	{
		$this->login_check();
		$this->load->view('jadda');
	}
	public function approaches(){
		$this->login_check();
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
		$this->login_check();
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
		$this->login_check();
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
		$this->login_check();
		switch($this->input->server('REQUEST_METHOD')){
			case 'POST': $this->post_fuckclose();break;
		}
	}
	private function post_fuckclose(){
		$this->load->database();	
		$data = array('date' => time(), 'user_id' => 0);
		$this->db->insert('fuckcloses',$data);	
	}
	private function points_from_close ($row,$halftime,$value) {
		$periods = (time()-$row->date)/$halftime;
		$ret=$value / (pow(2,$periods)); 
		return $ret;
	}
	
	
	public function metric(){
		$this->load->database();	
		
		
		$halftime_approach = 60*60*24; //one day
		$halftime_date = 60*60*24*15; //15 days
		$halftime_kissclose = 60*60*24*30; //30 days
		$halftime_fuckclose = 60*60*24*365; //one year

		$points_per_approach = 1;
		$points_per_kclose = 30;
		$points_per_date = 10;
		$points_per_fclose = 300;

		$this->db->where('user_id', 0);
		$query_approaches = $this->db->get('approaches');
		$points_approaches = 0;
		foreach($query_approaches->result() as $res){
			$points_approaches+=$this->points_from_close($res,$halftime_approach,$points_per_approach);
		}

		$this->db->where('user_id', 0);
		$query_date = $this->db->get('dates');
		$points_date = 0;
		foreach($query_date->result() as $res){
			$points_date+=$this->points_from_close($res,$halftime_date,$points_per_date);
		}

		$this->db->where('user_id', 0);
		$query_kisscloses = $this->db->get('kisscloses');
		$points_kisscloses = 0;
		foreach($query_kisscloses->result() as $res){
			$points_kisscloses+=$this->points_from_close($res,$halftime_kissclose,$points_per_kclose);
		}

		$this->db->where('user_id', 0);
		$query_fuckcloses = $this->db->get('fuckcloses');
		$points_fuckcloses = 0;
		foreach($query_fuckcloses->result() as $res){
			$points_fuckcloses+=$this->points_from_close($res,$halftime_fuckclose,$points_per_fclose);
		}
		
		$points = $points_approaches + $points_kisscloses + $points_date + $points_fuckcloses; 
		$data = array('points' => $points);

		$json = json_encode($data);	
		$this->output->set_content_type('application/json')->set_output($json);
//		
	}
}

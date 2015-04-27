<?php

function metric(){
		$points_from_close = function($row,$halftime) {
			return $row*10 / (2*(time()-$row->date)/$halftime);
		};
		$row_summer_generator = function($halftime) use (&$points_from_close){
			$row_summer = function($row1,$row2)) use (&$points_from_close, $halftime){
				$points_from_close($row1, $halftime) + $points_from_close($row2,$halftime);
			};
			return 0;//&$row_summer;	
		};
		$halftime_approach = 1000*60*60*24; //one day
		$halftime_date = 1000*60*60*24*15; //15 days
		$halftime_kissclose = 1000*60*60*24*30; //30 days
		$halftime_fuckclose = 1000*60*60*24*365; //one year

		$this->db->where('uid', 0);
		$query_approaches = $this->db->get('approaches');
		$points_approaches = array_reduce($query_approaches->result(), $row_summer_generator($halftime_approaches));


		$this->db->where('uid', 0);
		$query_date = $this->db->get('dates');
		$points_date = array_reduce($query_approaches->result(), $row_summer_generator($halftime_date));

		$this->db->where('uid', 0);
		$query_kisscloses = $this->db->get('kisscloses');
		$points_kisscloses = array_reduce($query_kisscloses->result(), $row_summer_generator($halftime_kisscloses));

		$this->db->where('uid', 0);
		$query_fuckcloses = $this->db->get('fuckcloses');
		$points_fuckcloses = array_reduce($query_fuckcloses->result(), $row_summer_generator($halftime_kisscloses));
		
		$points = $points_approaches + $points_kisscloses + $points_date + $points_fuckcloses; 
		
		$data = array('points' => $points);

		$data = array('foo' => 'bar');
		$json = json_encode($data);	
		$this->output->set_content_type('application/json')->set_output($json);
//		
	}
metric();
?>

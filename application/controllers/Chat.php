<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Chat extends CI_Controller {

	public function index()
	{
		$data = array (
			'chat' => $this->db->order_by('id','desc')->get('chat')->result()
		);
		$this->load->view('chat', $data);
	}
	public function store(){
		$data = array(
			'name' => $this->input->post('name'),
			'message' => $this->input->post('message') 
		);

		$options = array(
			'cluster' => 'ap1',
			'useTLS' => true
		);
		$pusher = new Pusher\Pusher(
			'31083d6937811666ff88',
			'30abc1d6fbebfb3ef946',
			'951129',
			$options
		);

		if ($this->db->insert('chat', $data)) {
			
			$push = $this->db->order_by('id','desc');
			$push = $this->db->get('chat')->result();

			foreach ($push as $key) {
				$data_pusher[] = $key;
			}
			$pusher->trigger('my-channel', 'my-event', $data_pusher);
		}
	}
}

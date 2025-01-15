<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_campaign extends CI_Model
{
	
	public function getAll()
	{
		$query = $this->db->get('campaigns')->result_array();
		return $query;
	}
	
	public function byId($id)
	{
		$this->db->select('*');
		$this->db->from('campaigns');
		$this->db->where('id', $id);
		$query = $this->db->get()->row_array();
		return $query;
	}
	
	public function byUserId($id)
	{
		$this->db->select('campaigns.*, event.poto as poto');
		$this->db->from('campaigns');
		$this->db->where('campaigns.user_id', $id);
		$this->db->join('event', 'campaigns.event_id = event.id');
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	public function bySchedule($date)
	{
		$this->db->where('schedule <=', $date);
		$this->db->where('status', 'waiting');
		$query = $this->db->update('campaigns', array('status' => 'starting'));
		return $query;
	}
	
	public function byLeaderId($id)
	{
		$this->db->select('campaigns.*, event.poto as poto');
		$this->db->from('campaigns');
		$this->db->where('campaigns.leader_id', $id);
		$this->db->join('event', 'campaigns.event_id = event.id');
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function getHistoryByTamuId($id, $campaign_id)
	{
		$this->db->where('id', $id)->where('campaign_id', $campaign_id);
		$query = $this->db->get('blast_history')->row_array();
		return $query;
	}
	
	public function update_status($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('campaigns', $data);
	}
}
?>
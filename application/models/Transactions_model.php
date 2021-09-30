<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Transactions_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
 
	// get_transaction
	public function get_transaction() {
	  return $this->db->query("SELECT * from xin_finance_transaction order by transaction_id desc");
	}
	
	// Function to add record in table
	public function add_transactions($data){
		$this->db->insert('xin_finance_transaction', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}
?>
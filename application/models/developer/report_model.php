 <?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

	public function count() {
        $this->db->select('*');
		$this->db->where(['nm_payments.payment_status'=>1,'nm_theme.developer_id'=>$this->session->userdata('developer_id')]);
		$this->db->join('nm_payments','nm_payments.payment_id=nm_orders.payment_id');
		$this->db->join('nm_order_detail','nm_order_detail.order_id=nm_orders.order_id');
		$this->db->join('nm_theme','nm_theme.theme_id=nm_order_detail.theme_id');
		
        return $this->db->count_all_results('nm_orders');
    }
	
	public function themes($value, $offset,$type) {
		if($type == 0){//untuk laporan keseluruhan
			$this->db->select('*,count(nm_theme.theme_id) as total');
		}else if($type == 1){//1 untuk laporan perbulan
			$this->db->select('*,count(nm_theme.theme_id) as total,year(nm_orders.order_date) as tahun,month(nm_orders.order_date) as bulan');
		}else if($type == 2){
			$this->db->select('*,count(nm_theme.theme_id) as total,year(nm_orders.order_date) as tahun');
		}
        $this->db->where(['nm_payments.payment_status'=>2,'nm_theme.developer_id'=>$this->session->userdata('developer_id')]);
		$this->db->join('nm_payments','nm_payments.payment_id=nm_orders.payment_id');
		$this->db->join('nm_order_detail','nm_order_detail.order_id=nm_orders.order_id');
		$this->db->join('nm_theme','nm_theme.theme_id=nm_order_detail.theme_id');
		$this->db->group_by('nm_theme.theme_id');
		if($type == 1){
			$this->db->group_by('tahun');
			$this->db->group_by('bulan');
		}else if($type ==2){
			$this->db->group_by('tahun');
		}
		$this->db->limit($value, $offset);
		
        return $this->db->get('nm_orders');
    }
	
	public function month($id){
		$data = '';
		if($id == 1){
			$data = "January";
		}else if($id == 2){
			$data = "February";
		}else if($id == 3){
			$data = "March";
		}else if($id == 4){
			$data = "April";
		}else if($id == 5){
			$data = "May";
		}else if($id == 6){
			$data = "June";
		}else if($id == 7){
			$data = "July";
		}else if($id == 8){
			$data = "August";
		}else if($id == 9){
			$data = "September";
		}else if($id == 10){
			$data = "October";
		}else if($id == 11){
			$data = "November";
		}else if($id == 12){
			$data = "December";
		}
		return $data;
	}

}
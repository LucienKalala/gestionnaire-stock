<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DataHandle extends CI_Model {

    public function loadData($table){
		if ($table == 'article') {
			$this->db->order_by('id');
			$this->db->order_by('article');
		}else{
			$this->db->order_by('id','desc');
		}
		
		return $this->db->get($table)->result_array();
	}

	public function bestsoldProduct($l){
		$this->db->order_by('id','desc');
		$this->db->limit($l);
		$this->db->group_by('article_id');
		return $this->db->get('vente')->result_array();
	}

	public function event($data){
		return $this->db->insert('journal',$data);
	}

    public function loadDataInnerJoin($table,$join_table,$join_description){
        $this->db->join($join_table,$join_description); 
		return $this->db->get($table)->result_array();
	}

	public function loadDataInnerJoinWhere($table,$join_table,$join_description,$where = array()){
        $this->db->join($join_table,$join_description); 
		return $this->db->get_where($table, $where)->result_array();
	}

	public function loadDataInnerJoinLike($table,$join_table,$join_description,$where = array()){
        $this->db->join($join_table,$join_description); 
		$this->db->like($where);
		$this->db->order_by('journal.id','desc');
		return $this->db->get($table)->result_array();
	}

	public function loadDataWhere($table, $conditon= ''){
		if ($table == 'achat') {
			$this->db->join('user','user.id = achat.user_id');
		}else if ($table == 'vente') {
			$this->db->join('user','user.id = vente.user_id');
		}else if ($table == 'article') {
			$this->db->join('user','user.id = article.user_id');
		}else if ($table == 'depense') {
			$this->db->join('user','user.id = depense.user_id');
		}else if ($table == 'journal') {
			$this->db->join('user','user.id = journal.user_id');
		}else if ($table == 'user') {
			//$this->db->join('user','user.id = user.user_id');
		}else if ($table == 'vue_global') {
			$this->db->join('user','user.id = vue_global.user_id'); 
		}
		
		return $this->db->get_where($table,$conditon)->result_array();
	}

	public function VenteMoney($conditon){
		$this->db->like(array('sold_date'=>$conditon));
		$vente = $this->db->get('vente')->result_array();
		$v= 0;
		foreach($vente as $key => $rows){
			$v = $v + ($vente[$key]['pvu'] * $vente[$key]['quantite_vendu']);
		}
		return $v;
	}

	public function VenteMoneywhere($conditon,$conditon2 = array()){
		$this->db->like(array('sold_date'=>$conditon));
		$this->db->where($conditon2);
		$vente = $this->db->get('vente')->result_array();
		$v= 0;
		foreach($vente as $key => $rows){
			$v = $v + ($vente[$key]['pvu'] * $vente[$key]['quantite_vendu']);
		}
		return $v;
	}

	public function VenteAmount($conditon){
		$this->db->like(array('sold_date'=>$conditon));
		$vente = $this->db->get('vente')->result_array();
		$n_vente = 0;
		foreach($vente as $key => $rows){
			$n_vente = $n_vente + $vente[$key]['quantite_vendu'];
		}
		return $n_vente;
	}

	public function VenteAmountwhere($conditon,$conditon2 = array()){
		$this->db->like(array('sold_date'=>$conditon));
		$this->db->where($conditon2);
		$vente = $this->db->get('vente')->result_array();
		$n_vente = 0;
		foreach($vente as $key => $rows){
			$n_vente = $n_vente + $vente[$key]['quantite_vendu'];
		}
		return $n_vente;
	}

	public function loadDataLike($table,$conditon=array()){
		$this->db->order_by('id','DESC');
		$this->db->like($conditon);
		return $this->db->get_where($table)->result_array();
	}

    public function insertData($table,$data=array()){
		return $this->db->insert($table,$data);
	}

    public function deleteData($table,$conditon=array()){
		return $this->db->delete($table,$conditon);
	}

    public function updateData($table,$data=array(),$conditon=array()){
		return $this->db->update($table,$data,$conditon);
	}


}
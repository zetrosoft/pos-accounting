<?php
class Admin_model extends CI_Model 
{
    var $tabel_name = 'users';
    function  __construct() 
	{
        parent::__construct();
    }
	
    function cek_user_login($username, $password) 
	{
        $this->db->select('*');
        $this->db->where('userid', $username);
        $this->db->where('password', md5($password));
        $query = $this->db->get('users');
        return $query;
		/*
		if ($query->num_rows() == 1){
            return TRUE;//$query;
        }else{
			return "User Name or Password incorrect\nPlease try again";
		}*/
    }
	
	function userlist($limit,$offset){
		$this->db->where('idlevel !=','1');
		$this->db->select('*');
		$this->db->order_by('userid');
		//$this->db->limit($limit,$offset);
		$query=$this->db->get('users');
		return $query;
	}
	function ulang($kondisi){
		$this->kondisi=$kondisi;	
	}
	
	function filterby($where,$field){
		$this->where=$where;
		$this->field=$field;
	}
	
	function total_data($tabel,$where='',$field=''){
		if($where!=''){
			$query=$this->db->where($field,$where);
		}else{
				$query=$this->db->where($this->field,$this->where);
		}
		$query=$this->db->count_all_results($tabel);
		return $query;	
	}
	function show_single_field($table,$field='*',$where){
		$nom='';
		$sql="select $field from $table $where";
		//echo $sql;
		$rs=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_array($rs)){
			$nom=$row[$field];	
		}
		return $nom;
	}
	public function penomoran($tipe='GR',$table='nomor_transaksi',$field='nomor',$where=''){
		($where=='')?$where=" where jenis_transaksi='$tipe' order by nomor desc limit 1":$where=$where;
		$nom=$this->show_single_field($table,$field,$where);
		$thn=$this->show_single_field($table,"doc_date",$where);
		if($nom >0 && substr($thn,0,4) ==date('Y')){
			$nomor=($nom+1);
		}else{
				if($tipe=='GR'){
					$nomor=5000000000;
				}else if($tipe=='GI'){
					$nomor=4000000000;
				}else if($tipe=='GRR'){
					$nomor=7000000000;
				}else if($tipe=='GIR'){
					$nomor=6000000000;
				}else if($tipe='D' ||$tipe='DR'){
					$nomor=2000000000;
				}else if($tipe='K' ||$tipe='KR'){
					$nomor=3000000000;
				}
		}
		return $nomor;

	}
	function user_exists($uid=''){
		($uid=='')?$uid=$this->session->userdata('userid'):$uid=$uid;
		$this->db->where("userid",$uid);
		$q=$this->db->count_all_results("users");
		;
		return $q;
	}
	function field_exists($table,$where='',$field='*'){
		$q=$this->db->query("select $field from $table $where");
		if ($q->num_rows() > 0) {
			$row=$q->row();
			$hasil=$row->$field;
		}else{ $hasil='';}
		return $hasil;
	}
	function cek_pwd($uid=''){
		($uid=='')?$uid=$this->session->userdata('userid'):$uid=$uid;
		$q=$this->db->query("select password from users where userid='$uid'");
		$row=$q->row();
		$hasil=$row->password;
		return $hasil;
	}
	function cek_oto($menu,$fields,$uid=''){
		check_logged_in($this->session->userdata('userid'));
		($uid=='')?$uid=$this->session->userdata('userid'):$uid=$uid;
		$q=$this->db->query("select $fields from useroto where idmenu='$menu' and userid='$uid'");
		if ($q->num_rows() > 0) {
			$row=$q->row();
			$hasil=$row->$fields;
		}else{ $hasil='';}
		return $hasil;
	}
	function is_oto($menu,$field,$userid=''){
		check_logged_in($this->session->userdata('userid'));
		$oto='';
		($userid=='')?$uid=$this->session->userdata('userid'):$uid=$userid;
		$sql="select $field from useroto where idmenu='$menu' and userid='$uid'";	
		//echo $sql;
		$rs=mysql_query($sql) or die(mysql_error());
		while ($row=mysql_fetch_array($rs)){
			$oto=$row[$field];	
		}
		return $oto;
	}
	function is_oto_all($menu,$link_oto,$userid=''){
		check_logged_in($this->session->userdata('userid'));
		($userid=='')?$uid=$this->session->userdata('userid'):$uid=$userid;
		if($uid=='Superuser'){
			$link_oto;
		}else{
			if($this->is_oto($menu,'c',$uid)=='Y' ||
			   $this->is_oto($menu,'e',$uid)=='Y' ||
			   $this->is_oto($menu,'v',$uid)=='Y' ||
			   $this->is_oto($menu,'p',$uid)=='Y' ||
			   $this->is_oto($menu,'d',$uid)=='Y' ){
				   $link_oto;
			   }else{
				  //$this->load->view("admin/no_authorisation");
				  no_auth();
			   }
		}
	}
	function update_nomor($data,$table='nomor_transaksi'){
		$this->simpan_data($table,$data);
	}
	function simpan_data($tabel,$tabeldata){
		$simpan=$this->db->insert($tabel,$tabeldata);
		return $simpan;
	}
	function simpan_update($tabel,$data,$field){
		$this->db->where($field,$data[$field]);
		$q=$this->db->update($tabel,$data);
		return $q;
	}
	function isi_list($tabel,$where='',$field='*'){
		$q=$this->db->query("select $field from $tabel $where");
		return $q;
	}
	function show_list($tabel,$where='',$field='*'){
		//echo "select $field from $tabel $where";
		$q=$this->db->query("select $field from $tabel $where");
		return $q->result();	
	}
	function hapus_table($tabel,$field,$isi){
		$this->db->where($field,$isi);
		$this->db->delete($tabel);	
	}
	function update_table($table,$where,$field,$data){
		$this->db->where($where, $field);
		$q=$this->db->update($table, $data);
		return $q;	
	}
	function tgl_to_mysql($tgl='',$delimiter='/'){
		if($tgl==''){$tgle=date('Ymd');}else{
			$tgl=str_replace($delimiter,"",$tgl);
			$tgle=substr($tgl,4,4).substr($tgl,2,2).substr($tgl,0,2);
		}
		return $tgle;
	 }
	function create_useroto(){
	$sql="CREATE TABLE IF NOT EXISTS `useroto` (
		`userid` VARCHAR(50) NULL DEFAULT NULL,
		`idmenu` VARCHAR(50) NULL DEFAULT NULL,
		`c` ENUM('Y','N') NULL DEFAULT 'N',
		`e` ENUM('Y','N') NULL DEFAULT 'N',
		`v` ENUM('Y','N') NULL DEFAULT 'N',
		`p` ENUM('Y','N') NULL DEFAULT 'N',
		`d` ENUM('Y','N') NULL DEFAULT 'N')
		COLLATE='latin1_swedish_ci'
		ENGINE=MyISAM;";	
		mysql_query($sql) or die(mysql_error());
	}
	function user_level(){
		$sql="CREATE TABLE IF NOT EXISTS `user_level`(
			`idlevel` INT(50) NOT NULL AUTO_INCREMENT,
			`nmlevel` VARCHAR(150) NULL DEFAULT NULL,
			PRIMARY KEY (`idlevel`))
		COLLATE='latin1_swedish_ci'
		ENGINE=InnoDb;";	
		mysql_query($sql) or die(mysql_error());
	}
	
	function upd_data($table,$field,$where){
		$q="update $table $field $where";
		//echo $q;
			mysql_query($q) or die(mysql_error());
	}
	function hps_data($table,$where=''){
		$q="delete from $table $where";
			mysql_query($q) or die(mysql_error());
	}
	function find_match($str,$table='material',$field='nmbarang'){
		$this->db->select($field." from ".$table." where ".$field." like '".$str."%' order by ".$field,FALSE);
		return $this->db->get();
	}
	function find_match_spb($str){
		$this->db->select("s.no_spb from spb as s where stat_spb not in('L','C') and s.no_spb like '".$str."%'  order by no_spb",FALSE);
		return $this->db->get();
	}
	
	//sql replace into method
	function replace_data($table,$data=array()){
		$fld='';$value='';
		foreach(array_keys($data) as $key){
			$fld .=$key.',';
		}
		foreach(array_values($data) as $val){
			$value .="'".$val."',";
		}
		$fld=substr($fld,0,(strlen($fld)-1));
		$value=substr($value,0,(strlen($value)-1));
		$sql="replace into $table (".$fld.") values(".$value.")";
		//echo $sql;
		return mysql_query($sql) or die($sql.mysql_error());	
	}
}

?>
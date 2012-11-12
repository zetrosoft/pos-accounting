<?php
// Inventori model

class Purch_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}
	function  get_pemasok($str,$limit){
		$data=array();
		$sql="select * from mst_anggota where Nama like '".$str."%' and ID_Jenis='2' order by Nama limit $limit";
		$rs=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($rs)){
				$data[]=array('data'		=>$row->Nama,
							  'description' =>$row->Alamat." ".$row->Kota." ".$row->Propinsi,
							  'id_pemasok'	=>$row->ID
							  );
		}
		return $data;
	}
	
	function get_material_kode($kode){
		$data=array();
		$sql="select * from inv_barang where Kode='$kode'";
		$data=$this->db->query($sql);
		return $data->result();
	}
	
	function get_satuan_konv($nm_barang){
		$data=array();
		$sql="select ik.sat_beli,ik.isi_konversi,n.Satuan from inv_konversi as ik 
			  left join inv_barang_satuan as n
			  on n.ID=ik.sat_beli
			  where nm_barang='$nm_barang'";
		$data=$this->db->query($sql);
		return $data->result();
	}
	function get_total_belanja($notrans,$tanggal){
		$data=array();
		$sql="select sum(Jml_faktur*Harga_Beli) as total from inv_pembelian as p
			 left join inv_pembelian_detail as pd
			 on pd.ID_Beli=p.ID
			 where p.NoUrut='$notrans' and p.Tanggal='".tgltoSql($tanggal)."'";
		$data=$this->db->query($sql);
		return $data->result();
	}
	function detail_trans_vendor($where){
		$sql="select b.Nama_Barang,bs.Satuan,b.Kode,pd.Jumlah,pd.Harga_Beli,p.Tanggal,p.Nomor from
			  inv_pembelian as p
			  left join inv_pembelian_detail as pd
			  on pd.ID_Beli=p.ID
			  left join inv_barang as b
			  on b.ID=pd.ID_Barang
			  left join inv_barang_satuan as bs
			  on bs.ID=b.ID_Satuan
			  $where";
			  
		$data=$this->db->query($sql);
		return $data->result();
	}
	
	function  graph_pembelian($where=''){
		
	}
}
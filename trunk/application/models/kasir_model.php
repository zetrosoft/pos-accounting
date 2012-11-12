<?php
// Fronoffice model

class Kasir_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}
	
	function get_trans_jual($no_trans,$tanggal){
		$sql="select dt.* from inv_penjualan as p
			 left join inv_penjualan_detail as dt
			 on dt.ID_Jual=p.ID
			 where p.NoUrut='$no_trans' and p.Tanggal='$tanggal' order by dt.ID";
		$data=$this->db->query($sql);
		return $data->result();
	}
	
	function rekap_trans_beli($where,$group='',$order='order by p.Tanggal'){
		$sql="select p.Tanggal,sum(dt.Jumlah*dt.Harga_Beli) as Harga_Beli,p.Nomor,v.Nama
			 from inv_pembelian as p
			 left join inv_pembelian_detail as dt
			 on dt.ID_Beli=p.ID
			 left join mst_anggota as v
			 on v.ID=p.ID_Pemasok
			 $where $group $order";
		//echo $sql;
		$data=$this->db->query($sql);
		return $data->result();
	}
	function rekap_trans_jual($where,$group='',$order='order by p.Tanggal'){
		$sql="select dt.ID_Barang,sum(Jumlah) as Jumlah,dt.Harga from inv_penjualan as p
		     left join inv_penjualan_detail as dt
			 on dt.ID_Jual=p.ID
			 right join inv_barang as b
			 on b.ID=dt.ID_Barang
			 $where $group $order";
		//echo $sql;
		$data=$this->db->query($sql);
		return $data->result();
	}
	function rekap_kreditur($where,$group='',$order=''){
		$sql="select a.Nama,a.ID_Dept,dt.ID_Barang,sum(Jumlah),dt.Harga,
			 sum(Jumlah*harga) as Total,p.Cicilan
			 from inv_penjualan as p
		     left join inv_penjualan_detail as dt
			 on dt.ID_Jual=p.ID
			 right join inv_barang as b
			 on b.ID=dt.ID_Barang
			 left join mst_anggota as a
			 on a.ID=p.ID_Anggota
			 $where $group $order";
		//echo $sql;
		$data=$this->db->query($sql);
		return $data->result();
	}
	function edit_pemakaian($where){
		$sql="select zp.*,b.Nama_Barang,s.Satuan,b.Kode
			  from z_inv_pemakaian as zp
			  left join inv_barang as b
			  on b.ID=zp.ID_Barang
			  left join inv_barang_satuan as s
			  on s.ID=b.ID_Satuan
			  $where";	
		$data=$this->db->query($sql);
		return $data->result();
	}
	
	function get_kreditur($where,$orderby=''){
		$sql="select p.ID,p.ID_Anggota,b.Nama,b.NIP,c.Departemen,d.Keaktifan	
			  from inv_penjualan as p
			  left join mst_anggota as b
			  on b.ID=p.ID_Anggota
			  left join mst_departemen as c
			  on c.ID=b.ID_dept
			  left join keaktifan as d
			  on d.ID=b.ID_Aktif
			  $where
			  $orderby";
			//echo $sql;
		$data=$this->db->query($sql);
		return $data->result();
	}
	
	function get_trans_jual_kreditur($ID){
		$sql="select p.Tanggal,p.Nomor,b.Nama_Barang,bs.Satuan,
			  pd.Jumlah,pd.Harga
			  from inv_penjualan as p
			  left join inv_penjualan_detail as pd
			  on pd.ID_jual=p.ID
			  left join inv_barang as b
			  on b.ID=pd.ID_Barang
			  left join inv_barang_satuan as bs
			  on bs.ID=b.ID_Satuan
			  where p.ID_Anggota='$ID' and p.ID_Jenis in('2','3') and pd.Jumlah <>'0'
			  order by p.Tanggal";	
		$data=$this->db->query($sql);
		return $data->result();
	}
	function get_trans_jurnal($ID){
		$sql="select t.*,n.Nama,j.Nomor,j.Tanggal from perkiraan as p
				left join transaksi as t
				on t.ID_Perkiraan=p.ID
				left join jurnal as j
				on j.ID=t.ID_Jurnal
				left join mst_anggota as n
				on n.ID=p.ID_Agt
				where p.ID_Agt='$ID' and p.ID_Simpanan='4'
				order by j.Tanggal";
		$data=$this->db->query($sql);
		return $data->result();
	}
	
	
}
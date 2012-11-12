<?php
class Report_model extends CI_Model {
    function  __construct() 
	{
        parent::__construct();
    }

	function countsheet($where){
		$sql="select im.nm_jenis as nm_jenis,
					  im.nm_kategori as nm_kategori,
					  im.id_barang as id_barang,
					  im.nm_barang as nm_barang,
					  im.nm_satuan as nm_satuan,
					  ims.stock as stock,
					  ims.blokstok as blokstok 
			from inv_barang as im
			left join inv_material_stok as ims
			on im.nm_barang=ims.nm_barang
			$where order by im.nm_barang";
		return $this->db->query($sql);
	}
	function select_trans($where,$rpt='No'){
		$sql="select dt.*,dt.expired as expired,im.id_barang from detail_transaksi as dt 
			 	left join inv_material as im
				on im.nm_barang=dt.nm_barang
				$where";
		echo $sql;
		
		return ($rpt=='No')?$sql:$this->db->query($sql);
	}
	function stock_list($where,$tipe,$orderby='order by im.Nama_Barang'){
		switch($tipe){
			case "stock":	
			$sql="select im.ID_Kategori,im.ID,im.ID_Satuan,im.Nama_Barang,im.Kode,
				  sum(ms.stock) as stock,im.Status,s.Satuan,k.Kategori,
				  sum(ms.harga_beli) as harga_beli,ms.batch
				  from inv_barang as im
				  left join inv_material_stok as ms
				  on ms.id_barang=im.ID
				  left join inv_barang_satuan as s
				  on s.ID=im.ID_Satuan
				  left join inv_barang_kategori as k
				  on k.ID=im.ID_Kategori
				  $where 
				  group by im.ID,ms.batch
				  $orderby";
			break;
			case "edit":
			$sql="select im.ID,im.Nama_Barang,im.Kode,im.Status,
				  sum(ms.stock) as stock,ms.harga_beli,ms.batch,
				  k.Kategori,s.Satuan
				  from inv_barang as im
				  left join inv_material_stok as ms
				  on ms.id_barang=im.ID
				  left join inv_barang_satuan as s
				  on s.ID=im.ID_Satuan
				  left join inv_barang_kategori as k
				  on k.ID=im.ID_Kategori
				  $where
				  group by im.ID,ms.batch
				  $orderby";
			break;
			case 'stocklimit':
			$sql="select im.nm_jenis,im.nm_kategori,
				  im.id_barang,im.nm_satuan,im.nm_barang,
				  sum(ms.stock) as stock,im.stokmin,
				  sum(if(stock>0,(harga_beli*stock),null)) as harga_beli
				  from inv_material as im
				  left join inv_material_stok as ms
				  on ms.nm_barang=im.nm_barang
				  $where 
				  group by im.nm_barang
				  order by (ms.stock-im.stokmin) desc";
			break;
			case 'lap_kas':
			$sql="select * from ".$this->session->userdata('userid')."_tmp_lapkas $where $orderby";
			break;
		}
		//echo $sql;
		$data=$this->db->query($sql);	
		return $data->result();
	}
	
	function create_tmp_table(){
		$sql="CREATE TABLE IF NOT EXISTS `".$this->session->userdata('userid')."_tmp_lapkas` (
				`id` INT(10) NULL AUTO_INCREMENT,
				`tgl` DATE NULL,
				`uraian` VARCHAR(50) NULL,
				`no_trans` VARCHAR(50) NULL,
				`kredit` DOUBLE NULL,
				`debit` DOUBLE NULL,
				`saldoakhir` DOUBLE NULL,
				`doc_date` TIMESTAMP NULL,
				PRIMARY KEY (`id`)
				)
				COLLATE='latin1_swedish_ci'
				ENGINE=MyISAM;";
			mysql_query($sql) or die(mysql_error());
			mysql_query("truncate table ".$this->session->userdata('userid')."_tmp_lapkas") or die(mysql_error());
	}
	function copy_to_tmp_table($dari,$totgl){
		$sal="select * from mst_kas_harian where tgl_kas between '$dari' and '$totgl'";
		$rr=mysql_query($sal) or die(mysql_error());
		while($rw=mysql_fetch_object($rr)){
			$kas="insert into ".$this->session->userdata('userid')."_tmp_lapkas (tgl,uraian,kredit,doc_date) values('".$rw->tgl_kas."','Saldo awal kas','".$rw->sa_kas."','".$rw->doc_date."')";
				  mysql_query($kas);	
		}
		$sql="select * from detail_transaksi where tgl_transaksi between '$dari' and '$totgl' order by tgl_transaksi";
			  $rs=mysql_query($sql) or die(mysql_error());
			  while($row=mysql_fetch_object($rs)){
				  if($row->jenis_transaksi=='GI' || $row->jenis_transaksi=='K' ||$row->jenis_transaksi=='DR'){
					  $kredit=($row->jml_transaksi*$row->harga_beli);
					  ($row->jenis_transaksi=='K')?$uraian=$row->ket_transaksi:$uraian='Penjualan ';
						$kas1="insert into ".$this->session->userdata('userid')."_tmp_lapkas (tgl,uraian,no_trans,kredit,doc_date) values('".$row->tgl_transaksi."','".$uraian."','".$row->no_transaksi."','".$kredit."','".$row->doc_date."')";
							  mysql_query($kas1);	
				  }
				  //$row->jenis_transaksi=='GR' || $row->jenis_transaksi=='GRR' ||
				  if( $row->jenis_transaksi=='D' || $row->jenis_transaksi=='GIR'){
					  $debit=($row->jml_transaksi*$row->harga_beli);
					  ($row->jenis_transaksi=='D')?$uraian2=$row->ket_transaksi:$uraian2='Pembelian';//$row->nm_barang;
						$kas2="insert into ".$this->session->userdata('userid')."_tmp_lapkas (tgl,uraian,no_trans,debit,doc_date) values('".$row->tgl_transaksi."','".$uraian2."','".$row->no_transaksi."','".$debit."','".$row->doc_date."')";
							  mysql_query($kas2);	
				  }
			  }
	   //echo $kas2;
	}
	function laporan_kas($where='',$orderby='order by doc_date'){
	 $sql="select * from ".$this->session->userdata('userid')."_tmp_lapkas $where $orderby";	
		//echo $sql;
		return $this->db->query($sql);	
	}
	function laporan_faktur($no_trans){
		$sql="select * from detail_transaksi where no_transaksi='$no_trans' order by id_transaksi";
		return $this->db->query($sql);	
	}
	
}

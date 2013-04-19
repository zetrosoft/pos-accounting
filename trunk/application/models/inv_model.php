<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Inventori model

class Inv_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}
	function tabel($table){
		$this->tabels=$table;	
	}
	function field($query){
		$this->fields=$query;
	}
	
	function auto_sugest($str){
		$this->db->select($this->fields.' from '.$this->tabels." where ".$this->fields." like '".$str."%' order by ". $this->fields,true);
		return $this->db->get();
	}
	function create_table(){
		$sql="CREATE TABLE IF NOT EXISTS `inv_material_stok` (
			`nm_barang` VARCHAR(125) NOT NULL DEFAULT '',
			`batch` VARCHAR(125) NOT NULL DEFAULT '',
			`expired` DATE NULL DEFAULT NULL,
			`stock` DOUBLE NULL DEFAULT '0',
			`blokstok` DOUBLE NULL DEFAULT '0',
			`nm_satuan` VARCHAR(50) NULL DEFAULT '0',
			PRIMARY KEY (`batch`, `nm_barang`)
		)
		COMMENT='data stock material'
		COLLATE='latin1_swedish_ci'
		ENGINE=MyISAM;";
		mysql_query($sql) or die(mysql_error());	
	}
	function satuan_suggest($key='nm_barang'){
		$query=array();
		$sql="select m.nm_satuan from inv_material as m where m.nm_barang='$key'";
		$sql2="select m.sat_beli from inv_konversi as m where m.nm_barang='$key'";
		$rs=mysql_query($sql) or die(mysql_error());
		$rs2=mysql_query($sql2) or die(mysql_error());
		while($row=mysql_fetch_object($rs)){
			$query[]=$row->nm_satuan;
		}
		while($row=mysql_fetch_object($rs2)){
			$query[]=$row->sat_beli;
		}
		
		return $query;
	}
	
	function total_stock($where='',$field='stock',$table='inv_material_stok'){
		$total=0;
		$sql="select sum($field) as $field from $table $where";
		$rw=mysql_query($sql) or die(mysql_error());
		while($rs=mysql_fetch_object($rw)){
			$total=$rs->$field;	
		}
		
		return $total;	
	}
	function total_record($table,$where,$field='*'){
		$sql="select $field from $table $where";
		$rs=mysql_query($sql) or die(mysql_error());
		return mysql_num_rows($rs);
	}
	function show_list_1where($field,$isifield){
        $this->db->select('*');
        $this->db->where($field,$isifield);
        return $query = $this->db->get($this->tabels, 1);

	}
	function hapus_resep_kosong(){
		$sql="select * from inv_material_stok where stock <=0 and left(nm_barang,5)='RESEP'";
		$rs=mysql_query($sql) or die(mysql_error());
			while($row=mysql_fetch_array($rs)){
					mysql_query("delete from inv_material where nm_barang='".$row['nm_barang']."'");
					
			}
		mysql_query("delete from inv_material_stok where stock <=0 and left(nm_barang,5)='RESEP'");
	}
	function get_material($field='',$isifield=''){
		$data=array();
		$sql="select distinct(nm_barang) as nm_barang,sum(jml_transaksi) as jml_transaksi from ".$this->tabels." where $field='".$isifield."' group by nm_barang";
		$rw= mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($rw)){
			if($row->jml_transaksi>0){
				$data[]=$row->nm_barang;
			}
		}
		return $data;
	}
	function detail_transaksi($notrans,$nm_barang){
		
		$sql="select * from detail_transaksi where no_transaksi='$notrans' and nm_barang='$nm_barang'";
		$rw= $this->db->query($sql);
		return $rw->result_array();
			
	}
	function get_datakas(){
		$sql="select * from mst_kas order by id_kas";
		return $this->db->query($sql);
		//return $rw->result_array();
	}
	function get_status($where=''){
		$sql="select * from mst_status $where";
		return $this->db->query($sql);
	}
	function get_nm_material($str,$limit,$fld,$dest=''){
		$data=array();
		$where=($dest=='')?'':$dest;
		$sql="select * from inv_barang where $fld like '".$str."%' or kode ='".$str."' $where order by nama_barang limit $limit";	
		//echo $sql;
		($dest=='')?$dest='Nama_Barang':$dest=$dest;
		$rw= mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($rw)){
				$data[]=array('data'		=>$row->$fld,
							  'description' =>$row->$dest,
							  'jenis'		=>$row->ID_Jenis,
							  'kategori'	=>$row->ID_Kategori,
							  'satuan'		=>$row->ID_Satuan,
							  'nm_satuan'	=>rdb('inv_barang_satuan','Satuan','Satuan',"where ID='".$row->ID_Satuan."'"),
							  'nm_jenis'	=>rdb('inv_barang_jenis','JenisBarang','JenisBarang',"where ID='".$row->ID_Satuan."'"),
							  'status'		=>$row->Status,
							  'kode'		=>$row->Kode,
							  'pemasok'		=>$row->ID_Pemasok."-".rdb('inv_pemasok','Pemasok','Pemasok',"where ID='".$row->ID_Pemasok."'"),
							  'hargabeli'	=>$row->Harga_Beli,
							  'id_pemasok'	=>$row->ID_Pemasok,
							  'hargajual'	=>$row->Harga_Jual,
							  'id_barang'	=>$row->ID,
							  'nm_kategori'	=>rdb('inv_barang_kategori','Kategori','Kategori',"where ID='".$row->ID_Kategori."'")
							  );
		}
		return $data;
	}
	function get_kategori($str,$limit='8'){
		$data=array();
		$sql="select * from inv_barang_kategori where Kategori like '".$str."%' order by Kategori limit $limit";
		$rw= mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($rw)){
			$data[]=array('data'	=>$row->Kategori,
						  'ID'		=>$row->ID);	
		}
		return $data;
	}
	function get_jenis($str,$limit='8'){
		$data=array();
		$sql="select * from inv_barang_jenis where JenisBarang like '".$str."%' order by JenisBarang limit $limit";
		$rw= mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($rw)){
			$data[]=array('data'	=>$row->JenisBarang,
						  'ID'		=>$row->ID);	
		}
		return $data;
	}
	function get_satuan($str,$limit='8'){
		$data=array();
		$sql="select * from inv_barang_satuan where Satuan like '".$str."%' order by Satuan limit $limit";
		$rw= mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($rw)){
			$data[]=array('data'	=>$row->Satuan,
						  'ID'		=>$row->ID);	
		}
	return $data;
	}
	function get_bank($str=''){
		$data=array();
		$sql="select * from mst_bank where NamaBank like '$str%' order by NamaBank";
		$rw=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($rw)){
			$data[]=array('data'	=>$row->NamaBank,
						  'description'=>$row->NoRek
						  )	;
		}
	return $data;			
	}
	// daftar barang
	function list_barang($where){
		$data=array();
		$sql="select b.ID,bj.JenisBarang,bk.Kategori,b.Kode,b.Nama_Barang,
				b.Harga_Beli,b.Harga_Jual,bs.Satuan,b.Status,b.minstok,sum(s.stock) as stock
				from inv_barang as b
				left join inv_barang_jenis as bj
				on bj.ID=b.ID_Jenis
				left join inv_barang_kategori as bk
				on bk.ID=b.ID_Kategori
				left join inv_barang_satuan as bs
				on bs.ID=b.ID_Satuan
				left join inv_material_stok as s
				on s.id_barang=b.ID
				$where ";
		//echo $sql;
		$data=$this->db->query($sql);
		return $data->result();
	}
	function update_barang($id){
		$sql="select ib.*,k.Kategori,j.JenisBarang,s.Satuan from inv_barang as ib
			  left join inv_barang_kategori as k
			  on k.ID=ib.ID_Kategori
			  left join inv_barang_jenis as j
			  on j.ID=ib.ID_Jenis
			  left join inv_barang_satuan as s
			  on s.ID=ib.ID_Satuan
			  where ib.ID='$id'";
		$data=$this->db->query($sql);
		return $data->result();
	}
	function get_unit_konv($material){
		$sql="select * from inv_konversi where nm_barang='$material'";
		$data=$this->db->query($sql);
		return $data->result();
	}
	function set_stock($where){
		$sql="select ms.stock,b.Kode,b.ID,bj.JenisBarang,bk.Kategori,
			  b.Kode,b.Nama_Barang,b.Harga_Beli,b.Harga_Jual,bs.Satuan,b.Status
				from inv_barang as b
				left join inv_material_stok as ms
				on ms.nm_barang=b.Nama_Barang
				left join inv_barang_jenis as bj
				on bj.ID=b.ID_Jenis
				left join inv_barang_kategori as bk
				on bk.ID=b.ID_Kategori
				left join inv_barang_satuan as bs
				on bs.ID=b.ID_Satuan
				$where order by b.Nama_Barang";
		//echo $sql;		
		$data=$this->db->query($sql);
		return $data->result();
	}
	
	function get_detail_stock($nm_barang,$sort=''){
		$sql="select batch, sum(stock) as stock, sum(blokstok) as blokstok,
			   expired,nm_satuan,harga_beli from inv_material_stok where nm_barang='$nm_barang'
			   and stock <>'0' group by batch order by batch $sort";
		$data=$this->db->query($sql);
		return $data->result();
	}
	function get_detail_stocked($nm_barang,$sort='',$return='1',$limit='limit 1'){
		$ret=($return=='1')?"and stock <>'0'":'';
		$sql="select batch, sum(stock) as stock, sum(blokstok) as blokstok,
			   expired,nm_satuan,harga_beli from inv_material_stok where id_barang='$nm_barang'
			   $ret group by batch order by batch $sort $limit";
		//echo $sql;
		$data=$this->db->query($sql);
		return $data->result();
	}
	function get_total_stock($nm_barang){
		$sql="select sum(s.stock) as stock,u.satuan
				from inv_material_stok as s
				left join inv_barang as p
				on p.ID=s.id_barang
				left join inv_barang_satuan as u
				on u.ID=p.ID_Satuan
				where id_barang='$nm_barang'";
		$data=$this->db->query($sql);
		return $data->result();
	}
	function get_header_pembelian($notrans)
	{
		$sql="select * from inv_pembelian where NoUrut='".$notrans."'";
		$data=$this->db->query($sql);
		return $data->result();
	}
	function get_detail_trans($id){
		$sql="select b.Nama_Barang,s.ID,pd.Jumlah,pd.Harga_Beli,pd.batch,pd.ID_Satuan
			  from inv_pembelian_detail as pd
			  left join inv_barang as b
			  on b.ID=pd.ID_Barang
			  left join inv_barang_satuan as s
			  on s.ID=b.ID_Satuan
			  where pd.ID='$id'";
			  //echo $sql;
		$data=$this->db->query($sql);
		return $data->result();
	}
	//stock awal penerimaan barang
	function incoming($ID_Barang,$dari_tgl,$sampai_tgl=''){
		$masuk=0;$keluar=0;
		$sql=($sampai_tgl=='')?
		"select pb.ID_Barang,p.ID_Jenis,if(p.ID_Jenis='1',sum(pb.Jumlah),0) as inco,
				if(p.ID_Jenis='3',sum(pb.Jumlah),0) as ote
				from inv_pembelian as p
				left join inv_pembelian_detail as pb
				on pb.ID_Beli=p.ID
				where pb.ID_Barang='$ID_Barang' and p.Tanggal <'".tglToSql($dari_tgl)."'
				group by pb.ID_Barang":
		"select pb.ID_Barang,p.ID_Jenis,if(p.ID_Jenis='1',sum(pb.Jumlah),0) as inco,
				if(p.ID_Jenis='3',sum(pb.Jumlah),0) as ote
				from inv_pembelian as p
				left join inv_pembelian_detail as pb
				on pb.ID_Beli=p.ID
				where pb.ID_Barang='$ID_Barang' and p.Tanggal between'".tglToSql($dari_tgl)."'
				and '".tglToSql($sampai_tgl)."'
				group by pb.ID_Barang";
		//echo $sql;
		$rs=mysql_query($sql) or die(mysql_error());
		while($rw=mysql_fetch_object($rs)){;
			$masuk=$rw->inco;
			$keluar=$rw->ote;
		}
		return ($masuk-$keluar);
	}
	
	function outgoing($ID_Barang,$dari_tgl,$sampai_tgl=''){
		$masuk=0;$keluar=0;
		$sql=($sampai_tgl=='')?
		"select pb.ID_Barang,p.ID_Jenis,if(p.ID_Jenis<>'3',sum(pb.Jumlah),0) as inco,
				if(p.ID_Jenis='3',sum(pb.Jumlah),0) as ote
				from inv_penjualan as p
				left join inv_penjualan_detail as pb
				on pb.ID_Jual=p.ID
				where pb.ID_Barang='$ID_Barang' and p.Tanggal <'".tglToSql($dari_tgl)."'
				group by pb.ID_Barang":
		"select pb.ID_Barang,p.ID_Jenis,if(p.ID_Jenis<>'3',sum(pb.Jumlah),0) as inco,
				if(p.ID_Jenis='3',sum(pb.Jumlah),0) as ote
				from inv_penjualan as p
				left join inv_penjualan_detail as pb
				on pb.ID_Jual=p.ID
				where pb.ID_Barang='$ID_Barang' and p.Tanggal between'".tglToSql($dari_tgl)."'
				and '".tglToSql($sampai_tgl)."'
				group by pb.ID_Barang";
				
		$rs=mysql_query($sql) or die(mysql_error());
		while($rw=mysql_fetch_object($rs)){;
			$masuk=$rw->inco;
			$keluar=$rw->ote;
		}
		return ($masuk-$keluar);
	}
	function trans_pemasok($where){
		$sql="select a.Nama as Pemasok ,p.ID
			  from inv_pembelian as p
			  right join mst_anggota as a
			  on a.ID=p.ID_Pemasok and p.ID_Pemasok<>'0'
			  $where
			  group by p.ID_Pemasok";
			// echo $sql; 
			$data=$this->db->query($sql);
			return $data->result();
	}
	
	function auto_data(){
	//membuat jenis pembelian
	 $sql="CREATE TABLE IF NOT EXISTS `inv_pembelian_jenis` (
			  `ID` int(11) DEFAULT NULL,
			  `Jenis_Beli` varchar(10) DEFAULT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	 $sql1=" REPLACE INTO `inv_pembelian_jenis` (`ID`, `Jenis_Beli`) VALUES
				(1, 'Tunai'),
				(2, 'Giro'),
				(3, 'Transfer'),
				(4, 'Cheque');";
  //membuat jenis penjualan
	$sql2="CREATE TABLE IF NOT EXISTS `inv_penjualan_jenis` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `Jenis_Jual` varchar(20) DEFAULT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;";

	$sql3="REPLACE INTO `inv_penjualan_jenis` (`ID`, `Jenis_Jual`) VALUES
			(1, 'Tunai'),
			(2, 'Giro'),
			(3, 'Transfer'),
			(4, 'Cheque');";
			
	//membuat akun untuk kas harian
	$sql4="CREATE TABLE IF NOT EXISTS `mst_kas` (
		  `id_kas` varchar(100) NOT NULL DEFAULT '',
		  `nm_kas` varchar(225) DEFAULT '',
		  `sa_kas` double DEFAULT '0',
		  `sl_kas` double DEFAULT '0',
		  `doc_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
		  `created_by` varchar(100) DEFAULT NULL,
		  PRIMARY KEY (`id_kas`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

	$sql4="REPLACE INTO `mst_kas` (`id_kas`, `nm_kas`, `sa_kas`, `sl_kas`, `doc_date`, `created_by`) VALUES
	('KAS TOKO', 'KAS HARIAN TOKO', 0, 0, '2012-10-04 12:13:50', 'superuser');";
	//execute query diatas
		mysql_query($sql) or die($sql.mysql_error());
		mysql_query($sql1) or die($sql1.mysql_error());
		mysql_query($sql2) or die($sql2.mysql_error());
		mysql_query($sql3) or die($sql3.mysql_error());
		mysql_query($sql4) or die($sql4.mysql_error());
	
	}
}

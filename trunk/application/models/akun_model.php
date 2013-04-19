<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun_model extends CI_Model {
	public $data=array();
	
	function __construct(){
		parent::__construct();
	}
	
	function set_akun($field,$data){
		$sql="replace into perkiraan ($field) values($data)";
		return $this->db->query($sql);
	}
	function get_akun($id){
		$sql="select p.*,sk.Kode as sKode
				from perkiraan as p
				left join Klasifikasi as k
				on k.ID=p.ID_Klas
				left join Sub_Klasifikasi as sk
				on sk.ID=p.ID_SubKlas
				where p.ID='$id'";
		$q= $this->db->query($sql);
		return $q->result();
	}
	function get_nomor_akun($where){
		$sql="select * from perkiraan $where order by NoUrut desc limit 1";
		//echo $sql;
		$q= $this->db->query($sql);
		return $q->result();
	}
	function set_klas_akun($field,$data){
		$sql="replace into Klasifikasi ($field) values($data)";
		return $this->db->query($sql);
	}
	function set_subklas_akun($field,$data){
		$sql="replace into Sub_Klasifikasi ($field) values($data)";
		return $this->db->query($sql);
	}
	function  get_simpanan_name($where="where ID_Klasifikasi='3'"){
		$sql="select * from jenis_simpanan $where";
		return $this->db->query($sql);
	}
	function get_departemen($where=''){
		$sql="select distinct(ID_dept) as ID,Departemen from perkiraan as p,mst_departemen as d
			  where d.ID=p.ID_Dept $where order by ID_dept";
		return $this->db->query($sql);
	}
	function get_value_simpanan($akun,$tipe='K'){
		$datax=array();$datak=0;$datad=0;
			$trn="select * from transaksi as t,jurnal as j 
					where ID_Perkiraan='".$akun."' and t.ID_Jurnal=j.ID 
					and j.Tahun <='2012'";
			$sak=mysql_query($trn) or die(mysql_error());
			while($si=mysql_fetch_object($sak)){
				$datak=($datak+$si->Kredit);
				$datad=($datad+$si->Debet);
			}
				return ($tipe=='K')?$datax['K'][]=$datak:$datax['D'][]=$datad;
	}
	function get_data_simpanan($ID_SubKlas){
		$data=array();
		$sql="select ID_Dept,sum(saldoawal) as SA,sum(kredit) as KR,sum(debet) as DB from v_dept_trans where id_subklas='$ID_SubKlas' group by ID_Dept order by ID_dept";
		$data=$this->db->query($sql);
		return $data->result();
	}
	function get_lap_jenis($ID){
		$sql="select * from lap_jenis where ID='$ID'";
		$data=$this->db->query($sql);
		return $data->result();
	}
	function get_lap_subjenis($ID){
		$sql="select * from lap_subjenis where ID='$ID'";
		$data=$this->db->query($sql);
		return $data->result();
	}
	function get_neraca_head($where="!='0' order by lj.ID"){
		$sql="select lj.ID,lh.Header2,lj.Jenis1,lj.ID_Calc
				from lap_jenis as lj
				left join lap_head as lh
				on lj.ID_Calc=lh.ID
				where lj.ID_Head $where";
		//echo $sql;
		$data=$this->db->query($sql);
		return $data->result();
	}
	function get_neraca_sub($id){
		$sql="SELECT ls.ID,ls.SubJenis,lh.Header2,ls.ID_KBR,ls.ID_USP,lh.Header2 as ID_Calc
				FROM lap_subjenis AS ls
				LEFT JOIN lap_head AS lh
				ON lh.ID=ls.ID_Calc
				LEFT JOIN lap_jenis AS l
				ON ls.ID_Jenis=l.ID
				WHERE ls.ID_Jenis='$id'
				ORDER BY ls.ID";	
		$data=$this->db->query($sql);
		return $data->result();
	}
	function get_jurnal($where){
/*		$sql="select left(Tanggal,10) as Tanggal,ID_Unit,Nomor,Ket,sum(Debet) as Debet,
				sum(Kredit) as Kredit,ID_Perkiraan,ID_Jurnal
				from transaksi_new 
				$where
				group by ID_Jurnal";
		$sql="select j.ID,j.Tanggal,j.ID_Unit,j.Nomor,j.Keterangan as Ket,
				sum(t.Debet) as Debet, sum(t.Kredit) as Kredit,t.ID_Perkiraan,t.ID_Jurnal,
				count(t.ID) as isi
				from transaksi as t
				right join jurnal as j
				on j.ID=t.ID_Jurnal
				$where
				group by j.ID";
*/		//echo $sql;
		$sql="select * from jurnal_list $where";
		$data=$this->db->query($sql);
		return $data->result();
	}
	function get_no_jurnal($str,$limit){
		$data=array();
		$sql="select * from jurnal where Nomor like '%$str%' order by NoUrut desc limit $limit";
		$rs=mysql_query($sql) or die(mysql_error());
		while ($rw=mysql_fetch_object($rs)){
			$data[]=array('data'		=>$rw->Nomor,
						  'description'	=>$rw->Keterangan,
						  'NoUrut'		=>$rw->NoUrut,
						  'ID_Bulan'	=>$rw->ID_Bulan,
						  'Tahun'		=>$rw->Tahun,
						  'ID'			=>$rw->ID,
						  'Nomor'		=>$rw->Nomor,
						  'Tahun'		=>$rw->Tahun,
						  'Tanggal'		=>tglfromSql($rw->Tanggal),
						  'ID_Unit'		=>rdb('unit_jurnal','Unit','Unit',"where ID='".$rw->ID_Unit."'")
						  );
		}
		return $data;
	}
	function get_total_KD($ID){
		$data=array();
/*		$sql="select j.Nomor,t.nomor,Ket,j.ID_Unit,j.Tanggal,sum(debet) as Debet,sum(kredit) as Kredit,j.Keterangan 
			 from transaksi_new as t 
			 left join jurnal as j
			 on j.ID=t.ID_Jurnal
			 where t.ID_Jurnal='$ID' group by id_jurnal";
*/		$sql="select j.ID,j.ID_Unit,j.ID_Tipe,j.Tanggal,
			j.Nomor,j.Keterangan,sum(Debet) as Debet,sum(Kredit) as Kredit
			from jurnal as j
			left join transaksi_new as t
			on t.ID_Jurnal=j.ID
			where j.id='$ID'
			group by j.ID";	
		$data=$this->db->query($sql);
		return $data->result();
	}
	function get_last_jurnal($ID){
		$data='';$IDn='';
		$sl=mysql_query("select NoUrut,ID from jurnal order by ID desc limit 1") or die(mysql_error());
		while($rw=mysql_fetch_object($sl)){
			$data=$rw->NoUrut;
			$IDn=$rw->ID;
		}
		if(strlen($data)==0){
			$data='000001';
		}else if(strlen($data)=='1'){
			$data='00000'.($data+1);
		}else if(strlen($data)=='2'){
			$data='0000'.($data+1);
		}else if(strlen($data)=='3'){
			$data='000'.($data+1);
		}else if(strlen($data)=='4'){
			$data='00'.($data+1);
		}else if(strlen($data)=='5'){
			$data='0'.($data+1);
		}else if(strlen($data)>='6'){
			$data=($data+1);
		}
		return $data.'-'.$IDn;
	}
	
	function detail_jurnal($ID){
		$sql="select p.ID,
		if(p.ID_Agt=0,concat(s.Kode,sk.Kode,d.Kode,p.ID_Unit,p.Kode),concat(s.Kode,sk.Kode,d.Kode,p.ID_Unit,a.No_Perkiraan)) as Kode,
		if(p.ID_Agt!=0,concat(a.nama,\" (\", d.title,\") - \",js.jenis),p.Perkiraan) as Perkiraan,
		t.Debet,t.Kredit,t.Keterangan,t.ID_Jurnal,t.ID as IDT
		from transaksi as t
		left join perkiraan as p
		on t.ID_Perkiraan=p.ID
		left join mst_anggota as a
		on a.ID=p.ID_Agt
		left join mst_departemen as d
		on d.ID=p.ID_Dept
		left join jenis_simpanan as js
		on js.ID=p.ID_Simpanan
		left join Klasifikasi as s
		on s.ID=p.ID_Klas
		left join Sub_Klasifikasi as sk
		on sk.ID=p.ID_SubKlas
		left join jurnal as j
		on j.ID=t.ID_Jurnal
		where t.ID_Jurnal='$ID' order by t.urutan,Kode";
		//echo $sql;
		$data=$this->db->query($sql);
		return $data->result();
	}
	function get_ID_from_ID_Simpanan($id_simpanan){
		$data='';
		$sql="select ID from perkiraan where id_simpanan='$id_simpanan'";
		$rs=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($rs)){
			$data .="'".$row->ID."',";	
		}
		return substr($data,0,-1);
	}
	function new_transaksi($ID_Perkiraan){
		$sql="select tp.Kredit,tp.Debet,
			concat(k.Kode,sk.Kode,p.ID_Unit,d.Kode,a.No_Perkiraan) as Kode,
			concat(a.Nama,\" (\",d.Title,\" )\",\"-\",js.Jenis) as Perkiraan,
			tp.Keterangan,tp.ID
			from transaksi_temp as tp
			left join perkiraan as p
			on p.ID=tp.ID_Perkiraan
			left join mst_anggota as a
			on p.ID_Agt=a.ID
			left join mst_departemen as d
			on d.ID=p.ID_Dept
			left join klasifikasi as k
			on k.ID=p.ID_Klas
			left join sub_klasifikasi as sk
			on sk.ID=p.ID_SubKlas
			left join jenis_simpanan as js
			on js.ID=p.ID_Simpanan
			where tp.ID_Stat='0' and
			tp.ID_Perkiraan in(".$this->get_ID_from_ID_Simpanan($ID_Perkiraan).")
			order by Kode";
		$data=$this->db->query($sql);
		return $data->result();
	}
	function kode_akun($ID_Unit,$ID_dept='1',$ID_Simpanan=" not in('1','2','3','4','5')"){
		$dpt=($ID_dept=='1')? "p.ID_Dept='$ID_dept'":" a.ID_Jenis='1'";
		$ord=($ID_dept=='1')?'order by p.ID_Klas,p.ID_SubKlas, p.NoUrut':'order by a.Nama,s.ID';
		$idut=($ID_Unit=='')?'': "p.ID_Unit='".$ID_Unit."' and ";
		$sql="select 
			if(p.Kode!='',concat(k.Kode,sk.Kode,uj.Kode,d.Kode,p.Kode),concat(k.Kode,sk.Kode,uj.Kode,d.Kode,a.No_Perkiraan)) as Kode,
			if(p.Kode!='',p.Perkiraan,concat(a.Nama,' [',d.Title,'] - ',s.Jenis)) as Perkiraan,p.ID
			from perkiraan as p
			left join Klasifikasi as k
			on k.id=p.ID_Klas
			left join Sub_Klasifikasi as sk
			on sk.id=p.ID_SubKlas
			left join unit_jurnal as uj
			on uj.id=p.ID_Unit
			left join mst_departemen as d
			on d.ID=p.ID_Dept
			left join mst_anggota as a
			on a.ID=p.ID_Agt
			left join jenis_simpanan as s
			on s.ID=p.ID_Simpanan
			where $idut $dpt
			and p.ID_Simpanan $ID_Simpanan
			$ord";
			//echo $sql;
			$data=$this->db->query($sql);
			return $data->result();
	}
	function get_head_bk(){
	$dql="SELECT j.ID_Bulan,p.SaldoAwal,sum(debet),sum(kredit)
		from transaksi as t,jurnal as j,perkiraan as p
		where t.ID_Perkiraan=p.ID and t.ID_Jurnal=j.ID and
			 j.Tahun='2002' and 
			 concat(p.ID_Klas,p.ID_SubKlas,p.ID_Agt)='319120'
		group by j.ID_Bulan";
		"SELECT a.Nama,p.saldoawal,sum(kredit),sum(debet)
		from transaksi as t
		left join 
			(select * from jurnal as j where tanggal < '2005-01-01') j
			on t.ID_Jurnal=j.ID
		left join
			(select * from perkiraan as p 
			where p.ID_Dept='2') p
			on t.ID_Perkiraan=p.ID
		left join anggota as a
		on a.ID=p.ID_Agt";
		//bukubesarbydate
		$sql="SELECT A.Nama,JS.Jenis,(T.Debet) AS Debet,(T.Kredit) AS Kredit,
				J.Tanggal,J.Nomor,J.Keterangan
				FROM jurnal AS J
				INNER JOIN transaksi as T
				ON T.ID_Jurnal=J.ID
				INNER JOIN 
					(SELECT ID,P.ID_Agt,P.ID_Simpanan,P.ID_Dept from perkiraan as P
					 WHERE CONCAT(P.ID_Klas,P.ID_SubKlas,P.ID_Dept,P.ID_Agt)='$Perkiraan') P
				ON T.ID_Perkiraan=P.ID
				LEFT JOIN mst_anggota as A
				ON A.ID=P.ID_Agt
				LEFT JOIN jenis_simpanan as JS
				ON JS.ID=P.ID_Simpanan
				WHERE J.Tanggal BETWEEN '$start' and '$stop' 
				ORDER BY J.ID";
	}
	
	function get_saldo_awal($perkiraan){
		$sql="SELECT saldoawal from perkiraan where ID='$perkiraan'";	
		//echo $sql;
		$data=$this->db->query($sql);
		return $data->result();
	}
	function get_saldo_akhir($perkiraan,$endDate){
		$sql="SELECT sum(debet) as Debet, sum(kredit) as Kredit
			  from jurnal as j
			  left join transaksi as t
			  on t.ID_Jurnal=j.ID
			  where t.ID_Perkiraan='$perkiraan' $endDate
			  group by t.ID_Perkiraan";
		//echo $sql;  
		$data=$this->db->query($sql);
		return $data->result();
	}
	function buku_besar_byDate($Perkiraan,$start,$stop){
		$sql="SELECT Tanggal,Keterangan,Nomor,sum(kredit) as Kredit, sum(debet) as Debet
			  from transaksi_new where tanggal between '$start' and '$stop' and
			  ID_Perkiraan='$Perkiraan' group by ID_Jurnal order by Nomor,tanggal";
			//echo $sql;
			$data=$this->db->query($sql);
			return $data->result();
	}
	function buku_besar_byTahun($Perkiraan,$tahun,$bln='')
	{
		$bulan=($bln=='')?'':" and ID_Bulan='".$bln."'";
		$sql="SELECT ID_Bulan, sum(debet) as Debet, sum(kredit) as Kredit
			  from transaksi_new where ID_Perkiraan='".$Perkiraan."' and tahun='".$tahun."' ".$bulan."
			  group by ID_Bulan order by ID_Bulan";	
			//echo $sql;
			$data=$this->db->query($sql);
			return $data->result();
	}
	function get_saldo_simpanan($perkiraan,$tahun){
	$sql="select (sum(kredit) - sum(debet)) as saldoawal
		  from transaksi_new where ID_Perkiraan='$perkiraan' and tahun < '$tahun'
		  group by ID_Perkiraan";
	/*$sql="select (sum(kredit)-sum(debet)+SaldoAwal) as SA
			from jurnal as j
			left join transaksi as t
			on t.ID_Jurnal=j.ID
			right join perkiraan as p
			on p.ID=t.ID_Perkiraan
			where t.ID_Perkiraan='3139' and j.Tahun <'2001'";
	*/		$data=$this->db->query($sql);
			return $data->result();
	}
	function get_agt_kode($ID_Dept,$ID_SubKlas){
		($ID_SubKlas<>'')?
				$ID_SK="p.ID_SubKlas='$ID_SubKlas' order by a.nama":
				$ID_SK="p.ID_SubKlas in('4','17','18','19','28') order by p.ID_Agt,p.ID_Simpanan";
				
		$sql="select a.ID,concat(k.Kode,sk.Kode,u.Kode,d.Kode,a.No_Perkiraan) As Kode,
				concat(a.Nama,\" (\",d.Title,\") -\",js.Jenis) as Nama
				from perkiraan as p
				left join klasifikasi as k
				on k.ID=p.ID_Klas
				left join sub_klasifikasi as sk
				on sk.ID=p.ID_SubKlas
				left join mst_departemen as d
				on d.ID= p.ID_Dept
				left join jenis_simpanan as js
				on js.ID=p.ID_Simpanan
				right join mst_anggota as a
				on a.ID=p.ID_Agt
				left join unit_jurnal as u
				on u.ID=p.ID_Unit
				where p.ID_Agt<>'0' and p.ID_Dept='$ID_Dept' 
				and $ID_SK";
			//echo $sql;
			$data=$this->db->query($sql);
			return $data->result();
	}
	function get_perkiraan($ID_Dept,$ID_Simp,$ID_Klas){
		$sql="select p.ID,concat(k.Kode,sk.Kode,u.Kode,d.Kode,p.Kode) As Kode,
				p.Perkiraan as Nama
				from perkiraan as p
				left join klasifikasi as k
				on k.ID=p.ID_Klas
				left join sub_klasifikasi as sk
				on sk.ID=p.ID_SubKlas
				left join mst_departemen as d
				on d.ID= p.ID_Dept
				left join jenis_simpanan as js
				on js.ID=p.ID_Simpanan
				left join unit_jurnal as u
				on u.ID=p.ID_Unit
				where p.ID_Dept='$ID_Dept' 
				and p.ID_Klas='$ID_Klas' and p.ID_SubKlas='$ID_Simp'";
			echo $sql;
			$data=$this->db->query($sql);
			return $data->result();
	}
}
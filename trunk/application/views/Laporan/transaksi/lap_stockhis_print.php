<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		 
		  $a=new reportProduct();
		  $zn=new zetro_manager();
		  $nfile='asset/bin/zetro_inv.frm';
		  //$a->Header();
		  $a->setKriteria("transkip");
		  $a->setNama("MUTASI BARANG");
		  $a->setSection("laphistory");
		  $a->setFilter(array($dari_tgl.' s/d '.$sampai_tgl ,$kategori));
		  $a->setReferer(array('Periode','Kategori'));
		  $a->setFilename($nfile);
		  $a->AliasNbPages();
		  $a->AddPage("L","A4");
		  $a->SetFont('Arial','',10);
		  $a->SetWidths(array(10,30,110,22,25,25,25,25));
		  // set align tiap kolom tabel transaksi
		  $a->SetAligns(array("C","C","L","L","R","R","R","R"));
		  $a->SetFont('Arial','B',10);
		  $a->SetFont('Arial','',9);
		  //$rec = $temp_rec->result();
		  $n=0;$harga=0;$hgb=0;$hargaj=0;$jml=0;
		  foreach($temp_rec as $r)
		  {
			$n++;$stokAwalT=0;$stokAwalO=0;
			$masuk=0;$keluar=0;
			$stokAwalT	=$this->inv_model->incoming($r->ID,$dari_tgl);
			$stokAwalO	=$this->inv_model->outgoing($r->ID,$dari_tgl);
			$masuk		=$this->inv_model->incoming($r->ID,$dari_tgl,($sampai_tgl=='')?$dari_tgl:$sampai_tgl);
			$keluar		=$this->inv_model->outgoing($r->ID,$dari_tgl,($sampai_tgl=='')?$dari_tgl:$sampai_tgl);
			$a->Row(array($n, $r->Kode,
						 $r->Nama_Barang,
						 rdb('inv_barang_satuan','Satuan','Satuan',"where ID='".$r->ID_Satuan."'"),
						 number_format(($stokAwalT-$stokAwalO),2),
						 number_format($masuk,2),
						 number_format($keluar,2),
						 number_format((($stokAwalT-$stokAwalO)+$masuk-$keluar),2)));
		  }
			//sub tlot
/*			$jml	=($jml+$r->Jumlah);
			$harga 	=($harga+($r->Harga));
			$hargaj	=($hargaj+($r->Harga*$r->Jumlah));
		  }
		  $a->SetFont('Arial','B',10);
		  $a->SetFillColor(225,225,225);
		  $a->Cell(140,8,"TOTAL",1,0,'R',true);
		  $a->Cell(20,8,number_format($jml,2),1,0,'R',true);
		  $a->Cell(25,8,number_format($harga,2),1,0,'R',true);
		  $a->Cell(30,8,number_format($hargaj,2),1,0,'R',true);
		  $a->Cell(60,8,'',1,0,'R',true);
*/		  $a->Output('application/logs/'.$this->session->userdata('userid').'_mutasi.pdf','F');

//show pdf output in frame
$path='application/views/laporan/transaksi';
$img=" <img src='".base_url()."asset/images/back.png' onclick='js:window.history.back();' style='cursor:pointer' title='click for select other filter data'>";
//link_js('auto_sugest.js,lap_beli.js,jquery.fixedheader.js','asset/js,'.$path.'/js,asset/js');
panel_begin('Print Preview','','Back'.$img);
?>
		  <iframe src="<?=base_url();?>application/logs/<?=$this->session->userdata('userid');?>_mutasi.pdf" height="100%" width="100%" frameborder="0" allowtransparency="1" style="z-index:100"></iframe>
<?
panel_end();

?>
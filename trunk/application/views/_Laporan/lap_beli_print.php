<?php
		  $a=new reportProduct();
		  $zn=new zetro_manager();
		  $nfile='asset/bin/zetro_beli.frm';
		  //$a->Header();
		  $a->setKriteria("transkip");
		  $a->setNama("LAPORAN REKAP SIMPANAN PER DEPARTEMEN");
		  $a->setSection("lapbelilist");
		  $a->setFilter(array($tanggal,$jenisobat,$nm_vendor));
		  $a->setReferer(array('Sampai Dengan'));
		  $a->setFilename('asset/bin/zetro_beli.frm');
		  $a->AliasNbPages();
		  $a->AddPage("L","A4");
	
		  $a->SetFont('Arial','',10);
		  // set lebar tiap kolom tabel transaksi
		  // set align tiap kolom tabel transaksi
		  $a->SetWidths(array(10,22,70,15,25,25,30,40,40));
		  $a->SetAligns(array("C","C","L","C","R","C","R","L","L"));
		  $a->SetFont('Arial','B',10);
		  $a->Ln(1);
		  $a->SetFont('Arial','',9);
		  //$rec = $temp_rec->result();
		  $n=0;$harga=0;
		  foreach($temp_rec->result_object() as $r)
		  {
			$n++;
			$a->Row(array($n, tglfromSql($r->tgl_transaksi),
							 $r->nm_barang, $r->nm_satuan,
							 $r->jml_transaksi, (!empty($r->expired))?tglfromSql($r->expired):'', 
							 number_format($r->harga_beli,2), $r->nm_produsen,
							 'Ref. :'.$r->faktur_transaksi));
			//sub total harga_beli
			$harga =($harga+$r->harga_beli);
		  }
		  $a->SetFont('Arial','B',10);
		  $a->SetFillColor(225,225,225);
		  $a->Cell(167,8,"TOTAL",1,0,'R',true);
		  $a->Cell(30,8,number_format($harga,2),1,0,'R',true);
		  $a->Cell(80,8,'',1,0,'R',true);
		  $a->Output('application/logs/'.$this->session->userdata('userid').'_rekap_simpanan.pdf','F');

//show pdf output in frame
$path='application/views/laporan';
$img=" <img src='".base_url()."asset/images/back.png' onclick='js:window.history.back();' style='cursor:pointer' title='click for select other filter data'>";
link_js('auto_sugest.js,lap_beli.js,jquery.fixedheader.js','asset/js,'.$path.'/js,asset/js');
panel_begin('Print Preview','','Back'.$img);
?>
		  <iframe src="<?=base_url();?>application/logs/<?=$this->session->userdata('userid');?>_rekap_simpanan.pdf" height="100%" width="100%" frameborder="0" allowtransparency="1"></iframe>
<?
panel_end();

?>
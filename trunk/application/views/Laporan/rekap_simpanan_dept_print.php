<?php
		  $a=new reportProduct();
		  $zn=new zetro_manager();
		  $nfile='asset/bin/zetro_neraca.frm';
		  //$a->Header();
		  $a->setKriteria("transkip");
		  $a->setNama("LAPORAN REKAP ".strtoupper($simp));
		  $a->setSection("rekapsimpanan");
		  $a->setFilter(array($bulan.' '.$tahun,$Dept));
		  $a->setReferer(array('Periode','Departemen'));
		  $a->setFilename($nfile);
		  $a->AliasNbPages();
		  $a->AddPage("P","A4");
	
		  $a->SetFont('Arial','',10);
		  // set lebar tiap kolom tabel transaksi
		  $a->SetWidths(array(10,70,30,30,30));
		  // set align tiap kolom tabel transaksi
		  $a->SetAligns(array("C","L","R","R","R"));
		  $a->SetFont('Arial','B',10);
		  //$a->Ln(1);
		  $a->SetFont('Arial','',9);
		  //$rec = $temp_rec->result();
		  $n=0;$s_pokok=0;$s_wajib=0;$s_kusus=0;$saldo=0;
		  foreach($saldoawal as $sa)
		  {
			$s_kusus=$sa->Saldo;  
		  }
		  $a->Row(array('','Saldo Awal','','',number_format($s_kusus,2)));
		  foreach($temp_rec as $r)
		  { 
			  $n++;
			  $saldo=($saldo+($r->Kredit-$r->Debet));
			  $a->Row(array($n,$r->Bulan,
			  number_format($r->Debet,2),
			  number_format($r->Kredit,2),
			  number_format(($s_kusus+$saldo),2)));
			  $s_pokok=($s_pokok+$r->Debet);
			  $s_wajib=($s_wajib+$r->Kredit);
		  }
		  $a->Row(array('','TOTAL',number_format($s_pokok,2),number_format($s_wajib,2),''));
		  $a->Output('application/logs/'.$this->session->userdata('userid').'_rekap_simpanan_dept.pdf','F');

//show pdf output in frame
$path='application/views/_laporan';
$img=" <img src='".base_url()."asset/images/back.png' onclick='js:window.history.back();' style='cursor:pointer' title='click for select other filter data'>";
panel_begin('Print Preview','','Back'.$img);
?>
		  <iframe src="<?=base_url();?>application/logs/<?=$this->session->userdata('userid');?>_rekap_simpanan_dept.pdf" height="100%" width="100%" frameborder="0" allowtransparency="1"></iframe>
<?
panel_end();

?>
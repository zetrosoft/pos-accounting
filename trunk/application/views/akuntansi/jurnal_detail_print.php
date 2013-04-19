<?php
		  $a=new reportProduct();
		  $zn=new zetro_manager();
		  $nfile='asset/bin/zetro_akun.frm';
		  //$a->Header();
		  $a->setKriteria("transkip");
		  $a->setNama("LAPORAN DETAIL JURNAL");
		  $a->setFilename('asset/bin/zetro_akun.frm');
		  $a->setSection("addcontent");
		  $a->setReferer(array('Tanggal','Nomor Jurnal','Keterangan','Unit'));
		  $a->setFilter(array($Tanggal,$NoJurnal,$Keterangan,$ID_Unit));
		  $a->AliasNbPages();
		  $a->AddPage("P","A4");
	
		  $a->SetFont('Arial','',10);
		  // set lebar tiap kolom tabel transaksi
		  $a->SetWidths(array(10,25,56,27,27,50));
		  // set align tiap kolom tabel transaksi
		  $a->SetAligns(array("C","C","L","R","R","L"));
		  $a->SetFont('Arial','B',10);
		  //$a->Ln(1);
		  $a->SetFont('Arial','',9);
		  //$rec = $temp_rec->result();
		  $n=0;$s_pokok=0;$s_wajib=0;$s_kusus=0;
		  
		  foreach($temp_rec as $r) { 
		  	$n++;
		  	$a->Row(array($n,$r->Kode,
						  $r->Perkiraan,
						  number_format($r->Debet,0),
						  number_format($r->Kredit,0),
						  $r->Keterangan));
				$s_pokok=($s_pokok+$r->Debet);
				$s_wajib=($s_wajib+$r->Kredit);
				
		  }/**/
		  $a->SetFont('Arial','B',9);
		  $a->SetFillColor(225,225,225);
		  $a->Cell(91,8,"TOTAL",1,0,'R',true);
		  $a->Cell(27,8,number_format($s_pokok,0),1,0,'R',true);
		  $a->Cell(27,8,number_format($s_wajib,0),1,0,'R',true);
		  $a->Cell(50,8,'',1,0,'R',true);
		  $a->Output('application/logs/'.$this->session->userdata('userid').'_d_jurnal.pdf','F');

//show pdf output in frame
$path='application/views/_laporan';
$img=" <img src='".base_url()."asset/images/back.png' onclick='js:window.history.back();' style='cursor:pointer' title='click for select other filter data'>";
link_js('auto_sugest.js,lap_beli.js,jquery.fixedheader.js','asset/js,'.$path.'/js,asset/js');
panel_begin('Print Preview','','Back'.$img);
?>
		  <iframe src="<?=base_url();?>application/logs/<?=$this->session->userdata('userid');?>_d_jurnal.pdf" height="100%" width="100%" frameborder="0" allowtransparency="1"></iframe>
<?
panel_end();

?>
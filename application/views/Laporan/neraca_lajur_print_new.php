<?php
		  $a=new reportProduct();
		  $zn=new zetro_manager();
		  $nfile='asset/bin/zetro_neraca.frm';
		  //$a->Header();
		  $a->setKriteria("transkip");
		  $a->setNama("LAPORAN NERACA LAJUR ");
		  $a->setSection("Neraca Lajur");
		  $a->setFilter(array($tanggal,$dept,($akun=='')?"All":$akun));
		  $a->setReferer(array('Periode','Departemen','Perkiraan'));
		  $a->setFilename('asset/bin/zetro_neraca.frm');
		  $a->AliasNbPages();
		  $a->AddPage("P","A4");
	
		  $a->SetFont('Arial','',10);
		  // set lebar tiap kolom tabel transaksi
		  $a->SetWidths(array(10,20,60,25,25,25,25));
		  // set align tiap kolom tabel transaksi
		  $a->SetAligns(array("C","C","L","R","R","R","R"));
		  $a->SetFont('Arial','B',10);
		  //$a->Ln(1);
		  $a->SetFont('Arial','',9);
		  //$rec = $temp_rec->result();
		  $n=0;$s_pokok=0;$s_wajib=0;$s_kusus=0;$s_akhir=0;
		  $saldoawal=0;$saldosbl=0;
		foreach($temp_rec as $r){
			$n++;
			$a->Row(array($n,$r->kode,$r->nama_agt,
						number_format($r->SaldoAwal,0),number_format($r->Debet,0),number_format($r->Kredit,0),
						number_format($r->SaldoAkhir,0)
						)
						);
			$s_pokok=($s_pokok+$r->SaldoAwal);
			$s_wajib=($s_wajib+$r->Debet);
			$s_kusus=($s_kusus+$r->Kredit);	
			$s_akhir=($s_akhir+$r->SaldoAkhir);
		}
		  $a->SetFont('Arial','B',10);
		  $a->SetFillColor(225,225,225);
		  $a->Cell(90,8,"TOTAL",1,0,'R',true);
		  $a->Cell(25,8,number_format($s_pokok,0),1,0,'R',true);
		  $a->Cell(25,8,number_format($s_wajib,0),1,0,'R',true);
		  $a->Cell(25,8,number_format($s_kusus,0),1,0,'R',true);
		  $a->Cell(25,8,number_format(($s_akhir),0),1,0,'R',true);
		 /**/ 
		 $a->Output('application/logs/'.$this->session->userdata('userid').'_neraca_lajur.pdf','F');

//show pdf output in frame
$path='application/views/_laporan';
$img=" <img src='".base_url()."asset/images/back.png' onclick='js:window.history.back(-1);' style='cursor:pointer' title='click for select other filter data'>";
panel_begin('Print Preview','','Back'.$img);
?>
		  <iframe src="<?=base_url();?>application/logs/<?=$this->session->userdata('userid');?>_neraca_lajur.pdf" height="100%" width="100%" frameborder="0" allowtransparency="1"></iframe>
<?
panel_end();

?>
<?php
		  $a=new reportProduct();
		  $zn=new zetro_manager();
		  $nfile='asset/bin/zetro_beli.frm';
		  //$a->Header();
		  $a->setKriteria("transkip");
		  $a->setNama("LAPORAN REKAP SIMPANAN ");
		  $a->setSection("rekapsimpanan");
		  $a->setFilter(array($tanggal));
		  $a->setReferer(array('Periode'));
		  $a->setFilename('asset/bin/zetro_akun.frm');
		  $a->AliasNbPages();
		  $a->AddPage("P","A4");
	
		  $a->SetFont('Arial','',10);
		  // set lebar tiap kolom tabel transaksi
		  $a->SetWidths(array(10,60,30,30,30,30));
		  // set align tiap kolom tabel transaksi
		  $a->SetAligns(array("C","L","R","R","R","R"));
		  $a->SetFont('Arial','B',10);
		  //$a->Ln(1);
		  $a->SetFont('Arial','',9);
		  //$rec = $temp_rec->result();
		  $n=0;$s_pokok=0;$s_wajib=0;$s_kusus=0;
		  
		  foreach($temp_rec as $r)
		  {
						$field1=str_replace('. ','_',rdb("jenis_simpanan",'Jenis','Jenis',"where ID='1'"));
						$field2=str_replace('. ','_',rdb("jenis_simpanan",'Jenis','Jenis',"where ID='2'"));
						$field3=str_replace('. ','_',rdb("jenis_simpanan",'Jenis','Jenis',"where ID='3'"));
			$n++;
			$a->Row(array($n,$r->ID_Dept,
							number_format ($r->$field1,2),
							number_format ($r->$field2,2),
							number_format ($r->$field3,2),
							 number_format (($r->$field1+$r->$field2+$r->$field3),2)));
			//sub total
			$s_pokok =($s_pokok+$r->$field1);
			$s_wajib =($s_wajib+$r->$field2);
			$s_kusus =($s_kusus+$r->$field3);
		  }
		  $a->SetFont('Arial','B',10);
		  $a->SetFillColor(225,225,225);
		  $a->Cell(70,8,"TOTAL",1,0,'R',true);
		  $a->Cell(30,8,number_format($s_pokok,2),1,0,'R',true);
		  $a->Cell(30,8,number_format($s_wajib,2),1,0,'R',true);
		  $a->Cell(30,8,number_format($s_kusus,2),1,0,'R',true);
		  $a->Cell(30,8,number_format(($s_pokok+$s_wajib+$s_kusus),2),1,0,'R',true);/**/
		  $a->Output('application/logs/'.$this->session->userdata('userid').'_rekap_simpanan.pdf','F');

//show pdf output in frame
$path='application/views/_laporan';
$img=" <img src='".base_url()."asset/images/back.png' onclick='js:window.history.back();' style='cursor:pointer' title='click for select other filter data'>";
link_js('auto_sugest.js,lap_beli.js,jquery.fixedheader.js','asset/js,'.$path.'/js,asset/js');
panel_begin('Print Preview','','Back'.$img);
?>
		  <iframe src="<?=base_url();?>application/logs/<?=$this->session->userdata('userid');?>_rekap_simpanan.pdf" height="100%" width="100%" frameborder="0" allowtransparency="1"></iframe>
<?
panel_end();

?>
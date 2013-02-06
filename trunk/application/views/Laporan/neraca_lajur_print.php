<?php
		  $a=new reportProduct();
		  $zn=new zetro_manager();
		  $nfile='asset/bin/zetro_neraca.frm';
		  //$a->Header();
		  $a->setKriteria("transkip");
		  $a->setNama("LAPORAN NERACA LAJUR ");
		  $a->setSection("Neraca Lajur");
		  $a->setFilter(array($tanggal,$dept));
		  $a->setReferer(array('Periode','Departemen'));
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
		  
		foreach($temp_rec as $r){
			$n++;
			$saldoawal=rdb("perkiraan",'SaldoAwal','sum(SaldoAwal) as SaldoAwal',"where ID_Agt='".$r->ID_Agt."' and ID_Dept='".$r->ID_Dept."' and ID_Simpanan='".$r->ID_Simpanan."'");
			$kode=rdb('klasifikasi','Kode','Kode',"where ID='".$r->ID_Klas."'");
			$kode.=rdb('sub_klasifikasi','Kode','Kode',"where ID='".$r->ID_SubKlas."'");
			$kode.=rdb('unit_jurnal','Kode','Kode',"where ID='".$r->ID_Dept."'");
			$kode.=rdb('mst_departemen','Kode','Kode',"where ID='".$r->ID_Unit."'");
			$kode.=rdb('mst_anggota','No_Perkiraan','No_Perkiraan',"where ID='".$r->ID_Agt."'");
			$simp=rdb('jenis_simpanan','Jenis','Jenis',"where ID='".$r->ID_Simpanan."'");
			$saldo=($r->ID_Calc=='2')?($r->Kredit-$r->Debet):($r->Debet-$r->Kredit);
			$a->Row(array($n,$kode,rdb('mst_anggota','Nama','Nama',"where ID='".$r->ID_Agt."'")." - ".$simp,
						number_format($saldoawal,2),number_format($r->Debet,2),number_format($r->Kredit,2),
						number_format($saldoawal+$saldo,2)
						)
						);
			$s_pokok=($s_pokok+$saldoawal);
			$s_wajib=($s_wajib+$r->Debet);
			$s_kusus=($s_kusus+$r->Kredit);	
			$s_akhir=($s_akhir+$saldoawal+$saldo);
		}
		  $a->SetFont('Arial','B',10);
		  $a->SetFillColor(225,225,225);
		  $a->Cell(90,8,"TOTAL",1,0,'R',true);
		  $a->Cell(25,8,number_format($s_pokok,2),1,0,'R',true);
		  $a->Cell(25,8,number_format($s_wajib,2),1,0,'R',true);
		  $a->Cell(25,8,number_format($s_kusus,2),1,0,'R',true);
		  $a->Cell(25,8,number_format(($s_akhir),2),1,0,'R',true);
		 /**/ 
		 $a->Output('application/logs/'.$this->session->userdata('userid').'_neraca_lajur.pdf','F');

//show pdf output in frame
$path='application/views/_laporan';
$img=" <img src='".base_url()."asset/images/back.png' onclick='js:window.history.back();' style='cursor:pointer' title='click for select other filter data'>";
panel_begin('Print Preview','','Back'.$img);
?>
		  <iframe src="<?=base_url();?>application/logs/<?=$this->session->userdata('userid');?>_neraca_lajur.pdf" height="100%" width="100%" frameborder="0" allowtransparency="1"></iframe>
<?
panel_end();

?>
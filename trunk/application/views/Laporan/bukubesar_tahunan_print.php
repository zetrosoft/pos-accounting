<?php
		  $a=new reportProduct();
		  $zn=new zetro_manager();
		  $nfile='asset/bin/zetro_neraca.frm';
		  //$a->Header();
		  $a->setKriteria("transkip");
		  $a->setNama("LAPORAN BUKU BESAR");
		  $a->setSection("rekapsimpanan");
		  $a->setFilter(array('Rekap Tahun :'.$tahun,$akun));
		  $a->setReferer(array('Periode','Perkiraan'));
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
		  $n=0;$s_pokok=0;$s_wajib=0;$s_kusus=0;$saldo=0;$t_kredit=0;$t_debet=0;
		  $a->Row(array('','SALDO AWAL','','',number_format($saldo_awal,2)));
			$saldo=$saldo_awal;
			for ($i=1;$i<=12;$i++)
			{
				$n++;$debet=0;$kredit=0;
				$data=$this->akun_model->buku_besar_byTahun($ip_temp,$tahun,$i);
				foreach($data as $r)
				{
					
					$saldo =($id_Calc==2)?($saldo+$r->Kredit)-($r->Debet):($saldo+$r->Debet)-($r->Kredit);
					$debet=$r->Debet;
					$kredit=$r->Kredit;
					$t_kredit	=($t_kredit+$r->Kredit);
					$t_debet	=($t_debet+$r->Debet);
				}
				$a->Row(array($n,nBulan($i),number_format($debet,2),number_format($kredit,2),number_format($saldo,2)));		
			}
			$saldo_akhir=($id_Calc==2)? ($saldo_awal+$t_kredit-$t_debet):($saldo_awal+$t_debet-$t_kredit);

		  $a->Row(array('','SALDO AKHIR',number_format($t_debet,2),number_format($t_kredit,2),number_format($saldo_akhir,2)));
		  $a->Output('application/logs/'.$this->session->userdata('userid').'_bukubesar_tahunan.pdf','F');

/*//show pdf output in frame
$path='application/views/_laporan';
$img=" <img src='".base_url()."asset/images/back.png' onclick='js:window.history.back();' style='cursor:pointer' title='click for select other filter data'>";
panel_begin('Print Preview','','Back'.$img);
?>
		  <iframe src="<?=base_url();?>application/logs/<?=$this->session->userdata('userid');?>_rekap_simpanan_dept.pdf" height="100%" width="100%" frameborder="0" allowtransparency="1"></iframe>
<?
panel_end();
*/
?>
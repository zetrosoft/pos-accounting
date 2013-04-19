<?php
		  $a=new reportProduct();
		  $zn=new zetro_manager();
		  $nfile='asset/bin/zetro_master.frm';
		  //$a->Header();
		  $a->setKriteria("transkip");
		  $a->setNama("LAPORAN KAS HARIAN");
		  $a->setSection("lapkas");
		  $a->setFilter(array($dari_tgl,$sampai_tgl));
		  $a->setReferer(array('Dari Tanggal','Sampai Tanggal'));
		  $a->setFilename('asset/bin/zetro_master.frm');
		  $a->AliasNbPages();
		  $a->AddPage("P","A4");
		  $a->SetFont('Arial','',10);
		  // set lebar tiap kolom tabel transaksi
		  // set align tiap kolom tabel transaksi
		  $a->SetWidths(array(10,22,78,30,30));
		  $a->SetAligns(array("C","C","L","R","R"));
		  $a->SetFont('Arial','',9);
		  //$rec = $temp_rec->result();
		  $n=0;$kredit=0;$debit=0;
		  foreach($temp_rec->result_object() as $r)
		  {
			$n++;
			$a->Row(array($n,tglfromSql($r->tgl),
							($r->no_trans=='')? $r->uraian :$r->uraian." reff :".$r->no_trans,
							 number_format($r->kredit,2),
							 number_format($r->debit,2)));
			//sub tlot
			$kredit =($kredit+($r->kredit));
			$debit =($debit+($r->debit));
		  }
		  $a->SetFont('Arial','B',10);
		  $a->SetFillColor(225,225,225);
		  $a->Cell(110,8,"TOTAL",1,0,'R',true);
		  $a->Cell(30,8,number_format($kredit,2),1,0,'R',true);
		  $a->Cell(30,8,number_format($debit,2),1,0,'R',true);
		  $a->ln();
		  $a->Cell(140,8,"Saldo Kas",1,0,'R',true);
		  $a->Cell(30,8,number_format(($kredit-$debit),2),1,0,'R',true);
		  $a->Output('application/logs/'.$this->session->userdata('userid').'_laporan_beli.pdf','F');

//show pdf output in frame
$path='application/views/laporan';
$img=" <img src='".base_url()."asset/images/back.png' onclick='js:window.history.back();' style='cursor:pointer' title='click for select other filter data'>";
link_js('auto_sugest.js,lap_beli.js,jquery.fixedheader.js','asset/js,'.$path.'/js,asset/js');
panel_begin('Print Preview','','Back'.$img);
?>
		  <iframe src="<?=base_url();?>application/logs/<?=$this->session->userdata('userid');?>_laporan_beli.pdf" height="100%" width="100%" frameborder="0" allowtransparency="1"></iframe>
<?
panel_end();

?>
<?php
		  $a=new reportProduct();
		  $zn=new zetro_manager();
		  $nfile='asset/bin/zetro_master.frm';
		  //$a->Header();
		  $a->setKriteria("faktur");
		  $a->setNama("Faktur Penjualan Tunai");
		  $a->setSection("faktur");
		  $a->setFilter($alamat);
		  $a->setReferer($nm_nasabah);
		  $a->setFilename('asset/bin/zetro_master.frm');
		  $a->AliasNbPages();
		  $a->AddPage("P","A4");
		  $a->SetFont('Arial','',10);
		  // set lebar tiap kolom tabel transaksi
		  // set align tiap kolom tabel transaksi
		  $a->SetWidths(array(10,75,30,12,30,30));
		  $a->SetAligns(array("C","L","R","C","R","R"));
		  $a->SetFont('Arial','',9);
		  //$rec = $temp_rec->result();
		  $n=0;$kredit=0;$debit=0;
		  foreach($temp_rec->result_object() as $r)
		  {
			$n++;
			$a->Row(array($n,$r->nm_barang,
							 number_format($r->jml_transaksi,2),
							 $r->nm_satuan,
							 number_format($r->harga_beli,2),
							 number_format(($r->jml_transaksi*$r->harga_beli),2)
							 ));
			//sub tlot
			$kredit =($kredit+($r->jml_transaksi*$r->harga_beli));
			//$debit =($debit+($r->debit));
		  }
		  if($n<15){
			  $h=(6*(15-$n));
		  $a->MultiCell(187,$h,'',1,0,'L');  
		  }
		  $a->SetFont('Arial','B',10);
		  $a->SetFillColor(225,225,225);
		  $a->Cell(157,8,"Sub Total",1,0,'R',true);
		  $a->Cell(30,8,number_format($kredit,2),1,1,'R',true);
		  $a->Cell(157,8,"PPN 10%",1,0,'R',true);
		  $a->Cell(30,8,number_format(round(($kredit*10/100),0),2),1,1,'R',true);
		  $a->Cell(157,8,"Total",1,0,'R',true);
		  $a->Cell(30,8,number_format($kredit+round(($kredit*10/100),0),2),1,1,'R',true);
		  $a->SetFont('Arial','i',9);
		  $a->MultiCell(187,8,"Terbilang : ".$terbilang,1,'L','C');
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
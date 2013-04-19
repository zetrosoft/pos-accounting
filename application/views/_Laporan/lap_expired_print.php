<?php
		  $a=new reportProduct();
		  $zn=new zetro_manager();
		  //$a->Header();
		  $a->setKriteria("transkip");
		  $a->setNama("LAPORAN STOCK OBAT\n Detail Expired Date");
		  $a->setFilter(array($nm_jenis,$nm_kategori,$nm_golongan));
		  $a->setReferer(array('Jenis Obat','Kategori Obat','Sub Kategori'));
		  $a->setFilename('asset/bin/zetro_inv.frm');
		  $a->setSection("liststock_expr");
		  $a->AliasNbPages();
		  $a->AddPage("L","A4");
		  $a->SetFont('Arial','',10);
		  // set lebar tiap kolom tabel transaksi
		  // set align tiap kolom tabel transaksi
		  
		  $width='';
		  $jml_record=$zn->Count($a->getSection(),$a->getFilename());
		  for ($i=1;$i<=$jml_record;$i++){
			  $d=explode(',',$zn->rContent($a->getSection(),$i,$a->getFilename()));
				$width .=$d[9].",";
		  }
		  $a->SetWidths(array(10,20,25,35,75,20,18,22,30));
		  $a->SetAligns(array("C","L","L","L","L","R","C","C","R"));
		  $a->SetFont('Arial','',9);
		  //$rec = $temp_rec->result();
		  $n=0;$harga=0;
		  foreach($temp_rec->result_object() as $r)
		  {
			$n++;
			$a->Row(array($n,$r->nm_jenis, $r->nm_kategori,
							 $r->nm_golongan,
							 $r->nm_barang,
							 number_format($r->stock,2), $r->nm_satuan,
							 tglfromSql($r->expired),
							 number_format(($r->stock*$r->harga_beli),2)
							 )
					);
			//sub tlot
			$harga =($harga+($r->stock*$r->harga_beli));
		  }
		  $a->SetFont('Arial','B',10);
		  $a->SetFillColor(225,225,225);
		  $a->Cell(225,8,"TOTAL",1,0,'R',true);
		  $a->Cell(30,8,number_format($harga,2),1,0,'R',true);
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
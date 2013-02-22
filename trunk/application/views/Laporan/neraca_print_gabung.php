<?php
		  $a=new reportProduct();
		  $zn=new zetro_manager();
		  $nfile='asset/bin/zetro_conf.pdf.dll';
		  $TglLong=LongTgl($periode);
		  $TglBanding=LongTgl($pembanding);
		  //$unt=explode('-',$unit);
		  $a->setKriteria("neraca");
		  $a->setNama("Neraca Gabungan");
		  $a->setSection("");
		  $a->setFilter(array($TglLong));
		  $a->setReferer(array('Per'));
		  $a->setFilename('asset/bin/zetro_akun.frm');
		  $a->AliasNbPages();
		  //$a->AddPage("P","A4");
		  $a->AddPage($zn->rContent('Neraca','Posisi',$nfile),$zn->rContent('Neraca','Ukuran',$nfile));
		  $a->SetFont('Arial','',10);
		  // set lebar tiap kolom tabel transaksi
		  $a->SetWidths(array(90,30,30,30));
		  // set align tiap kolom tabel transaksi
		  $a->SetAligns(array("L","R","R","R"));
		  $a->SetFont('Arial','B',10);
		  //$a->Ln(1);
		  $a->SetFont('Arial','',9);
		  //$rec = $temp_rec->result();
		  $a->Row(array('','KBR','USP','GABUNGAN'),false);
		  $sql=mysql_query("select * from lap_head order by ID");$xx=0;
		  while($r=mysql_fetch_object($sql)){
			 $xx++;
			$a->SetFont('Arial','B',9);
			$a->Row(array($r->Header1),false);  
			$x=0; $saldoNc=0;$pasiva=0;$aktiva=0;$k=0;$Balance=0;$saldoNc2=0;$Balance2=0;
			//$unite=rdb("unit_jurnal",'Unit','Unit',"where ID='".$unit."'");
			$ljs=mysql_query("select * from lap_jenis where ID_Head='".$r->ID."'" );
			while($rjs=mysql_fetch_object($ljs)){
				$x++;
				$a->Row(array('    '.$x.". ".$rjs->Jenis),false); 
				$a->SetFont('Arial','',9);
				$lsbj="select * from lap_subjenis where ID_Jenis='".$rjs->ID."' order by NoUrut";
				$a->SetFont('Arial','',9);
				$n=0;$saldoA=0;$saldo2=0;$gabungan=0;
				$rs=mysql_query($lsbj) or die(mysql_error());
				while($rbj=mysql_fetch_object($rs)){
					$n++;
					$KBR=0;
					$USP=0;
					$KBR=rdb('tmp_'.$users.'_gabungan','KBR','KBR',"where ID_Jenis='".$rbj->ID."'");
					$USP=rdb('tmp_'.$users.'_gabungan','usp','usp',"where ID_Jenis='".$rbj->ID."'");
					$a->Row(array('            '.$n.". ".$rbj->SubJenis,
						number_format($KBR,0),
						number_format($USP,0),
						number_format(($KBR+$USP),0)),false); 	
					$saldoA=($saldoA+$KBR);
					$saldo2=($saldo2+$USP);
				}
					$a->SetFont('Arial','I',9);
					$a->Row(array('            TOTAL '.$rjs->Jenis,number_format($saldoA,0),number_format($saldo2,0),number_format(($saldoA+$saldo2),0)),false);
					$a->SetFont('Arial','',9);
					$a->ln(2);
				    $saldoNc=($saldoNc+$saldoA);
					$saldoNc2=($saldoNc2+$saldo2);
			}
			//$a->ln(1);
			$a->SetFont('Arial','B',9);
			$a->Row(array('            TOTAL '.$r->Header1,number_format($saldoNc,0),number_format($saldoNc2,0),number_format(($saldoNc+$saldoNc2),0)),false);
			$a->SetFont('Arial','',9);
		  }
		   $a->Output('application/logs/'.$this->session->userdata('userid').'_neraca_gab.pdf','F');

//show pdf output in frame
$path='application/views/_laporan';
$img=" <img src='".base_url()."asset/images/back.png' onclick='js:window.history.back();' style='cursor:pointer' title='click for select other filter data'>";
panel_begin('Print Preview','','Back'.$img);
?>
		  <iframe src="<?=base_url();?>application/logs/<?=$this->session->userdata('userid');?>_neraca_gab.pdf" height="100%" width="100%" frameborder="0" allowtransparency="0"></iframe>
<?
panel_end();

?>
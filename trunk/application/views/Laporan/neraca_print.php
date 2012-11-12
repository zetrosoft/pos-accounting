<?php
		  $a=new reportProduct();
		  $zn=new zetro_manager();
		  $nfile='asset/bin/zetro_conf.pdf.dll';
		  $TglLong=LongTgl($periode);
		  $unt=explode('-',$unit);
		  $a->setKriteria("neraca");
		  $a->setNama("Neraca ".rdb("unit_jurnal",'Unit','Unit',"where ID='".$unt[0]."'"));
		  $a->setSection("");
		  $a->setFilter(array($TglLong));
		  $a->setReferer(array('Per'));
		  $a->setFilename('asset/bin/zetro_akun.frm');
		  $a->AliasNbPages();
		  //$a->AddPage("P","A4");
		  $a->AddPage($zn->rContent('Neraca','Posisi',$nfile),$zn->rContent('Neraca','Ukuran',$nfile));
		  $a->SetFont('Arial','',10);
		  // set lebar tiap kolom tabel transaksi
		  $a->SetWidths(array(120,30,30));
		  // set align tiap kolom tabel transaksi
		  $a->SetAligns(array("L","R","R"));
		  $a->SetFont('Arial','B',10);
		  //$a->Ln(1);
		  $a->SetFont('Arial','',9);
		  //$rec = $temp_rec->result();
		  //$a->Row(array('',$TglLong),false);
		  $sql=mysql_query("select * from lap_head order by ID");$xx=0;
		  while($r=mysql_fetch_object($sql)){
			 $xx++;
			$a->SetFont('Arial','B',9);
			$a->Row(array($r->Header1),false);  
			$x=0; $saldoNc=0;$pasiva=0;$aktiva=0;$k=0;$Balance=0;
			$unite=rdb("unit_jurnal",'Unit','Unit',"where ID='".$unt[0]."'");
			$ljs=mysql_query("select * from lap_jenis where ID_Head='".$r->ID."' and ID_$unite='1'");
			while($rjs=mysql_fetch_object($ljs)){
				$x++;
				$a->Row(array('    '.$x.". ".$rjs->Jenis),false); 
				$lsbj="select * from lap_subjenis where ID_$unite='1' /*and ID_Lap='".$r->ID."'*/ and ID_Jenis='".$rjs->ID."' order by NoUrut";
				//echo $lsbj;
				$a->SetFont('Arial','',9);
				$n=0;$saldoA=0;$saldo=0;$SaldoLj=0;
				$rs=mysql_query($lsbj) or die(mysql_error());
				while($rbj=mysql_fetch_object($rs)){
					$n++;
					$saldoA=rdb("perkiraan",'SaldoAwal','sum(SaldoAwal) as SaldoAwal',"where ID_Laporan='2' and ID_Unit='$unit' and ID_LapDetail='".$rbj->ID."'");
					$idCalc=rdb("perkiraan",'ID_Calc','ID_Calc',"where ID_Laporan='2' and ID_Unit='$unit' and ID_LapDetail='".$rbj->ID."'");
					$ss="select id_calc,sum(debet) as debet,sum(kredit) as kredit from tmp_".$users."_transaksi_rekap where ID_Laporan='2' and ID_Unit='$unit' and id_lapdetail='".$rbj->ID."'";
					//echo $ss;
					$rss=mysql_query($ss) or die(mysql_error());
					$rw=mysql_fetch_object($rss);
					if($rbj->ID=='35' ||$rbj->ID=='36'){ //  
					  if($rbj->ID=='36'){
						$shu1=rdb("tmp_".$users."_total_shu","saldo","saldo","where unit='".$unt[0]."'");
						$saldo=($shu1);
					 }else if($rbj->ID=='35'){
						if($unt[0]==2){
						$shu12=rdb("tmp_".$users."_total_shu","saldo2","saldo2","where unit='".$unt[0]."'");
						$saldo=($shu12);
						}else{
						 if( substr($periode,0,4)<='2001'){
							$SHU_T_lalu=rdb("tmp_".$users."_transaksi_rekap",'SalDone','(sum(Kredit)-sum(Debet)) as SalDone',"where ID_Laporan='2' and ID_Unit='$unit' and id_lapdetail='35'");
							$saldo=$SHU_T_lalu;  
						 }else{
							$saldo='0';
						 }
						}
					  }
					}else{
						$saldo=($idCalc==1)?($saldoA+($rw->debet-$rw->kredit)):($saldoA+($rw->kredit-$rw->debet));
					}
					//($saldo<0)?	$a->SetTextColor(237,15,151):	$a->SetTextColor(0);
					$a->Row(array('            '.$n.". ".$rbj->SubJenis,number_format($saldo,2)),false); 	
					$SaldoLj=($SaldoLj+$saldo);
					//$Balance=($rbj->ID_Calc==1)?($Balance+$saldo):($Balance-$saldo);
				}
					$a->SetFont('Arial','B',9);
					$a->Row(array('            TOTAL '.$rjs->Jenis,number_format($SaldoLj,2)),false);
					$a->SetFont('Arial','',9);
					$a->ln(2);
				    $saldoNc=($saldoNc+$SaldoLj);
			}
			//$a->ln(1);
			$a->SetFont('Arial','B',9);
			$a->Row(array('            TOTAL '.$r->Header1,number_format($saldoNc,2)),false);
			$a->SetFont('Arial','',9);
			$ap=($xx==1)?
				"insert into tmp_".$users."_neraca_balance (unit,periode,".$r->Header2.")
					 values('".$unt[0]."','".tglToSql($periode)."','".$saldoNc."')":
				"update tmp_".$users."_neraca_balance set ".$r->Header2."='".$saldoNc."'
				 where periode='".tglToSql($periode)."' and unit='".$unt[0]."'" ;
				 echo $ap;
				 mysql_query($ap) or die(mysql_error());
		  }
		   $Balance=rdb("tmp_".$users."_neraca_balance","saldo","(Pasiva-Aktiva) as saldo",
		   				"where periode='".tglToSql($periode)."' and unit='".$unt[0]."'");
		  	$a->Row(array('            SELISIH ',number_format($Balance,2)),false);

		  $a->Output('application/logs/'.$this->session->userdata('userid').'_neraca.pdf','F');

//show pdf output in frame
$path='application/views/_laporan';
$img=" <img src='".base_url()."asset/images/back.png' onclick='js:window.history.back();' style='cursor:pointer' title='click for select other filter data'>";
link_js('auto_sugest.js,lap_beli.js,jquery.fixedheader.js','asset/js,'.$path.'/js,asset/js');
panel_begin('Print Preview','','Back'.$img);
?>
		  <iframe src="<?=base_url();?>application/logs/<?=$this->session->userdata('userid');?>_neraca.pdf" height="100%" width="100%" frameborder="0" allowtransparency="1"></iframe>
<?
panel_end();

?>
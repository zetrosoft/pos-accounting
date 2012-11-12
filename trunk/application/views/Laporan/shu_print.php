<?php
		  $a=new reportProduct();
		  $zn=new zetro_manager();
		  $nfile='asset/bin/zetro_conf.pdf.dll';
		  //$a->Header();
		  $unt=explode('-',$unit);
		  $a->setKriteria("neraca");
		  $a->setNama("SHU Unit      : ".rdb("unit_jurnal",'Unit','Unit',"where ID='".$unt[0]."'"));
		  $a->setSection("");
		  $a->setFilter(array($periode ." s/d ".$akhir));
		  $a->setReferer(array('Periode'));
		  $a->setFilename('asset/bin/zetro_akun.frm');
		  $a->AliasNbPages();
		  $a->AddPage($zn->rContent('Laporan SHU','Posisi',$nfile),$zn->rContent('Laporan SHU','Ukuran',$nfile));
	
		  $a->SetFont('Arial','',10);
		  // set lebar tiap kolom tabel transaksi
		  $a->SetWidths(array(120,30,30));
		  // set align tiap kolom tabel transaksi
		  $a->SetAligns(array("L","R","R"));
		  $a->SetFont('Arial','B',10);
		  //$a->Ln(1);
		  $a->SetFont('Arial','',9);
		  //$rec = $temp_rec->result();
			$x=0; $saldoNc=0;$pasiva=0;$aktiva=0;
			$unite=rdb("unit_jurnal",'Unit','Unit',"where ID='".$unt[0]."'");
			($unt[0]==3)?$united='':$united="and ID_$unite='1'";
			$ljs=mysql_query("select * from lap_jenis where ID_Head='0' $united");
			//kosongkan tabel shu head
			mysql_query("truncate table lap_shu_head") or die(mysql_error());
			//jenis pengelompokan 
			while($rjs=mysql_fetch_object($ljs)){
				$x++;
				$a->Row(array('   '.$x.". ".$rjs->Jenis),false); 
				$lsbj="select * from lap_subjenis where ID_Jenis='".$rjs->ID."' $united order by NoUrut";
				//echo $lsbj;
				//content pengelompokan
				$a->SetFont('Arial','',9);
				$n=0;$saldoA=0;$saldo=0;$SaldoLj=0;
				$rs=mysql_query($lsbj) or die(mysql_error());
				while($rbj=mysql_fetch_object($rs)){
					$n++;
					($unt[0]==3)?$id_unit='':$id_unit="and ID_Unit='$unit'";
					$saldoA=rdb("perkiraan",'SaldoAwal','sum(SaldoAwal) as SaldoAwal',"where ID_Laporan='1' $id_unit and ID_LapDetail='".$rbj->ID."'");
					$idCalc=rdb("perkiraan",'ID_Calc','ID_Calc',"where ID_Laporan='1' $id_unit and ID_LapDetail='".$rbj->ID."'");
					$ss="select id_calc,sum(debet) as debet,sum(kredit) as kredit from tmp_".$users."_transaksi_rekap where (Tanggal between '".tglToSql($periode)."' and '".tglToSql($akhir)."') and ID_Laporan='1' $id_unit and id_lapdetail='".$rbj->ID."'";
					//echo $ss;
					$rss=mysql_query($ss) or die(mysql_error());
					$rw=mysql_fetch_object($rss);
					$saldo=($idCalc==1 && $rbj->ID!='61')?($saldoA+($rw->debet-$rw->kredit)):($saldoA+($rw->kredit-$rw->debet));
					$a->Row(array('            '.$n.".".$rbj->SubJenis,number_format($saldo,2)),false,($saldo<0)?true:false,1); 	
					$SaldoLj=($SaldoLj+$saldo);
					$saldoNc=($rbj->ID_Calc==1 && $rbj->ID!='61')?($saldoNc-$saldo):($saldoNc+$saldo);
				}
					$a->SetFont('Arial','B',9);
					$a->Row(array('            TOTAL '.$rjs->Jenis,number_format($SaldoLj,2)),false);
					$a->SetFont('Arial','',9);
					$a->ln(2);
			}
			//$a->ln(1);
			$a->SetFont('Arial','B',9);
			$a->Row(array('            SHU SEBELUM PPH (I-II-III+IV) ',number_format($saldoNc,2)),false);
			$a->SetFont('Arial','',9);
	//	  }
	//	  	$a->Row(array('            SELISIH ',number_format(($aktiva-$pasiva),2)),false);

		  $a->Output('application/logs/'.$this->session->userdata('userid').'_rekap_shu.pdf','F');

//show pdf output in frame
$path='application/views/_laporan';
$img=" <img src='".base_url()."asset/images/back.png' onclick='js:window.history.back();' style='cursor:pointer' title='click for select other filter data'>";
link_js('auto_sugest.js,lap_beli.js,jquery.fixedheader.js','asset/js,'.$path.'/js,asset/js');
panel_begin('Print Preview','','Back'.$img);
?>
		  <iframe src="<?=base_url();?>application/logs/<?=$this->session->userdata('userid');?>_rekap_shu.pdf" height="100%" width="100%" frameborder="0" allowtransparency="1"></iframe>
<?
panel_end();

?>
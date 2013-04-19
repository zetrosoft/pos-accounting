<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_member.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_member.frm');
$path='application/views/member';
link_js('jquery.fixedheader.js,zetro_number.js','asset/js,asset/js');
link_js('member_pinjaman_barang_detail.js',$path."/js");
tab_head('Pinjaman Detail');
addText(array('Nama Anggota','','Departemen',''),array('','<b>'.$Agt.'</b>','','<b>'.$Dept.'</b>'));
panel_multi('penjualan','block',false);
addText(array('Transaksi Penjualan'),array('Barang'));
		$zlb->section('detailkredit');
		$zlb->aksi(false);
		$zlb->icon();
		$zlb->Header('100%','detail_tbl');
		echo "</tbody></table>";
panel_multi_end();
panel_multi('saldokredit','none',false);
		$zlb->section('detailjurnal');
		$zlb->aksi(false);
		$zlb->icon();
		$zlb->Header('100%','detail_jurnal');
		echo "</tbody></table>";
panel_multi_end();
echo "<hr>
		<div id='btn' style='width:90%; border:0px outset #CCC;padding:5px; padding-right:20px' align='right'>
		<!--input type='button' id='cetak_b' value='Print'-->
		<input type='button' id='keluar_b' value='Keluar'></div>";
tab_head_end();

?>
<input type='hidden' id='id_agt' value='<?=$ID_Agt;?>' />




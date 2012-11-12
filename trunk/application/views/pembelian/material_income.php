<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_beli.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_beli.frm');
$path='application/views/pembelian';
Calender();
link_css('jquery.coolautosuggest.css','asset/css');
link_js('jquery.coolautosuggest.js','asset/js');
link_js('jquery.fixedheader.js','asset/js');
link_js('material_income_list.js',$path.'/js');
link_js('material_income.js,jquery_terbilang.js',$path.'/js,asset/js');
panel_begin('Pembelian');
panel_multi('inputpembelian','none',false);
if($c_pembelian__index!=''){
	$zfm->AddBarisKosong(false);
	$zfm->Start_form(true,'frm1');
	$zfm->BuildForm('pembelian',false,'60%');
	echo "<hr><form id='frm2' name='frm2' method='post' action=''>";
		$zlb->section('pembelianlist');
		$zlb->aksi(true);
		$zlb->Header('97%');
		echo "<tr><td class='kotak' colspan='8'>&nbsp;</td>";
		echo "</tbody><tfoot>";
		$zfm->section('pembelianlist');
		$zfm->rowCount();
		$zfm->button('simpan');
		$zfm->BuildGrid();
		echo "</tfoot></table></form>";
}else{
	no_auth();
}
panel_multi_end();
panel_multi('listpembelian','block',false);
if($all_pembelian__list_beli!=''){
addText(array('Periode Dari','Sampai',''),
		array("<input type='text' id='dari_tanggal' value='' class='w100'>",
			  "<input type='text' id='smp_tanggal' value='' class='w100'>",
			  "<input type='button' id='okelah' value='OK'>"));
		$zlb->section('lappembelian');
		$zlb->aksi(false);
		$zlb->Header('100%','newTable');
		echo "</tbody></table>";
}else{
	no_auth();
}
panel_multi_end();
panel_end();
auto_sugest();
tab_select('prs');
terbilang();
?>
<input type="hidden" id='id_sat' value='' />
<input type="hidden" id='id_brg' value='' />
<input type="hidden" id='total_beli' value='0' />
<input type="hidden" id='trans_new' value='' />
<input type="hidden" id='id_pemasoke' value='' />
<input type='hidden' id='aktif_user' value='<?=$this->session->userdata('idlevel');?>'/>

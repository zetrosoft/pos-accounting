<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_neraca.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_neraca.frm');
$path='application/views/laporan/transaksi';
calender();
link_css('jquery.coolautosuggest.css','asset/css');
link_js('jquery.coolautosuggest.js','asset/js');
link_js('auto_sugest.js,lap_jual.js,jquery.fixedheader.js','asset/js,'.$path.'/js,asset/js');
panel_begin('Penjualan per Pelanggan');
panel_multi('penjualanperpPelanggan','block',false);
if($all_penjualanperpelanggan!=''){
	echo "<form id='frm1' name='frm1' method='post' action=''>";
	addText(array('Nama Pelanggan','Periode  :',' s/d ',''),
	array("<input type='text' id='nm_anggota' name='nm_anggota' value='' class='cari w100'>",
		  "<input type='text' id='dari_tgl' name='dari_tgl' value=''>",
		  "<input type='text' id='sampai_tgl' name='sampai_tgl' value=''>",
		  "<input type='button' value='OK' id='okedechya'>
		  <input type='hidden' id='ID_Anggota' name='ID_Anggota' value=''"));
/*	addText(array('Order by :','Sort by','',''),
			array("<select id='orderby' name='orderby'>".selectTxt('susunanbeli',false,'asset/bin/zetro_member.frm')."</select>",
				  "<select id='urutan' name='urutan'>".selectTxt('Urutan',true)."</select>",
				  "<input type='button' value='OK' id='okelah'/>",''));
*/	echo "</form>";
	echo "</tbody></table>";
	echo "<table id='xx' width='100%'><tbody><tr><td>&nbsp;</td></tr></tbody></table>";
}else{
	no_auth();
}
panel_multi_end();
auto_sugest();
panel_end();
?>
<input type='hidden' value="<?=$this->session->userdata('menus');?>" id='aktif'/>
<script language="javascript">
$(document).ready(function(e) {
    $('#pembelianpervendor').removeClass('tab_button');
	$('#pembelianpervendor').addClass('tab_select');
});
</script>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_neraca.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_neraca.frm');
$path='application/views/laporan/transaksi';
calender();
link_css('jquery.coolautosuggest.css','asset/css');
link_js('jquery.coolautosuggest.js','asset/js');
link_js('auto_sugest.js,lap_beli.js,jquery.fixedheader.js','asset/js,'.$path.'/js,asset/js');
panel_begin('Rekap Pembelian');
panel_multi('rekappembelian','block',false);
if($all_rekappembelian!=''){
	echo "<form id='frm1' name='frm1' method='post' action=''>";
	addText(array('Periode :',' s/d ','Jenis Pembelian',''),
	array("<input type='text' id='dari_tgl' name='dari_tgl' value=''>",
		  "<input type='text' id='sampai_tgl' name='sampai_tgl' value=''>",
		  "<select id='jenis_beli' name='jenis_beli'></select>",
		  "<input type='button' value='OK' id='okelah'>"));
	echo "</form>";
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
	$('#jenis_beli').html("<? dropdown('inv_pembelian_jenis','ID','Jenis_Beli','','1');?><option value='3'>Return Konsinyasi</option>");
	if($('#aktif').val()=='SW52TWVudQ=='){
		$('table#addtxt tr td#c1-2').show();
		$('table#addtxt tr td#c2-2').show();
	}else if($("#aktif").val()=='QWNjb3VudGluZw=='){
		$('table#addtxt tr td#c1-2').hide();
		$('table#addtxt tr td#c2-2').hide();
	}
});
</script>
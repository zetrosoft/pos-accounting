<?php
$zfm=new zetro_frmBuilder('asset/bin/zetro_master.frm');
$section='Barang';
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_master.frm');
$path='application/views/master';
link_css('autosuggest.css','asset/css');
link_js('auto_sugest.js,jquery.fixedheader.js,master_kas_harian.js,jquery_terbilang.js','asset/js,asset/js,'.$path.'/js,asset/js');
tab_select('');
panel_begin('Kas Toko');
panel_multi('setupsaldokas');
if($all_kas_harian!=''){
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm1');
	$zfm->BuildForm('kasharian',($e_kas_harian=='' || $c_kas_harian=='')? false:true,'50%');
	($e_kas_harian=='' || $c_kas_harian=='')?'': $zfm->BuildFormButton('Simpan','kas');
	echo "<hr>";
	buildgrid('mst_kas_harian','tgl_kas','kasharian',true,'deleted');
}else{
	no_auth();
}
panel_multi_end();
panel_multi('operasionaltoko','block');
if($all_kas_keluar!=''){
	$zfm->AddBarisKosong(false);
	$zfm->Start_form(true,'frm2');
	$zfm->BuildForm('kaskeluar',($e_kas_keluar=='' || $c_kas_keluar=='')? false:true,'50%');
	($e_kas_keluar=='' || $c_kas_keluar=='')?'': $zfm->BuildFormButton('Simpan','kaskeluar');
	echo "<hr>";
	buildgrid("detail_transaksi where tgl_transaksi='".date('Y-m-d')."' and (jenis_transaksi='D' or jenis_transaksi='DR')",'no_transaksi','kaskeluar',true,'deleted');
}else{
	no_auth();
}
panel_multi_end();
auto_sugest();
tab_select('prs');
panel_end();
terbilang();
function buildgrid($table,$field,$section,$aksi=true,$icon=''){
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_master.frm');
	$sql2="select * from $table order by $field";
	//echo $sql2;
		$zlb->section($section);
		$zlb->aksi($aksi);
		$zlb->icon($icon);
		$zlb->query($sql2);
		$zlb->sub_total(false);
		$zlb->sub_total_field('stock,blokstok');
		$zlb->Header('100%');
		$zlb->list_data($section);
		$zlb->BuildListData($field);
		echo "</tbody></table>";
}

?>
<input type='hidden' id='trans_new' value='D' />
<script language="javascript">
	$(document).ready(function(e) {
        $('#v_setupsaldokas table#ListTable').fixedHeader({width:700, height:250})
        $('#v_operasionaltoko table#ListTable').fixedHeader({width:850, height:250})
    });
</script>

<?php
$zfm=new zetro_frmBuilder('asset/bin/zetro_master.frm');
$section='Barang';
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_master.frm');
$path='application/views/master';
link_js('jquery.fixedheader.js,master_general.js,jquery_terbilang.js','asset/js,'.$path.'/js,asset/js');
tab_select('');

panel_begin('Data General');
panel_multi('datapelanggan','block');
$mst='_pelanggan';
if($all_pelanggan!=''){
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm1');
	$zfm->BuildForm('pelanggan',($e_pelanggan=='' || $c_pelanggan=='')? false:true,'50%');
	($c_pelanggan=='' || $e_pelanggan=='')?'':$zfm->BuildFormButton('Simpan','pelanggan');
	echo "<hr>";
	buildgrid('mst_pelanggan','nm_pelanggan','pelanggan');
}else{
	no_auth();
}
panel_multi_end();
panel_multi('datadokter');
$dd='_dokter';
if($all_dokter!=''){
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm2');
	$zfm->BuildForm('dokter',($e_dokter=='' || $c_dokter=='')? false:true,'50%');
	($e_dokter=='' || $c_dokter=='')?'': $zfm->BuildFormButton('Simpan','dokter');
	echo "<hr>";
	buildgrid('mst_dokter','al_dokter','dokter');
}else{
	no_auth();
}
panel_multi_end();
panel_multi('datakas');
$mk='_kas';
if($all_kas!=''){
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm3');
	$zfm->BuildForm('Kas',($e_kas=='' || $c_kas=='')? false:true,'50%');
	($e_kas=='' || $c_kas=='')?'': $zfm->BuildFormButton('Simpan','kas');
	echo "<hr>";
	buildgrid('mst_kas','nm_kas','Kas');
}else{
	no_auth();
}
panel_multi_end();
auto_sugest();
tab_select('prs');
panel_end();
terbilang();
function buildgrid($table,$field,$section){
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_master.frm');
	$sql2="select * from $table order by $field";
		$zlb->section($section);
		$zlb->aksi();
		$zlb->icon();
		$zlb->query($sql2);
		$zlb->sub_total(false);
		$zlb->sub_total_field('stock,blokstok');
		$zlb->Header('100%');
		$zlb->list_data($section);
		$zlb->BuildListData($field);
		echo "</tbody></table>";
}

?>

<script language="javascript">
	$(document).ready(function(e) {
        $('#v_datapelanggan table#ListTable').fixedHeader({width:700, height:200})
        $('#v_datadokter table#ListTable').fixedHeader({width:700, height:200})
        $('#v_datakas table#ListTable').fixedHeader({width:700, height:200})
    });
</script>


<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_neraca.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_neraca.frm');
$path='application/views/warehouse';
link_js('jquery.fixedheader.js','asset/js');
link_js('material_stocklist.js',$path.'/js');
calender();
panel_begin('Persediaan');
panel_multi('liststock','block',false);
if($all_liststock!=''){
	echo "<form id='frm1' name='frm1' method='post' action=''>";
	addText(array('Kategori','Status','',''),
			array("<select id='Kategori' name='Kategori'></select>",
				  "<select id='Stat' name='Stat'>
					  <option value=''>Semua</option>
					  <option value='Continue'>Continue</option>
					  <option value='Discontinue'>Discontinue</option>
				  </select>",
				  "<input type='button' value='OK' id='okelah'/>",
				  "<input type='button' value='Print' id='prt'/>"));
	echo "</form>";
		$zlb->section('stocklist');
		$zlb->aksi(true);
		$zlb->icon();
		$zlb->Header('100%','stoked');
	echo "</tbody></table>";
}else{
	 no_auth();
}

panel_multi_end();
panel_end();
popup_start('stocklist','Stock Adjustment',550);
$fld="<input type='hidden' id='id_barang' val=''/>";
$fld.="<input type='hidden' id='batch' val=''/>";
	$zfm->Addinput($fld);
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm2');
	$zfm->BuildForm('stocklist',true,'100%');
	$zfm->BuildFormButton('Simpan','edit_mat');
popup_end();

?>
<script language="javascript">
$(document).ready(function(e) {
    $('#Kategori').html("<? dropdown('inv_barang_kategori','ID','Kategori','order by Kategori','7');?>")
});


</script>

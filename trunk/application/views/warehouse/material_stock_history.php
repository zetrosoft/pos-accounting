<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_inv.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_inv.frm');
$path='application/views/warehouse';
link_css('jquery.coolautosuggest.css','asset/css');
link_js('jquery.coolautosuggest.js','asset/js');
link_js('jquery.fixedheader.js','asset/js');
link_js('material_stock_hist.js',$path.'/js');
calender();
panel_begin('Persediaan');
panel_multi('liststock','block',false);
if($all_gudang__stock_history!=''){
	echo "<form id='frm1' name='frm1' method='post' action=''>";
	addText(array('Tanggal','s/d','Jenis Barang','Group by',''),
			array("<input type='text' id='dari_tgl' name='dari_tgl' value=''>",
				  "<input type='text' id='sampai_tgl' name='sampai_tgl' value=''>",
				  "<select id='Kategori' name='Kategori'></select>",
				  "<select id='filter' name='filter'>
				  	<option value='ID'>Material</option>
					<option value='ID_Pemasok'>Pemasok</option>
				  </select>",''));
	addText(array('Cari Pemasok','',''),
			array("<input type='text' id='carilah' name='carilah' class='cari w100' value=''>",
				  "<input type='button' value='OK' id='okelah'/>",
				  "<input type='button' value='Print' id='prt'/>
				  <input type='hidden' id='id_pemasok' name='id_pemasok' value=''>"));
	echo "</form>";
		$zlb->section('laphistory');
		$zlb->aksi(false);
		$zlb->icon();
		$zlb->Header('100%','stoked');
	echo "</tbody></table>";
}else{
	 no_auth();
}

panel_multi_end();
?>
<script language="javascript">
$(document).ready(function(e) {
    $('#Kategori').html("<? dropdown('inv_barang_kategori','ID','Kategori','order by Kategori','7');?>")
});


</script>

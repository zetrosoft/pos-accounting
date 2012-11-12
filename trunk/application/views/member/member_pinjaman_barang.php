<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_member.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_member.frm');
$path='application/views/member';
link_css('jquery.coolautosuggest.css','asset/js');
link_js('jquery.coolautosuggest.js','asset/js');
link_js('jquery.fixedheader.js','asset/js');
link_js('member_pinjaman_barang.js',$path."/js");
panel_begin('Anggota.');
panel_multi('pinjamanbarang','block',false);
if($all_pinjamanbarang!=''){
	addText(array('Departemen','Status','','','Cari Nama Anggota',''),
			array("<select id='departement' name='departement'></select>",
				  "<select id='stat' name='stat'></select>",
				  '<input type="button" id="okelah" value="OK">','',
				  "<input type='text' id='carilah' value='' class='cari w100'>",
				  '<input type="button" id="cariya" value="Cari">'));
		$zlb->section('pinjamanbarang');
		$zlb->aksi(true);
		$zlb->Header('100%');
		$zlb->icon('deleted');
		echo "</tbody></table>";
}else{
	no_auth();
}
echo "<table id='lod' widt='100%'><tbody></tbody></table>";
panel_multi_end();
panel_end();
popup_full();
?>
<script language="javascript">
	$(document).ready(function(e) {
        $('#departement').html("<? dropdown('mst_departemen','ID','Departemen',"order by Departemen");?>");
		$('#stat').html("<option value=''>Semua</option><? dropdown('keaktifan','ID','Keaktifan','order by ID');?>")
    });
</script>
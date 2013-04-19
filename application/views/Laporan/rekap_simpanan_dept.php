<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_neraca.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_neraca.frm');
$path='application/views/laporan';
link_css('jquery.coolautosuggest.css','asset/css');
link_js('jquery.coolautosuggest.js','asset/js');
link_js('jquery.fixedheader.js,jquery_terbilang.js','asset/js,asset/js');
link_js('rekap_simpanan_dept.js',$path.'/js');
panel_begin('Simpanan/Pinjaman/Piutang');
panel_multi('rekappiutangbarang','block',false);
echo "<form name='frm_j' id='frm_j' method='post' action=''>";
addText(array('Periode','',''),
		array('',"<select id='bln' name='bln' class='s100'></select>",
				"<select id='thn' name='thn' class='s100'></select>"));
addText(array('Departement'),array("<select id='ID_Dept' name='ID_Dept' class='s100'></select>"));
addText(array('Perkiraan  '),array("<select id='ID_Simpanan' name='ID_Simpanan' class='s100'></select>"));
addText(array(nbs(2)),array("<input type='button' id='okelah' value='Process'>"));
echo "</form>";
echo "<table id='xx' width='100%'><tbody></tbody></table>";

panel_multi_end();
panel_end();

?>

<script language="javascript">
	$(document).ready(function(e) {
        $('#bln').html("<? dropdown('mst_bulan','ID','Bulan','order by ID',round(date('m')));?>")
		$('#ID_Dept').html("<option value=''>Semua</option><? dropdown('mst_departemen','ID','Departemen','Order by Kode');?>")
		$('#ID_Simpanan').html("<? dropdown('jenis_simpanan','ID','Jenis','Order by ID');?>")
    });

</script>
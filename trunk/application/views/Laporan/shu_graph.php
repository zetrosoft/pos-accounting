<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$path='application/views/laporan';
link_js('FusionCharts.js','asset/js');
link_js('shu_graph.js',$path.'/js');
panel_begin('Grafik SHU');
panel_multi('grafikshu','block');
if($all_grafikshu!=''){
echo "<div id='chartdiv' align='center'>";
		echo tabel()."<thead>";
		echo tr('headere\' align=\'left').th('Kalkulasi SHU');
		echo _tr()."</thead><tbody>";/**/
		echo _tabel(true);
echo "</div>";
}else{
	no_auth();
}
panel_multi_end();
panel_end();
loading_ajax();
?>

<script language="javascript">
function show_graph(id){
	var height=(screen.height-300);
	var width=(screen.width-50);
		   var chart = new FusionCharts("<?=base_url();?>chart/FCF_MSColumn3D.swf", "ChartId", width, height);
		   chart.setDataURL("<?=base_url().$this->session->userdata('userid');?>_graph.xml");		
		   chart.render(id);
}

</script>

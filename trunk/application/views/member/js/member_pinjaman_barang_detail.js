$(document).ready(function(e) {
	$('#mm_detail table#tab tr td#penjualan').removeClass('tab_button');
	$('#mm_detail table#tab tr td#penjualan').addClass('tab_select');
	$('#mm_detail table#tab tr td:not(#kosong)').click(function(){
		var id=$(this).attr('id');
				$('#mm_detail table#tab tr td#'+id).removeClass('tab_button');
				$('#mm_detail table#tab tr td#'+id).addClass('tab_select');
				$('#mm_detail table#tab tr td:not(#'+id+',.flt,.plt)').removeClass('tab_select');
				$('#mm_detail table#tab tr td:not(#'+id+',#kosong,.flt,.plt)').addClass('tab_button');
				$('#mm_detail span#v_'+id).show();
				$('#mm_detail span:not(#v_'+id+')').hide();
				if(id!='penjualan'){
					_show_jurnal();
				}
	})
	$('#keluar_b').click(function(){
		$('#mm_lock').hide();	
		$('#mm_detail').hide();
	})
	_show_trans();

})

function _show_trans(){
	show_indicator('detail_tbl',7)
	$.post('show_detail_kreditur_trans',{'ID_Agt':$('#id_agt').val()},
	function(result){
		$('table#detail_tbl tbody').html(result)
		$('table#detail_tbl').fixedHeader({width:($('#mm_detail').width()-100),height:($('#mm_detail').height()-300)})
	})
}

function _show_jurnal(){
	show_indicator('detail_jurnal',6)
	$.post('show_detail_kreditur_jurnal',{'ID_Agt':$('#id_agt').val()},
	function(result){
		$('table#detail_jurnal tbody').html(result)
		$('table#detail_jurnal').fixedHeader({width:($('#mm_detail').width()-100),height:($('#mm_detail').height()-300)})
	})
}
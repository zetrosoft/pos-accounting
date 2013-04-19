// JavaScript Document
$(document).ready(function(e){
	$('#rekappiutangbarang').removeClass('tab_button');
	$('#rekappiutangbarang').addClass('tab_select');
	
	$('table#panel tr td:not(.flt,.plt)').click(function(){
		var id=$(this).attr('id');
				$('#'+id).removeClass('tab_button');
				$('#'+id).addClass('tab_select');
				$('table#panel tr td:not(#'+id+',.flt,.plt)').removeClass('tab_select');
				$('table#panel tr td:not(#'+id+',#kosong,.flt,.plt)').addClass('tab_button');
				$('span#v_'+id).show();
				$('span:not(#v_'+id+')').hide();
				$('#prs').val(id);
	})
	_get_tahun();
	$('#okelah').click(function(){
/*		$.post('get_rkp_simpan_dept',{
			'bln'	:$('#bln').val(),
			'thn'	:$('#thn').val(),
			'ID_Dept':$('#ID_Dept').val(),
			'ID_Simp':$('#ID_Simpanan').val()
		},function(result){
			
		})
*/	show_indicator('xx',1);
	$('#frm_j').attr('action','get_rkp_simpan_dept');
		document.frm_j.submit();
	})
})
function _get_tahun(){
var path=$('#path').val();
	$.post(path+'akuntansi/dropdown_tahun',{'ID':''},
	function(result){
		$('#thn').html(result);
	})
}

// JavaScript Document
$(document).ready(function(e) {
	var path=$('#path').val();
	var prs=$('#prs').val();
		$('#daftaranggota').removeClass('tab_button');
		$('#daftaranggota').addClass('tab_select');
	$('table#panel tr td:not(.flt,.plt,#kosong)').click(function(){
		var id=$(this).attr('id');
				$('#'+id).removeClass('tab_button');
				$('#'+id).addClass('tab_select');
				$('table#panel tr td:not(#'+id+',.flt,.plt)').removeClass('tab_select');
				$('table#panel tr td:not(#'+id+',#kosong,.flt,.plt)').addClass('tab_button');
				$('span#v_'+id).show();
				$('span:not(#v_'+id+')').hide();
				//$('#prs').val(id);
	})
	if($('#otor').val()==''){
		lock('#dept,#stat')
	}else{
		unlock('#dept,#stat')
	}
	lock('#carix')
	$('#cari').css('opacity','.5');
	$('span#td').html(format_number($('#totdata').val(),0));
	$('#dept').change(function(){
		//ajax_start();
		_show_data();
	})
	$('#stat').change(function(){
		$('#dept').change();
	})
	$('#gon').click(function(){
		var id=$('#ordby').val().replace('undefined,','');
		$('#dept').change();
	})
	$('#carix').keypress(function(e){
		if(e.keyCode==13){
			$('#cari').click();
		}
	})
	$('#cari').click(function(){
		if($('#carix').val().length>0)	$('#dept').change();
	})
/*	$('#urutan')
		.fcbkcomplete({
		cache: true,
		newel: true,
		firstselected:true,
		filter_case: false,
		filter_hide: false,
		select_all_text: "select"
		
	})
	$("#urutan").trigger("addItem",[{"title": "No Anggota", "value": "no_Agt"}]);	
*/	//$('#ListTable').fixedHeader({width:(screen.width-50),height:(screen.height-320)})
})
function images_click(id,aksi){
	show_member_detail(id);	
}
function show_member_detail(id){
	ajax_start();
	$.post('member_detail',{'no_anggota':id},
	function(result){
		$('#mm_lock').show();	
		$('#mm_detail')
			.html(result)
			.show()
		$('#mm_detail #tab tr td#membertrans').removeClass('tab_button');
		$('#mm_detail #tab tr td#membertrans').addClass('tab_select');
		ajax_stop();
	})
}

function _show_data(){
	show_indicator('ListTable',8);
		$.post('filter_by',{
			'id_dept':$('#dept').val(),
			'ordby':$('#urutan').val(),
			'stat':$('#stat').val(),'searchby':$('#carix').val()},
			function(result){
				$('#v_daftaranggota table#ListTable tbody').html('');	
				$('#v_daftaranggota table#ListTable tbody').html(result);
				$('span#td').html(format_number($('#v_daftaranggota table#ListTable tbody tr').length));
				$('#v_daftaranggota table#ListTable').fixedHeader({width:(screen.width-50),height:(screen.height-350)})
				//ajax_stop();
				unlock('#carix');
			$('#cari').css('opacity','1');
				$('#carix').focus().select();
			})
	
}
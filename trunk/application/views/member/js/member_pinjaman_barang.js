// JavaScript Document
$(document).ready(function(e) {
	var path=$('#path').val();
	var prs=$('#prs').val();
		$('#pinjamanbarang').removeClass('tab_button');
		$('#pinjamanbarang').addClass('tab_select');
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
	
	$('#okelah').click(function(){
		_show_data();
	})
	
	$('#departement').change(function(){
		_show_data()
	})
	$('#Status').change(function(){
		_show_data()
	})
	$('#cariya').click(function(){
		_show_data();
	})

})

function _show_data(){
	show_indicator('ListTable',5)
	$.post('get_kreditur',{
		'id_dept'	:$('#departement').val(),
		'id_stat'	:$('#status').val(),
		'cari'		:$('#carilah').val()
	},function(result){
		$('table#ListTable tbody').html(result)
		$('table#ListTable').fixedHeader({width:(screen.width-30),height:(screen.height-330)})
	})
}

function detail(id,agt){
	$('table#lod').show();
	show_indicator('lod',1);
	$.post('detail_kreditur',{
		'ID'	:id,
		'ID_Agt':agt
	},function(result){
	$('#mm_detail')
		.css({'top':'7%'})
		.html(result)
		.show()
	$('table#lod').hide();
	})
}
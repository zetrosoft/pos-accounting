// JavaScript Document
$(document).ready(function(e) {
    var path=$('#path').val();
    $('#liststock').removeClass('tab_button');
	$('#liststock').addClass('tab_select');
	$('table#panel tr td').click(function(){
		var id=$(this).attr('id');
			if(id!=''){
				$('#'+id).removeClass('tab_button');
				$('#'+id).addClass('tab_select');
				$('table#panel tr td:not(#'+id+',.flt)').removeClass('tab_select');
				$('table#panel tr td:not(#'+id+',#kosong,.flt)').addClass('tab_button');
				$('span#v_'+id).show();
				$('span:not(#v_'+id+')').hide();
			}
	})
	var c=$('#dari_tgl').val();
	if(c==''){lock(':button,#carilah')} else {unlock(':button,#carilah')};
	$('#dari_tgl').dynDateTime();
	$('#sampai_tgl').dynDateTime();
	$('#okelah').click(function(){
		_show_data();
	})
	$('#dari_tgl').click(function(){
		unlock(':button,#carilah');
	})
	$('#prt').click(function(){
	var f=$('#filter').val();
	if(f=='ID'){
		$('#frm1').attr('action','get_stock_his_print');
	}else{
		$('#frm1').attr('action','get_pemasok_his_print');
	}
		document.frm1.submit();
	})
	var cb=$('#c_by').val()
	$('#c_by').change(function(){
		if($(this).val()=='barang'){
			$('#carideh').css('display','none')
			$('#carilah').css('display','')
		}else{
			$('#carilah').css('display','none');
			$('#carideh').css('display','block')
		}
	})
	
	$('#carideh')
		.coolautosuggest({
			url		: path+'pembelian/get_pemasok?limit=10&str=',
			width	:350,
			showDescription	:true,
			onSelected		:function(result){
				$('#id_pemasok').val(result.id_pemasok);
				$('#filter').val('ID_Pemasok').select();
				unlock(':button')
			}
		})
		.focusout(function(){
		})
		.keypress(function(e){
			if(e.which==13){
				$(this).focusout();
			}
		})
		.focus(function(){
			$(this).select();
		})
	$('#carilah')
		.coolautosuggest({
			url		: path+'inventory/data_material?fld=Nama_Barang&limit=8&str=',
			width	:350,
			showDescription	:true,
			onSelected		:function(result){
				$('#id_barang').val(result.id_barang);
				$('#filter').val('ID').select();
				unlock(':button')
			}
		})
		.focusout(function(){
		})
		.keypress(function(e){
			if(e.which==13){
				$(this).focusout();
			}
		})
		.focus(function(){
			$(this).select();
		})
	$('#Kategori').change(function(){
		$('#carilah').val('');
		$('#id_pemasok').val('')
		$('#id_barang').val('')
	})
})


function _show_data(){
	show_indicator('stoked',8);
	var f=$('#filter').val();
	if(f=='ID'){
		$.post('get_stock_his',{
			'dari_tgl'	:$('#dari_tgl').val(),
			'sampai_tgl':$('#sampai_tgl').val(),
			'filter'	:$('#filter').val(),
			'kategori'	:$('#Kategori').val(),
			'id_barang'	:$('#id_barang').val()
		},function(result){
			$('table#stoked tbody').html(result)
			//$('table#stoked').fixedHeader({width:(screen.width-50),height:(screen.height-350)})
		})
	}else{
		$.post('get_pemasok_his',{
			'dari_tgl'	:$('#dari_tgl').val(),
			'sampai_tgl':$('#sampai_tgl').val(),
			'filter'	:$('#filter').val(),
			'kategori'	:$('#Kategori').val(),
			'pemasok'	:$('#id_pemasok').val()
		},function(result){
			$('table#stoked tbody').html(result)
			//$('table#stoked').fixedHeader({width:(screen.width-50),height:(screen.height-350)})
		})
	}
}
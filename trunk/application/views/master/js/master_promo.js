$(document).ready(function(e) {
	var path=$('#path').val();
    $('#informasipromo').removeClass('tab_button');
	$('#informasipromo').addClass('tab_select');
	$('table#panel tr td').click(function(){
		var id=$(this).attr('id');
			$('#'+id).removeClass('tab_button');
			$('#'+id).addClass('tab_select');
			$('table#panel tr td:not(#'+id+')').removeClass('tab_select');
			$('table#panel tr td:not(#'+id+',#kosong)').addClass('tab_button');
			$('span#v_'+id).show();
			$('span:not(#v_'+id+')').hide();
	})
	$('#p_judul').focus().select();
	tglNow('#p_dari')
	$('#p_dari').dynDateTime();
	$('#p_sampai').dynDateTime();
	_show_data();
	$('#saved-vendor').click(function(){
		_simpan_data();
	})
	$('#saved-promo').click(function(){
		_update_data();
	})
	$('#p_keterangan')
		.keyup(function(e){
			var a=$(this).val()
			$('#fmrTable tr#4 td#c34')
				.html(a.length)
				.attr('valign','top');
		   if(Math.floor((a.length/37))==1){
			$(this).val(a+'\n');
		   }
		})
		.attr('cols','40')
	$('#frm2 :reset').click(function(){
		keluar_v_detail();
	})
})

function _show_data(){
	show_indicator('ListTable',6);
	$.post('list_promo',{
		'nama'	:$('#finde').val()
	},function(result){
		$('table#ListTable tbody').html(result);
		$('table#ListTable').fixedHeader({width:(screen.width-130),height:(screen.height-500)})
	})
}
function images_click(id,aksi){
	switch(aksi){
		case 'edit':
		_show_detail(id);
		break;
		case 'del':
		if(confirm('Yakin data ini akan di hapus?')){
			$.post('hapus_promo',{'id':id},
			function(result){
				_show_data();
			})
		}
	}
}
function _simpan_data(){
	show_indicator('xx',1);
	$.post('set_promo',{
		'judul'			:$('#p_judul').val(),
		'dari'			:$('#p_dari').val(),
		'sampai'		:$('#p_sampai').val(),
		'keterangan'	:$('#p_keterangan').val()
	},function(result){
		$(':reset').click();
		_show_data();
	})
}

function _show_detail(id){
	$('#pp-v_detail').css({'left':'15%','top':'10%'})
	$('#pp-v_detail').show();
	$.post('edit_promo',{'id':id},
	function(result){
		var hsl=$.parseJSON(result)
		$('#frm2 #p_judul').val(hsl.Judul);
		$('#frm2 #p_dari').val(tglFromSql(hsl.Dari_tgl))
		$('#frm2 #p_sampai').val(tglFromSql(hsl.Sampai_tgl))
		$('#frm2 #p_keterangan').val(hsl.Keterangan)
		$('#frm2 #p_id').val(hsl.ID);
	})
}

function _update_data(){
	$.post('set_promo',{
		'judul'			:$('#frm2 #p_judul').val(),
		'dari'			:$('#frm2 #p_dari').val(),
		'sampai'		:$('#frm2 #p_sampai').val(),
		'keterangan'	:$('#frm2 #p_keterangan').val(),
		'id'			:$('#frm2 #p_id').val()
	},function(result){
		$(':reset').click();
		_show_data();
	})
	
}
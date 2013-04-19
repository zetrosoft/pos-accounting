// JavaScript Document
$(document).ready(function(e) {
    var path=$('#path').val();
    $('#liststock').removeClass('tab_button');
	$('#liststock').addClass('tab_select');
    $('#persediaan').removeClass('tab_button');
	$('#persediaan').addClass('tab_select');
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
	$('table#stoked').hide()
	$('#dari_tgl').dynDateTime();
	
	$('#okelah').click(function(){
	$('table#stoked').show()
		_show_data();
	})
	$('#saved-edit_mat').click(function(){
		$.post('update_adjust',{
			'id'	:$('#id_barang').val(),
			'batch'	:$('#batch').val(),
			'stock'	:$('#stock').val(),
			'harga'	:$('#Harga_Beli').val()
		},function(result){
			_show_data();
			$('#batal').click();
			keluar_stocklist();	
		})
	})
	$('#frm1 #prt').click(function(){
		$('#frm1').attr('action','print_stock');
		document.frm1.submit();
	})
	$('#okelah').click()
})

function _show_data(){
	show_indicator('stoked',9);
	$.post('get_stock',{
		'kategori'	:$('#Kategori').val(),
		'stat'		:$('#Stat').val()},
	function(result){
		$('table#stoked tbody').html(result).show();
		$('table#stoked').fixedHeader({width:(screen.width-30),height:(screen.height-335)})
	})
}

function images_click(id,action){
	$('#pp-stocklist').css({'left':'20%','top':'20%'});
	lock('#frm2 :not(#stock,:button,:reset)')
	$.post('edit_stock',{'ID':id},
	function(result){
		var hsl=$.parseJSON(result);
		$('#ID_Kategori').val(hsl.Kategori);
		$('#Nama_Barang').val(hsl.Nama_Barang);
		$('#Kode').val(hsl.Kode);
		$('#stock').val(hsl.stock);
		$('#Harga_Beli').val(hsl.harga_beli);
		$('#Satuan').val(hsl.Satuan);
		$('#Status').val(hsl.Status);
		$('#stock').focus().select();
		$('#batch').val(hsl.batch);
		$('#id_barang').val(hsl.ID);
		if($('#Harga_Beli').val()==''){
			unlock('#Harga_Beli');
			$('#Harga_Beli').val('0');
		}
	})
	$('#lock').show();
	$('#pp-stocklist').show('slow');
	
}
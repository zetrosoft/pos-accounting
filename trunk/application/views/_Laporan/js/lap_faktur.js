// JavaScript Document
$(document).ready(function(e) {
	var prs=$('#prs').val();
	$('table#panel tr td.flt').hide()
    $('#printfakturpenjualan').removeClass('tab_button');
	$('#printfakturpenjualan').addClass('tab_select');
	last_notran();
	$('input:text').focus().select();
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
	});
	$('#saved-faktur').click(function(){
		$('#frm1').attr('action','print_faktur');
		document,frm1.submit();
	})
})

function last_notran(){
	$.post('last_no_transaksi',{'tipe':'GI'},
		function(result){
			$('#no_transaksi').val(result-1);
		})
}
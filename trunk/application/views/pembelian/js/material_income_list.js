// JavaScript Document
//js untuk laporan pembelian

$(document).ready(function(e) {
	tglNow('#dari_tanggal');
	$('#dari_tanggal').dynDateTime();
	$('#smp_tanggal').dynDateTime();
    $('#okelah').click(function(){
		_show_data()
	})
});

function _show_data(){
	show_indicator('newTable',8)
	$.post('laporan_pembelian',{
		'dari_tanggal'	:$('#dari_tanggal').val(),
		'smp_tanggal'	:$('#smp_tanggal').val()
	},function(result){
		$('table#newTable tbody').html(result);
		$('table#newTable').fixedHeader({width:(screen.width-30),height:(screen.height-320)});
	})
		
}
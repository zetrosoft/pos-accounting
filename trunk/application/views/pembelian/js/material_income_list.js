// JavaScript Document
//js untuk laporan pembelian

$(document).ready(function(e) {
	tglNow('#dari_tanggal');
	$('#dari_tanggal').dynDateTime();
	$('#smp_tanggal').dynDateTime();
    $('#okelah').click(function(){
		_show_data()
	})
	$('#print').click(function(){
		
	})
});

function _show_data(){
	show_indicator('newTable',9)
	$.post('laporan_pembelian',{
		'dari_tanggal'	:$('#dari_tanggal').val(),
		'smp_tanggal'	:$('#smp_tanggal').val()
	},function(result){
		$('#print').removeAttr('disabled');
		$('table#newTable tbody').html(result);
		$('table#newTable').fixedHeader({width:(screen.width-30),height:(screen.height-320)});
	})
		
}
function _update_stock(){
}

function images_click(id,aksi){
	switch (aksi){
		case 'del':
			if(confirm('Yakin data transaksi pembelian ini akan di hapus?')){
				$.post('get_detail_trans',{'id':id},
				function(result){
					var hsl=$.parseJSON(result);
					$.post('update_stock',{
						'nm_barang'	:hsl.Nama_Barang,
						'id_satuan'	:hsl.ID_Satuan,
						'jumlah'	:parseInt(hsl.Jumlah),
						'harga_beli':hsl.Harga_Beli,
						'batch'		:hsl.batch,
						'aksi'		:'del'
					},function(rst){
						//alert(result);
						$.post('hapus_transaksi',{'ID':id},
							function(rsl){
								$.post('hapus_header',{
									'ID'		:id,
									'id_beli'	:$.trim(rsl)
									},
								function(data){
									_show_data();
								})
							})
					})
					
				})
			}
		break;
	}
}
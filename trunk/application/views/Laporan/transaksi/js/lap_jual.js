// JavaScript Document
$(document).ready(function(e) {
	var path=$('#path').val();
    $('#rekappenjualantunai').removeClass('tab_button');
	$('#rekappenjualantunai').addClass('tab_select');
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
	//laporan penjualan obat
	$('#frm1 #dari_tgl').dynDateTime();
	$('#frm1 #sampai_tgl').dynDateTime();
	$('#frm1 #dari_tgl')
		.click(function(){
			$(this).focus().select();
		})
		.keyup(function(){
			tanggal(this)
		})
		.keypress(function(e){
			if(e.keyCode==13){
				$('#frm1 #sampai_tgl').focus().select();
			}
		})
	$('#frm1 #sampai_tgl')
		.click(function(){
			$(this).focus().select();
			tglNow('#frm1 #sampai_tgl');
		})
		.keyup(function(){
			tanggal(this)
		})
		.keypress(function(e){
			if(e.keyCode==13){
				$('#frm1 #nm_produsen').focus().select();
			}
		})
	$('#frm1 #nm_dokter')
		.coolautosuggest({
				url		:path+'member/get_anggota?limit=15&str=',
				width	:350,
				showDescription	:true,
				onSelected		:function(result){
					$('#ID_Anggota').val(result.ID);
				}
		})
	//laporan penjualan resep
	$('#frm2 #jtran').val("GI' or jenis_transaksi='GIR'");
	$('#frm2 #optional').val(" and left(dt.faktur_transaksi,5)='RESEP' order by dt.tgl_transaksi");
	$('#frm2 #dari_tgl')
		.click(function(){
			$(this).focus().select();
		})
		.keyup(function(){
			tanggal(this)
		})
		.keypress(function(e){
			if(e.keyCode==13){
				$('#frm2 #sampai_tgl').focus().select();
			}
		})
	$('#frm2 #sampai_tgl')
		.click(function(){
			$(this).focus().select();
			tglNow('#frm2 #sampai_tgl');
		})
		.keyup(function(){
			tanggal(this)
		})
		.keypress(function(e){
			if(e.keyCode==13){
				$('#frm2 #nm_produsen').focus().select();
			}
		})
	$('#frm2 #nm_dokter')
		.keyup(function(){
			var path=$('#path').val();
			pos_div('#frm2 input#nm_dokter');
			auto_suggest(path+'penjualan/get_dokter',$(this).val(),$(this).attr('id')+'-frm2');
		})
		.keypress(function(e){
			if(e.which==13){
				//$('.autosuggest').hide();
			}
		})
	//lap top penjualan
	$('#frm3 #jtran').val("GI' or jenis_transaksi='GIR'");
	$('#frm3 #optional').val(" order by (abs(harga_beli)*jml_transaksi) desc limit 20");
	$('#frm3 #dari_tgl')
		.click(function(){
			$(this).focus().select();
		})
		.keyup(function(){
			tanggal(this)
		})
		.keypress(function(e){
			if(e.keyCode==13){
				$('#frm3 #sampai_tgl').focus().select();
			}
		})
	$('#frm3 #sampai_tgl')
		.click(function(){
			$(this).focus().select();
			tglNow('#frm3 #sampai_tgl');
		})
		.keyup(function(){
			tanggal(this)
		})
		.keypress(function(e){
			if(e.keyCode==13){
				$('#frm3 #nm_produsen').focus().select();
			}
		})
	$('#okelah').click(function(){
		$('#frm1').attr('action','lap_penjualan');
		document.frm1.submit();
	})

	$(':button')
		.click(function(){
			var id=$(this).attr('id');
			switch(id){
				case 'saved-filter':
					$('#printsheet').click();
				break;
				case 'saved-resep':
					$('#frm2').attr('action','print_laporan');
					document.frm2.submit();
				break;
				case 'saved-topjual':
					$('#frm3').attr('action','print_laporan');
					document.frm3.submit();
				break;
			}
		})
	$('img').click(function(){
		//alert($(this).attr('id'))
	})
})


function on_clicked(id,fld,frm){
				/*
				var dari_tgl	=$('#frm1 #dari_tgl').val();
				var sampai_tgl	=$('#frm1 #sampai_tgl').val();	
				var nm_golongan	=$('#frm1 #nm_golongan').val();	
				var nm_produsen	=$('#frm1 #nm_produsen').val();
					$.post('list_filtered',{
						'jtran'			:'GR\' or jenis_transaksi=\'GRR\'',
						'dari_tgl'		:dari_tgl,
						'sampai_tgl'	:sampai_tgl,
						'nm_golongan'	:nm_golongan,
						'nm_produsen'	:nm_produsen,
						'section'		:'lapbelilist'
					},function(result){
						$('#v_tranpembelian table#ListTable tbody').html(result);	
						$('#v_tranpembelian table#ListTable').show();
						$('#v_tranpembelian table#ListTable').fixedHeader({'width':900,'height':300});

					})*/
	
}
// JavaScript Document
// material_inv.js
// author : Iswan Putera

$(document).ready(function(e) {
	var prs=$('#prs').val();
		$('#kategoribarang').removeClass('tab_button');
		$('#kategoribarang').addClass('tab_select');
		$('span#v_jenisobat').show();

	$('table#panel tr td').click(function(){
		var id=$(this).attr('id');
				$('#'+id).removeClass('tab_button');
				$('#'+id).addClass('tab_select');
				$('table#panel tr td:not(#'+id+',.flt,.plt)').removeClass('tab_select');
				$('table#panel tr td:not(#'+id+',#kosong,.flt,.plt)').addClass('tab_button');
				$('span#v_'+id).show();
				$('span:not(#v_'+id+')').hide();
				$('#prs').val(id);
	})
	
	$(':button').click(function(){
		var id=$(this).attr('id');
		var idr=id.split('-');
		var pos=$(this).offset();
		var l=pos.left+5;
		var t=pos.top+24;
		var induk=$(this).parent().parent().parent().parent().parent().attr('id');
		switch(id){
				case 'saved-jenis':
				$.post('simpan_jenis',{'nm_jenis':$('#frm1 input#JenisBarang').val(),'induk':'frm1'},
				function(result){
					$('#v_jenisbarang table#ListTable tbody').html(result);
					$('#frm1 input#JenisBarang').val('')
				})
			break;
			case 'saved-kat':
				$.post('simpan_kategori',{'nm_kategori':$('#frm2 input#Kategori').val(),'induk':'frm2'},
				function(result){
					$('#v_kategoribarang table#ListTable tbody').html(result);
					$('#frm2 input#Kategori').val('')
				})
			break;
			case 'saved-subkat':
				$.post('simpan_golongan',{'nm_golongan':$('#frm3 input#nm_golongan').val(),'induk':'frm3'},
				function(result){
					$('#v_subkategori table#ListTable tbody').html(result);
					$('#frm3 input#nm_golongan').val('')
				})
			break;
		}
	})

});

function image_click(id,cl){
		var id=id.split('-');
		var cl=cl;
		var induk=id[0]
		switch(cl){
			case 'del':
			switch(id[0]){
				case 'Jenis':
					if (confirm('Yakin data '+id[1]+'  akan di hapus?')){
						$.post('hapus_inv',{'tbl':'inv_barang_jenis','id':id[1],'fld':'JenisBarang'},
						function(result){
							$('#v_jenisbarang table#ListTable tbody tr#nm-'+id[1]).remove();
						})
					}
				break;
				case 'Kategori':
					if (confirm('Yakin data '+id[1]+'  akan di hapus?')){
						$.post('hapus_inv',{'tbl':'inv_barang_kategori','id':id[1],'fld':'Kategori'},
						function(result){
							$('#v_kategoribarang table#ListTable tbody tr#nm-'+id[1]).remove();
						})
					}
				break;
				case 'Golongan':
					if (confirm('Yakin data '+id[1]+'  akan di hapus?')){
						$.post('hapus_inv',{'tbl':'inv_golongan','id':id[1],'fld':'nm_golongan'},
						function(result){
							$('#v_golongan table#ListTable tbody tr#nm-'+id[1]).remove();
						})
					}
				break;
			}
		}
	}
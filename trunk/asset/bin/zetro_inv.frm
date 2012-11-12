[Kategori]
1|Karegori,input,text n,Kategori,w70 upper,,70%

[Jenis]
1|Jenis,input,text n,JenisBarang,w70 upper,,70%

[Golongan]
1|Sub Kategori,input,text n,nm_golongan,w70 upper,,70%

[Barang]
1|Kategori,input,text n,nm_kategori,w70 upper,,10%
2|Jenis Barang,input,text n,nm_jenis,w50 upper,,10%
3|Kode Barang,input,text n,id_barang,w70 upper,,10%,
4|Nama Barang,input,text n,nm_barang,w90 upper,,20%,
5|Satuan Jual,input,text n,nm_satuan,S35 upper,,5%,
;6|Expire Date,input, date t,expired,w35,,8%
6|Harga Beli,input,text d,stokmin,w35 angka,0,7%,
7|Harga Jual,input,text d,stokmax,w35 angka,0,7%,
8|Minimum Stock,input,text d,stoklimit,w25 angka,,5%,
9|,input,hidden n,status_barang,w35 upper,Continue,,

[BarangList]
1|Kategori,input,text n,nm_kategori,w70 upper,,10%,,,20
2|Jenis Barang,input,text n,nm_jenis,w50 upper,,10%,,,20
3|Kode Barang,input,text n,id_barang,w70 upper,,8%,
4|Nama Barang,input,text n,nm_barang,w90 upper,,20%,,,60
5|Satuan Jual,input,text n,nm_satuan,S35 upper,,5%,,,15
6|Total Stock,input,text n,expired,w35,,10%,,15
7|Harga Beli,input,text d,stokmin,w35 angka,0,7%,,,10
8|Harga Jual,input,text d,stokmax,w35 angka,0,7%,,,10
9|Minimum Stock,input,text d,stoklimit,w25 angka,,5%,,,10

[Harga Beli]
1|Nama Barang,input,text n,nm_barang,w90 upper,,20%
2|Produsen,input,text n,nm_produsen,w90 upper,,25%
3|Harga Beli,input,text d,hg_beli,w35 angka,,10%
4|Satuan Beli,select,text n,sat_beli,S35,,5%,,,

[Satuan]
1|Nama Satuan,input,text n,Satuan,w70 upper,,70%

[Konversi]
1|Nama Barang,input,text n,nm_barang,w90 upper,,20%
2|Satuan Jual,select,text n,nm_satuan,S35,,5%,RD,inv_barang_satuan-ID-Satuan-order by Satuan,AB
3|Satuan Beli (Satu Satuan),select,text n,sat_beli,S35,,5%,RD,inv_barang_satuan-ID-Satuan-order by Satuan,
4|Isi per Satuan Jual,input,text d,isi_konversi,w35 angka,,10%

[stokoverview]
1|Nama Barang,input,text n,nm_barang,w90 upper,,20%
2|Status,input,text n,status,w50,,10%,
3|Kategori ,input,text n,nm_kategori,w70,,10%
;4|Sub Kategori,input,text n,nm_golongan,w70,,10%,

[stokoverlist]
1|Batch,input,text n,batch,w35,,12%
2|Stock,input,text d,stock,w35,,10%
3|Block Stock,input,text d,blokstok,w35,,10%
4|Satuan,input,text n,nm_satuan,w35,,5%
5|Expired,input,text t,expired,w35,,8%

[stoklist filter]
1|Jenis Barang,select,text n,nm_jenis,S50,,10%,RD,inv_barang_jenis-ID-JenisBarang-order by JenisBarang
2|Kategori ,select,text n,nm_kategori,S70,,10%,RD,inv_barang_kategori-ID-Kategori-order by Kategori
;3|Sub Kategori,select,text n,nm_golongan,S50,,10%,RD,inv_golongan-nm_golongan-nm_golongan-

[stoklistview]
1|Kode Barang,input,text n,kode,w70,,10%
2|Nama Barang,input,text n,nm_barang,w90 upper,,25%
3|Satuan,input,text n,nm_satuan,w70 upper,,10%
4|Jumlah,input,text dn,stock,w70 angka,,10%
5|Status,input,text d,blokstok,,,10%

[stokopname]
1|Nama Barang,input,text n,nama_barang,w90 upper,,25%,,,80
2|Satuan,input,text n,Satuan,w70 upper,,10%,,,20
3|Count I,input,text d,count1,,,10%,,,30
4|Count II,input,text d,count2,,,10%,,,30

;array(10,20,20,25,55,15,20,25)
[liststock_rpt]
1|Jenis,select,text n,nm_jenis,S50,,10%,,,20
2|Kategori,select,text n,nm_kategori,S70,,10%,,,20
3|Kode Barang,select,text n,id_barang,w50,,10%,,,25
4|Nama Barang,input,text n,nm_barang,w90 upper,,20%,,,55
5|Stock OH,input,text d,stock,w35 angka,,10%,,,20
6|Satuan,select,text n,nm_satuan,S35,,5%,,,15
7|Value,input,text d,harga_beli,w35 angka,,10%,,,25
;8|Keterangan,input,text d,margin_jual,w15 angka,10,8%,,,30

;array(10,20,25,35,75,20,18,22,30)
[liststock_expr]
1|Jenis,select,text n,nm_jenis,S50,,10%,,,20
2|Kategori,select,text n,nm_kategori,S70,,10%,,,25
3|Kode Barang,select,text n,id_barang,w50,,10%,,,25
4|Nama Barang,input,text n,nm_barang,w90 upper,,20%,,,75
5|Stock OH,input,text d,stock,w35 angka,,10%,,,20
6|Satuan,select,text n,nm_satuan,S35,,5%,,,18
7|Expired,input,text d,expired,w15 angka,10,8%,,,22
8|Value,input,text d,harga_beli,w35 angka,,10%,,,30

[lapkas]
1|Tanggal Transaksi,,,,,
2|&nbsp;&nbsp;&nbsp;Dari Tanggal,input,text t,dari_tgl,w35,,
3|&nbsp;&nbsp;&nbsp;Sampai Tanggal,input,text t,sampai_tgl,w35,,

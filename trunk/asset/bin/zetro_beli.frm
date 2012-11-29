[Carabeli]
1|Cash,Cash
2|Cek/Giro,Cek/Giro
3|Transfer,Transfer

[pembelian]
1|No. ID,input,text n,no_transaksi,w50 upper,,10%
2|Tanggal,input,date t,tgl_transaksi,w35,,8%
3|No.Faktur Pembelian,input,text n,faktur_transaksi,w70 upper,,12%
4|Nama Pemasok,input,text n,nm_produsen,w90 upper,,15%
5|No. PO,input,text n,po_pembelian,w70 upper,,10%
6|Jenis Pembelian,select,text n,cara_bayar,S50,,5%,RD,inv_pembelian_jenis-ID-Jenis_Beli-,

[pembelianlist]
1|Kode Barang,input,text t,id_barang,w100,,15%
2|Nama Barang,input,text n,nm_barang,w100 upper,,30%
3|Satuan,select,text n,nm_satuan,S100 upper,,12%
4|Jumlah,input,text d,jml_transaksi,w100 angka,,12%
5|Harga Beli/Satuan,input,text d,harga_beli,100 angka,,12%
6|Total Harga,input,text n,ket_transaksi,w100 angka,,15%

[lappembelian]
1|No. Transaksi,,,,,,15%,,
2|Tanggal,,,,,,10%,,
;3|Kode Barang,input,text t,id_barang,w100,,15%
3|Nama Barang,input,text n,nm_barang,w100 upper,,25%
4|Satuan,select,text n,nm_satuan,S100 upper,,8%
5|Jumlah,input,text d,jml_transaksi,w100 angka,,8%
6|Harga Beli,input,text d,harga_beli,100 angka,,12%
7|Sub Total,input,text n,ket_transaksi,w100,,12%

[jualan]
1|No. ID,input,text n,no_transaksi,w50 upper,,10%
2|Tanggal,input,date t,tgl_transaksi,w35,,8%
3|No.Faktur,input,text n,faktur_transaksi,w70 upper,,12%
4|Nama Anggota,input,text n,nm_nasabah,w70 upper,,15%,,,
;5|Cara Bayar,select,text n,cara_bayar,S25,,5%,RS,Carabeli

[penjualanlist]
1|Nama Barang,input,text n,nm_barang,w100 upper,,25%
2|Satuan,input,text n,nm_satuan,w100 upper,,8%
3|Jumlah,input,text d,jml_transaksi,w100 angka,,12%
4|Harga,input,text d,harga_jual,w100 angka,,10%
5|Total Harga,input,text d,harga_total,w100 angka subtt,,10%
6|Expired,input,text t,expired,w100,,15%

[penjualanlist2]
1|Nama Barang,input,text n,nm_barang,w100 upper,,25%
2|Satuan,input,text n,nm_satuan,w100 upper,,8%
3|Jumlah,input,text d,jml_transaksi,w100 angka,,12%
4|Harga,input,text d,harga_beli,w100 angka,,10%
5|Total Harga,input,text d,ket_transaksi,w100 angka subtt,,10%
6|Expired,input,text t,expired,w100,,15%

[bayaran]
1|Sub Total ,input,text d,total_belanja,w90 angka big,,
2|PPN (10%),input,text d,ppn,w90 angka big,0,
3|Total Bayar,input,text d,total_bayar,w90 angka big,,
4|Di Bayar,input,text d,dibayar,w90 angka big,,
5|Kembali,input,text d,kembalian,w90 angka big,,

[kredite]
1|Sub Total ,input,text d,total_belanja,w90 angka big,,
2|PPN (10%),input,text d,ppn,w90 angka big,0,
3|Total Bayar,input,text d,total_bayar,w90 angka big,,
4|Uang Muka,input,text d,dibayar,w90 angka big,0,
5|Sisa,input,text d,kembalian,w90 angka big,,
6|Jumlah Cicilan,input,text d,cicilan,w50 angka big,1,

[resep]
1|No. Transaksi,input,text n,no_transaksi,w50,,
2|No. Resep,input,text n,no_resep,w50 upper,,
3|Tanggal Resep,input,text t,tgl_resep,w35,,
4|Nama Dokter,input,text n,nm_dokter,w70 upper,,
5|Nama Pasien,input,text n,nm_nasabah,w70 upper,,


[return]
1|,input,hidden n,no_transaksi,w50 upper,,10%
2|Doc.No.,input,text n,no_doc,w50 upper,,10%
3|Tanggal,input,date t,tgl_transaksi,w35,,8%
4|No.Faktur,input,text n,faktur_transaksi,w70 upper,,12%
5|Nama Nasabah,input,text n,nm_nasabah,w70 upper,,15%,,,
6|Nama Obat,input,text n,nm_barang,w90 upper,,25%
7|Satuan,input,text n,nm_satuan,w35 upper,,8%
8|Jumlah,input,text d,jml_transaksi,w35 angka,,12%
9|Harga,input,text d,harga_beli,w35 angka,,10%
10|Total Harga,input,text d,total_harga,w35 angka subtt,,10%
11|Expired,input,text t,expired,w35,,15%

[return_beli]
1|,input,hidden n,no_transaksi,w50 upper,,10%
2|Doc.No.,input,text n,no_doc,w50 upper,,10%
3|Tanggal,input,date t,tgl_transaksi,w35,,8%
4|No.Faktur,input,text n,faktur_transaksi,w70 upper,,12%
5|Nama Vendor,input,text n,nm_nasabah,w70 upper,,15%,,,
6|Nama Barang,input,text n,nm_barang,w90 upper,,25%
7|Satuan,input,text n,nm_satuan,w35 upper,,8%
8|Jumlah,input,text d,jml_transaksi,w35 angka,,12%
9|Harga Beli,input,text d,harga_beli,w35 angka,,10%
;10|Total Harga,input,text d,total_harga,w35 angka subtt,,10%
10|Expired,input,text t,expired,w35,,15%

[lapbeli]
1|Tanggal Pembelian,,,,,
2|&nbsp;&nbsp;&nbsp;Dari Tanggal,input,text t,dari_tgl,w35,,
3|&nbsp;&nbsp;&nbsp;Sampai Tanggal,input,text t,sampai_tgl,w35,,
4|Golongan Obat,select,text n,nm_golongan,S70,,,RD,inv_golongan-nm_golongan-nm_golongan-
5|Nama Vendor,input,text n,nm_produsen,w90 upper,,

;array(10,22,70,15,25,25,30,40,40)
[lapbelilist]
1|Tanggal,input,text t,tgl_transaksi,w35,,10%,,,22
2|Nama Barang,input,text n,nm_barang,w100 upper,,25%,,,70
3|Satuan,input,text n,nm_satuan,w100 upper,,10%,,,15
4|Jumlah,input,text d,jml_transaksi,w100 angka,,12%,,,25
5|Expired,input,text t,expired,w100,,15%,,,25
6|Harga Beli,input,text d,harga_beli,100 angka,,12%,,,30
7|Vendor,input,text n,nm_produsen,w100,,20%,,,40
8|Keterangan,input,text n,faktur_transaksi,,,20%,,,40

[lapjual]
1|Tanggal Penjualan,,,,,
2|&nbsp;&nbsp;&nbsp;Dari Tanggal,input,text t,dari_tgl,w35,,
3|&nbsp;&nbsp;&nbsp;Sampai Tanggal,input,text t,sampai_tgl,w35,,
4|Jenis Barang,select,text n,nm_jenis,S70,,,RD,inv_jenis-nm_jenis-nm_jenis-
5|Nama Dokter,input,text n,nm_dokter,w90 upper,,

;array(10,22,70,15,25,25,30,40,40)
[lapjuallist]
1|Tanggal,input,text t,tgl_transaksi,w35,,10%,,,22
2|Nama Barang,input,text n,nm_barang,w100 upper,,25%,,,65
3|Satuan,input,text n,nm_satuan,w100 upper,,10%,,,15
4|Jumlah,input,text d,jml_transaksi,w100 angka,,12%,,,25
5|Expired,input,text t,expired,w100,,15%,,,25
6|Harga Jual,input,text d,harga_beli,100 angka,,12%,,,30
7|Consumen,input,text n,nm_produsen,w100,,20%,,,40
8|Keterangan,input,text n,faktur_transaksi,,,20%,,,45

[lapjualresep]
1|Tanggal Penjualan,,,,,
2|&nbsp;&nbsp;&nbsp;Dari Tanggal,input,text t,dari_tgl,w35,,
3|&nbsp;&nbsp;&nbsp;Sampai Tanggal,input,text t,sampai_tgl,w35,,
;4|Jenis Barang,select,text n,nm_jenis,S70,,,RD,inv_jenis-nm_jenis-nm_jenis-
;4|Nama Dokter,input,text n,nm_dokter,w90 upper,,

[lapjualtop]
1|Tanggal Penjualan,,,,,
2|&nbsp;&nbsp;&nbsp;Dari Tanggal,input,text t,dari_tgl,w35,,
3|&nbsp;&nbsp;&nbsp;Sampai Tanggal,input,text t,sampai_tgl,w35,,
4|Jenis Barang,select,text n,nm_jenis,S70,,,RD,inv_jenis-nm_jenis-nm_jenis-


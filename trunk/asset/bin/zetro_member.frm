[registrasi]
1|No. Anggota,input,text n,No_Agt,w35 upper,,
2|Departement,select,text n,ID_Dept,S70,,10%,RD,mst_departemen-ID-Departemen-,AB
3|NIP/NIK,input,text n,NIP,w50,,
4|Nama Lengkap,input,text n,Nama,w90 ,,
5|Jenis Kelamin,select,text n,ID_Kelamin,s50,,5%,RS,Sex
6|Alamat,textarea,text n,Alamat,t90,,
7|Kota,input,text n,Kota,w70,,
8|Propinsi,input,text n,Propinsi,w50,,
9|Telepon,input,text n,Telepon,w50,,
10|Fax,input,text n,Faksimili,w50,,
11|Status Anggota,select,text n,ID_Aktif,w50,,,RD,keaktifan-ID-Keaktifan-,

[biodata]
1|Tanggal Masuk,input,text t,TanggalMasuk,w35,,
2|Tanggal Keluar,input,text t,TanggalKeluar,w35,,

[Sex]
1|1,Laki-Laki
2|2,Perempuan

[upload]
1|Nama Lengkap,input,text n,Nama,w90 upper,,
2|NIP,input,text n,NIP,w35 upper,,
3|Photo,input,file n,PhotoLink,w90,,
4|,input,hidden n,no_agt,,,

[kota]
1|Nama Kota,input,text n,Kota,w70 upper,,

[propinsi]
1|Nama Propinsi, input,text n,Propinsi,w70 upper,,

[listanggota]
1|No. Anggota,input,text n,no_anggota,w35 upper,,8%,
2|Departement,select,text n,id_department,S70,,10%,
3|NIP/NIK,input,text n,nip_anggota,w50,,10%,
4|Nama Lengkap,input,text n,nm_anggota,w90 upper,,35%,
5|Jenis Kelamin,select,text n,sex_anggota,s50,,10%,
6|Status Anggota,input,text n,status_anggota,w50,,10%,

[detail]
1|Kode,,,,,,10%,
2|Jenis,,,,,,20%,
3|Saldo Awal,,,,,,10%,
4|Debet,,,,,,10%,
5|Kredit,,,,,,10%,
6|Saldo Akhir,,,,,,15%,

[DetailTrans]
1|Tanggal,,,,,,10%,
2|No. Jurnal,,,,,,10%,
3|Keterangan,,,,,,40%,
4|Debet,,,,,,12%,
5|Kredit,,,,,,12%,

[CaraBayar]
1|Tunai,Tunai
2|Transfer,Transfer Bank
3|Potong,Potong Gaji

[simpanan]
1|Bulan,select,text n,ID_Bulan,S50,,
2|Tipe Transaksi,select,text n,ID_Jenis,S35,,,RD,tipe_transaksi-ID-Tipe-
3|Unit,select,text n,ID_Unit,S35,,,RD,unit_jurnal-ID-unit-
4|Jenis Simpanan,select,text n,ID_Simpanan,S50,,,RD,jenis_simpanan-ID-Jenis-where ID_Klasifikasi='3'
5|Cara Bayar,select,text n,cbayar,S35,,,RS,CaraBayar
6|Departemen,select,text n,ID_Dept,S90,,,RD,mst_departemen-ID-Kode+Departemen-order by Kode
;7|Jurnal Otomatis,input,checkbox n,Auto_J,,,

[potonggaji]
1|Kode,,,,,,20%,
2|Nama Anggota,,,,,,50%, 
3|Jumlah,,,,,,20%,

[balance]
1|Bulan,select,text n,ID_Bulan,S50,,
2|Tipe Transaksi,select,text n,ID_Jenis,S35,,,RD,tipe_transaksi-ID-Tipe-
3|Unit,select,text n,ID_Unit,S35,,,RD,unit_jurnal-ID-unit-
4|Perkiraan,select,text n,ID_Perkiraan,S90,,,
5|Jumlah,input,text n,jumlah,w35 angka,,,

[pinjaman]
1|Bulan,select,text n,ID_Bulan,S50,,
2|Tipe Transaksi,select,text n,ID_Jenis,S35,,,RD,tipe_transaksi-ID-Tipe-
3|Unit,select,text n,ID_Unit,S35,,,RD,unit_jurnal-ID-unit-
4|Jenis Pinjaman,select,text n,ID_Simpanan,S50,,,RD,jenis_simpanan-ID-Jenis-where ID_Klasifikasi ='1'
5|Departemen,select,text n,ID_Dept,S90,,,RD,mst_departemen-ID-Kode+Departemen-order by Kode
6|Nama Anggota,input,text n,ID_Agt,w90 cari,,
7|Total Pinjaman,input,text n,pinjaman,w35 angka,,
8|Lama Angsuran,input,text n,lama_cicilan,w15 angka,,
9|Jumlah Cicilan,input, text n,cicilan,w35 angka,,
10|Jumlah Cicilan terakhir ,input, text n,end_cicilan,w35 angka,,
11|Cara Bayar,select,text n,cbayar,S35,,,RS,CaraBayar
12|Mulai bayar bulan,select,text n,mulai_bayar,S50,,
13|Keterangan Pinjamaan,textarea,text n,keterangan,t90,,

[setoranpinjaman]
1|Bulan,select,text n,ID_Bulan,S50,,
2|Tipe Transaksi,select,text n,ID_Jenis,S35,,,RD,tipe_transaksi-ID-Tipe-
3|Unit,select,text n,ID_Unit,S35,,,RD,unit_jurnal-ID-unit-
4|Jenis Pinjaman,select,text n,ID_Simpanan,S50,,,RD,jenis_simpanan-ID-Jenis-where ID_Klasifikasi ='1'
5|Departemen,select,text n,ID_Dept,S90,,,RD,mst_departemen-ID-Kode+Departemen-order by Kode
6|Nama Anggota,input,text n,ID_Agt,w90 cari,,

[listpinjaman]
7|Total Pinjaman,input,text n,pinjaman,w35 angka,,
8|Angsuran Ke,input,text n,angsuran_ke,w15 angka,,
9|Jumlah Setoran,input, text n,jml_setoran,w35 angka,,
10|Keterangan,textarea,text n,keterangan,t90,,

[listtransaksi]
1|Tanggal,,,,,,10%,
2|Kode,,,,,,8%,
3|Perkiraan,,,,,,25%,
4|Debet,,,,,,12%,
5|Kredit,,,,,,12%,
6|Keterangan,,,,,,20%,

[pinjamanbarang]
1|Departemen,,,,,,25%,
2|NIP,,,,,,15%,
3|Nama Anggota,,,,,,50%,
4|Status,,,,,,12%,

[detailkredit]
1|Tanggal,,,,,,10%,
2|Nomor,,,,,,8%,
3|Nama Barang,,,,,,40%,
4|Jumlah,,,,,,12%,
5|Satuan,,,,,,10%,
6|Total,,,,,,12%,

[detailjurnal]
1|Tanggal,,,,,,10%,
2|No. Jurnal,,,,,,12%,
3|Keterangan,,,,,,40%,
4|Debet,,,,,,15%,
5|Kredit,,,,,,15%,

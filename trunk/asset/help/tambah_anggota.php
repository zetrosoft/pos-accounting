<!DOCTYPE HTML>
<html>
<head>
   <title>Sistem Applikasi &gt; Modul Akuntansi &gt; Keanggotaan &gt; Tambah Anggota</title>
   <meta name="generator" content="Help & Manual">
   <meta name="keywords" content="">
   <meta name="description" content="Tambah Anggota">
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <link type="text/css" href="default.css" rel="stylesheet">
   <link type="text/css" href="custom.css" rel="stylesheet">
   <script type="text/javascript" src="nsh.js"></script>

<script type="text/javascript">   
// Toggle Toggler 

var toggleCount=false;
var switchState;

function toggleToggles() {

    if (!toggleCount) {
     toggleCount = true;
     HMToggleExpandAll(true);
     switchState = true;
     }
   
     else if (switchState) {
        HMToggleExpandAll(false);
        switchState = false;
        }
        
     else  {
        HMToggleExpandAll(true);
        switchState = true;
        } 
    }
</script>
   
<!-- non-scrolling headers for CHM and browser-based help, local styles-->
<style type="text/css" media="screen"> 
html, body {    
      margin:0; 
      padding:0; 
      overflow: hidden; 
      background: #FFFFFF; 
   }
 
div#printheader { 
   display: none;
   }
   #idheader { 
      width:100%; 
      height:auto; 
      padding: 0; 
      margin: 0; 
} 
    #idheaderbg  {
    background: #6F6F6F; 
}
   #callout-table, #overview-table {display:block; position:relative; top:0; left:0;}
   #callout-icon {display:block; position:absolute; top:-11px; left:-11px;}
   #callout-icon-flag {display:block; position:absolute; top:-11px; left:-8px;}
   #callout-table a {text-decoration: none; color: blue;}
   #callout-table a:visited {text-decoration: none; color: blue;}
   #overview-table a {text-decoration: none; color: black;}
   #overview-table a:visited {text-decoration: none; color: black;}
   #callout-table a:hover, #overview-table a:hover {text-decoration: underline;}
   p.help-url { margin: 20px 0 5px 0; text-align: center; font-size: 80%; text-decoration: none }
   </style>
<!--[if lt IE 7]>
<style type="text/css">
  #idcontent {padding: 0px;} 
  #innerdiv {padding: 10px 5px 5px 10px ;} 
</style> 
<![endif]-->
   <noscript>
   <style type="text/css">
   html, body { overflow: auto; }
   </style> 
   </noscript>
<style type="text/css" media="print">
span.f_Heading1 { color: black; }
#idheader, #printheader img { display:none; }
#printheader { display: block; margin-top: 20px; }
#idcontent { margin-top: 10px; }
</style>   
   <script type="text/javascript" src="jquery.js"></script>
   <script type="text/javascript" src="helpman_settings.js"></script>
   <script type="text/javascript" src="helpman_topicinit.js"></script>

   <script type="text/javascript">
     HMSyncTOC("index.html", "tambah_anggota.php");
   </script>
   <script type="text/javascript" src="highlight.js"></script>
   <script type="text/javascript">
     $(document).ready(function(){highlight();});
   </script>
</head>
<body>
<!--ZOOMSTOP-->

<div id="printheader"><h1 class="p_Heading1"><span class="f_Heading1">Tambah Anggota</span></h1>
</div>
<div id="idheader">
<div id="idheaderbg">
<table width="100%" border="0" cellspacing="0" cellpadding="0" 
       style="margin: 0px; background: url(header_bg.jpg);">

  <tr valign="bottom">
    <td align="left" valign="bottom" class="topichead">
   <p class="crumbs" id="idnav"><b>Navigation:</b>&nbsp;
   
   <a href="chapter_2.php">Sistem Applikasi</a> &gt; <a href="sub_chapter_2_1.php">Modul Akuntansi</a> &gt; <a href="keanggotaan.php">Keanggotaan</a>&nbsp;&gt;</p>
   <h1 class="p_Heading1"><span class="f_Heading1">Tambah Anggota</span></h1>

    </td>
    <td align="right" width="120" valign="middle" class="topichead" id="idnav">
    
     <a href="keanggotaan.php"
        onmouseover="document.images.prev.src='btn_prev_h.gif'" 
        onmouseout="document.images.prev.src='btn_prev_n.gif'"
        ><img name=prev src="btn_prev_n.gif" border=0 alt="Previous page"
        ></a><a href="keanggotaan.php"
        onmouseover="document.images.main.src='btn_home_h.gif'" 
        onmouseout="document.images.main.src='btn_home_n.gif'"><img name=main src="btn_home_n.gif" border=0 alt="Return to chapter overview"
        ></a><a href="daftar_anggota.php"
        onmouseover="document.images.next.src='btn_next_h.gif'" 
        onmouseout="document.images.next.src='btn_next_n.gif'"><img name=next src="btn_next_n.gif" border=0 alt="Next page"
        ></a>
    </td>
  </tr>
  <tr><td colspan="2" style="height: 3px; background: url(header_bg_shadow.gif)"></td></tr>
</table>
</div>

<!-- The following code displays Expand All/Collapse All links  below the header in topics containing toggles -->
  

</div>  



<div id="idcontent"><div id="innerdiv"> 
<!--ZOOMRESTART-->
<p><span style="font-size: 11pt;">A. Anggota Baru</span></p>
<p><span style="font-size: 11pt;">Input biodata anggota dengan klik menu Keanggotaan </span><span style="font-size: 11pt; font-family: 'Wingdings 3';">&quot;</span><span style="font-size: 11pt;"> registrasi</span></p>
<p><span style="font-size: 11pt;">kemudian akan muncul form seperti gambar di bawah ini :</span></p>
<p><img src="clip0025.png" width="588" height="503" alt="clip0025" style="border:none" /></p>
<p><span style="font-size: 11pt;">Untuk mendaftarkan anggota baru adalah sebagai berikut :</span></p>
<p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 24px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">1.</span><span style="font-size: 11pt;">No. Anggota </span><span style="font-size: 11pt; font-family: 'Wingdings 3';">&quot;</span><span style="font-size: 11pt;"> terisi otomatis dengan nomor terakhir yang di ambil dari data anggota koperasi</span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 24px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">2.</span><span style="font-size: 11pt;">Pilih Departement</span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 24px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">3.</span><span style="font-size: 11pt;">Masukan NIP/ NIK </span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 24px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">4.</span><span style="font-size: 11pt;">Masukan Nama </span><span style="font-size: 11pt; font-family: 'Wingdings 3';">&quot;</span><span style="font-size: 11pt;"> Jika nama sudah pernah ada makan akan muncul daftar nama yang sudah ada dalam database system. Seperti gambar dibawah jadi ketika nama tersebut sudah ada tidak perlu menginput lagi kecuali jika anggota baru tersebut mempunyai nama yang sama dengan yang sudah terdaftar disystem. Jika hal ini terjadi maka salah satu dari nama tersebut harus dibedakan dengan penambahan karekter di nama untuk menghindari kesalahan pembacaan data.</span><img src="clip0026.png" width="569" height="370" alt="clip0026" style="border:none" /></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 24px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">5.</span><span style="font-size: 11pt;">Pilih jenis kelamin</span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 24px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">6.</span><span style="font-size: 11pt;">Masukan alamat dan data pendukung lainya sesuai dengan form tersebut.</span></p><p><span style="font-size: 11pt;">B. Upload Photo</span></p>
<p style="margin: 0px 0px 0px 24px;"><img src="clip0027.png" width="573" height="462" alt="clip0027" style="border:none" /></p>
<p><span style="font-size: 11pt;">Ketik nama anggota yang akan di tambah photonya, kemudian tekan tombol browse dan pilih photo yang akan di upload selanjutnya tekan tombol upload, jika berhasil gambar akan muncul &nbsp;kemudian tekan tombol simpan di bawah gambar.</span></p>
<p><img src="clip0028_zoom79.png" width="699" height="393" alt="clip0028" style="border:none" /></p>
<p><span style="font-size: 11pt;">Jika setelah upload tidak klik tombol simpan gambar tidak akan tersimpan di database.</span></p>
<p><span style="font-size: 11pt;">Untuk merubah gambar upload lagi gambar yang lain kemudian simpan lagi, gambar yang lama akan otomatis terhapus digantikan dengan gambar yang baru.</span></p>
<p>&nbsp;</p>

<!--ZOOMSTOP-->
</div></div>
<script type="text/javascript">

var lastSlashPos = document.URL.lastIndexOf("/") > document.URL.lastIndexOf("\\") ? document.URL.lastIndexOf("/") : document.URL.lastIndexOf("\\");
if( document.URL.substring(lastSlashPos + 1, lastSlashPos + 4).toLowerCase() != "~hh" )
{
 if (document.all) setTimeout(function() {nsrInit();},20); 
    else nsrInit();
 } 


</script>
</body>
</html>








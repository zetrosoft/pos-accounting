<!DOCTYPE HTML>
<html>
<head>
   <title>Sistem Applikasi &gt; Modul Akuntansi &gt; Kode Akuntansi &gt; Perkiraan &gt; Add Perkiraan</title>
   <meta name="generator" content="Help & Manual">
   <meta name="keywords" content="">
   <meta name="description" content="Add Perkiraan">
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
     HMSyncTOC("index.html", "add_perkiraan.php");
   </script>
   <script type="text/javascript" src="highlight.js"></script>
   <script type="text/javascript">
     $(document).ready(function(){highlight();});
   </script>
</head>
<body>
<!--ZOOMSTOP-->

<div id="printheader"><h1 class="p_Heading1"><span class="f_Heading1">Add Perkiraan</span></h1>
</div>
<div id="idheader">
<div id="idheaderbg">
<table width="100%" border="0" cellspacing="0" cellpadding="0" 
       style="margin: 0px; background: url(header_bg.jpg);">

  <tr valign="bottom">
    <td align="left" valign="bottom" class="topichead">
   <p class="crumbs" id="idnav"><b>Navigation:</b>&nbsp;
   
   <a href="chapter_2.php">Sistem Applikasi</a> &gt; <a href="sub_chapter_2_1.php">Modul Akuntansi</a> &gt; <a href="new_topic.php">Kode Akuntansi</a> &gt; <a href="perkiraan.php">Perkiraan</a>&nbsp;&gt;</p>
   <h1 class="p_Heading1"><span class="f_Heading1">Add Perkiraan</span></h1>

    </td>
    <td align="right" width="120" valign="middle" class="topichead" id="idnav">
    
     <a href="perkiraan.php"
        onmouseover="document.images.prev.src='btn_prev_h.gif'" 
        onmouseout="document.images.prev.src='btn_prev_n.gif'"
        ><img name=prev src="btn_prev_n.gif" border=0 alt="Previous page"
        ></a><a href="perkiraan.php"
        onmouseover="document.images.main.src='btn_home_h.gif'" 
        onmouseout="document.images.main.src='btn_home_n.gif'"><img name=main src="btn_home_n.gif" border=0 alt="Return to chapter overview"
        ></a><a href="perkiraan2.php"
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
<p><img src="clip0019.png" width="508" height="415" alt="clip0019" style="border:none" /></p>
<p>&nbsp;</p>
<p><span style="font-size: 11pt;">Untuk membuat perkiraan baru:</span></p>
<p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 24px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">1.</span><span style="font-size: 11pt;"> Pilih klasifikasi </span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 24px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">2.</span><span style="font-size: 11pt;"> Pilih Sub Klasifikasi</span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 24px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">3.</span><span style="font-size: 11pt;"> Pilih Unit</span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 24px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">4.</span><span style="font-size: 11pt;"> Pilih Jenis laporan yang akan menggunakan perkiraan ini nantinya</span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 24px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">5.</span><span style="font-size: 11pt;"> Pilih Laporan Detail</span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 24px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">6.</span><span style="font-size: 11pt;"> Pilih Sistem Kalkulasi ( Aktiva / Pasiva)</span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 24px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">7.</span><span style="font-size: 11pt;"> Kode akan secara otomatis terisi ketika point diatas di lakukan</span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 24px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">8.</span><span style="font-size: 11pt;"> Tulis deskripsi / nama perkiraan yang akan di buat</span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 24px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">9.</span><span style="font-size: 11pt;"> Tentukan Saldo Awal perkiraan tersebut jika ada, secara default saldo awal adalah nol</span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 24px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">10.</span><span style="font-size: 11pt;"> Kemudian tekan tombol simpan untuk menyimpan data-data perkiraan baru tersebut ke database dan bisa digunakan untuk proses selanjutnya</span></p><p style="margin: 0px 0px 0px 24px;">&nbsp;</p>
<p><span style="font-size: 11pt;">contoh pengisian pembuatan perkiraan baru sebelum diklik tombol simpan</span></p>
<p><img src="clip0020.png" width="497" height="423" alt="clip0020" style="border:none" /></p>
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








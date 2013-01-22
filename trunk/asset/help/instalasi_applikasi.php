<!DOCTYPE HTML>
<html>
<head>
   <title>Sistem Applikasi &gt; Instalasi Applikasi</title>
   <meta name="generator" content="Help & Manual">
   <meta name="keywords" content="">
   <meta name="description" content="Instalasi Applikasi">
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
     HMSyncTOC("index.html", "instalasi_applikasi.php");
   </script>
   <script type="text/javascript" src="highlight.js"></script>
   <script type="text/javascript">
     $(document).ready(function(){highlight();});
   </script>
</head>
<body>
<!--ZOOMSTOP-->

<div id="printheader"><h1 class="p_Heading1"><span class="f_Heading1">Instalasi Applikasi</span></h1>
</div>
<div id="idheader">
<div id="idheaderbg">
<table width="100%" border="0" cellspacing="0" cellpadding="0" 
       style="margin: 0px; background: url(header_bg.jpg);">

  <tr valign="bottom">
    <td align="left" valign="bottom" class="topichead">
   <p class="crumbs" id="idnav"><b>Navigation:</b>&nbsp;
   
   <a href="chapter_2.php">Sistem Applikasi</a>&nbsp;&gt;</p>
   <h1 class="p_Heading1"><span class="f_Heading1">Instalasi Applikasi</span></h1>

    </td>
    <td align="right" width="120" valign="middle" class="topichead" id="idnav">
    
     <a href="overview.php"
        onmouseover="document.images.prev.src='btn_prev_h.gif'" 
        onmouseout="document.images.prev.src='btn_prev_n.gif'"
        ><img name=prev src="btn_prev_n.gif" border=0 alt="Previous page"
        ></a><a href="chapter_2.php"
        onmouseover="document.images.main.src='btn_home_h.gif'" 
        onmouseout="document.images.main.src='btn_home_n.gif'"><img name=main src="btn_home_n.gif" border=0 alt="Return to chapter overview"
        ></a><a href="admin_pengguna.php"
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
<p><span style="font-size: 11pt;">Applikasi ini hanya diinstall pada sebuah server saja, yang sebelumnya server sudah di install dengan Web server </span></p>
<p><span style="font-size: 11pt;">Cara Instalasi</span></p>
<p><span style="font-size: 11pt;">1. Web Server IIS 6.0</span></p>
<p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 16px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">1.</span><span style="font-size: 11pt;">Web server IIS hanya untuk OS Windows saja yaitu dengan mengaktifkan web server melalu Add Program pada control panel windows dan koneksikan dengan applikasi PHP dengan melakukan instalasi php dari file instalasi binary php (sumber : <a href="http://windows.php.net/download/#php-5.3" target="_blank" class="weblink">http://windows.php.net/download/#php-5.3</a> ) pilih VC9-X86 Non thread safe &nbsp;Installer. Kemudian instal database MySQL 5.0 atau yang lebih tinggi dan MySQL Conector ODBC ( sumber : <a href="http://www.mysql.com/downloads/mysql/" target="_blank" class="weblink">http://www.mysql.com/downloads/mysql/</a> ).</span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 16px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">2.</span><span style="font-size: 11pt;">setelah installasi berjalan dengan benar IIS dan PHP sudah terintegrasi copykan file applikasi ( satu folder KBR) ke direktori c:\inetpub\wwwroot.</span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 16px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">3.</span><span style="font-size: 11pt;">Kemudian jalankan query sql dari file sql di folder KBR/asset/temp/db_kosong.sql, untuk menjalankan query sql tersebut bisa menggunakan program MySQL GUI seperti HeidiSQL (<a href="http://www.heidisql.com/download.php" target="_blank" class="weblink">http://www.heidisql.com/download.php</a> ) namun program ini tidak jalan di windows server hanya jalan di Windows X86 saja atau Navicat (<a href="http://navicat.com/en/download/download.html" target="_blank" class="weblink">http://navicat.com/en/download/download.html</a> ).</span></p><p style="margin: 0px 0px 0px 16px;">&nbsp;</p>
<p><span style="font-size: 11pt;">2. Web Server Apache 2.0</span></p>
<p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 17px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">1.</span><span style="font-size: 11pt;"> Download XAMPP for Windows di sini: <a href="http://www.apachefriends.org/en/xampp-windows.html" target="_blank" class="weblink">http://www.apachefriends.org/en/xampp-windows.html</a></span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 17px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">2.</span><span style="font-size: 11pt;">Lakukan installasi dengan mengikuti petunjuk pada saat instalasi, dalam applikasi xampp sudah secara otomatis terinstall PHP dan MySQL database</span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 17px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">3.</span><span style="font-size: 11pt;">Setelah selesai proses intalasinya copy kan &nbsp;file applikasi ( satu folder KBR) ke folder c:\xampp\httdocs\</span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 17px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">4.</span><span style="font-size: 11pt;">Kemudian lakukan atau execute query sql dengan membuka phpmyadmin sebuah program GUI MySQL yang sudah terinstall secara otomatis bersamaan dengan proses intalasi xampp. Untuk menjalankan phpMyAdmin buka Browser ( </span><span style="font-size: 11pt; font-style: italic;">firefox -recomended</span><span style="font-size: 11pt;">) dan ketik pada address bar <a href="http://ocalhost/phpmyadmin" target="_blank" class="weblink">http://ocalhost/phpmyadmin</a></span></p><p style="text-align: justify; line-height: 1.50; padding: 0px 0px 0px 16px; margin: 0px 0px 0px 17px;"><span style="font-size:11pt; font-family: 'Arial';color:#000000;display:inline-block;width:16px;margin-left:-16px">5.</span><span style="font-size: 11pt;">kemudian buat database kopkardbd dan import file &nbsp;KBR/asset/temp/db_kosong.sql kemudian execute tunggu sampai proses selesai</span></p><p style="text-indent: 2px; margin: 0px 0px 0px 15px;">&nbsp;</p>
<p><span style="font-size: 11pt;">Proses intalasi selesai dan jalankan applikasi dari browser (</span><span style="font-size: 11pt; font-style: italic;">firefox) </span><span style="font-size: 11pt;">dengan menulis di addresbar &nbsp;sebagai berikut <a href="http://192.168.9.253/KBR" target="_blank" class="weblink">http://192.168.9.253/KBR</a> &nbsp; (192.168.9.253 adalah IP address server KBR)</span></p>
<p><span style="font-size: 11pt;">Pada saat pertama kali applikasi Sistem Informasi Management Koperasi Karyawan ini dijalankan kita akan diminta untuk membuat password user Superuser yang nantinya userid tersebut akan digunakan untuk mengelola applikasi dengan otorisasi full.</span></p>
<p><span style="font-size: 11pt;">Masukan password untuk userid : superuser</span></p>
<p style="text-align: center;"><img src="clip0002.png" width="378" height="246" alt="clip0002" style="border:none" /></p>
<p style="text-align: left;"><span style="font-size: 11pt;">kemudian click tombol Create Super User dan akan masuk ke menu login</span></p>
<p style="text-align: center;"><img src="clip0003.png" width="373" height="242" alt="clip0003" style="border:none" /></p>
<p style="text-align: left;"><span style="font-size: 11pt;">masukan user id : superuser</span></p>
<p style="text-align: left;"><span style="font-size: 11pt;">password &nbsp; &nbsp; &nbsp; &nbsp;: sesuai dengan passorwd yang sudah dibuat</span></p>
<p style="text-align: left;">&nbsp;</p>
<p style="text-align: left;"><span style="font-size: 11pt;">Untuk pertama kali login dengan program ini jika belum diregistrasi akan muncul error seperti gambar di bawah ini</span></p>
<p style="text-align: center;"><img src="clip0004.png" width="351" height="259" alt="clip0004" style="border:none" /></p>
<p style="text-align: left;"><span style="font-size: 11pt;">informasikan ke kami &nbsp;via e-mail <a href="mailto:contact@smarthome-kanz.com" class="weblink">contact@smarthome-kanz.com</a> dan tulis kode seperti yang tertera di error tersebut. dan kami akan mengirimkan data resitrasinya</span></p>
<p style="text-align: left;"><span style="font-size: 11pt;">Setelah dilakukan registrasi dan sudah mendapatkan data registrasinya barus bisa melakukan login ke applikasi dan akan mendapat layar seperti gambar dibawah ini.</span></p>
<p style="text-align: center;"><img src="clip0001.png" width="633" height="481" alt="clip0001" style="border:none" /></p>
<p style="text-align: left;">&nbsp;</p>
<p>&nbsp;</p>
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








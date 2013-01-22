/*!
Premium Pack iPad Skin Version 2.0 script functions
For Help & Manual 6 only 
Copyright (c) 2008-2011 by Tim Green. 
All rights reserved.
*/
var hmTouch={myScroll:null,scrW:parent.window.hmMobile.scrW,scrH:parent.window.hmMobile.scrH,navOfs:parent.window.hmMobile.navOfs,navWd:0,padOfs:0,curWd:0,widest:0,loc:document.location.pathname.substr(document.location.pathname.lastIndexOf("/")+1),wHorizontal:function(){return(Math.abs(parent.window.orientation)-90===0)?true:false},widestElem:function(){hmTouch.navWd=$("#hmnavbox",parent.document).width();var b=0;var a=(hmTouch.scrW-(hmTouch.navWd+20))+"px";$("body").css({visibility:"hidden",width:a});$('table,img,div[css*="width"]').not("#pageScroller,#pageContent,#pageSizer").each(function(){var c=$(this).width();b=(c>b)?c:b});$("body").css("width","");hmTouch.widest=b;parent.window.hmMobile.widest=b},setSize:function(){hmTouch.navWd=$("#hmnavbox",parent.document).width();var b=hmTouch.wHorizontal()?(hmTouch.scrH-hmTouch.navWd-20):(hmTouch.scrW-hmTouch.navWd-20);hmTouch.curWd=(hmTouch.widest>b)?hmTouch.widest+10+"px":b+"px";var a=$("#hmcontainer",parent.document).outerHeight(true)-4;hmTouch.navOfs=hmTouch.wHorizontal()?hmTouch.scrW-a:hmTouch.scrH-a;hmTouch.padOfs=$("body").outerWidth(true)-$("body").width()},resizeWin:function(a){$("#pageScroller,#pageSizer,#pageContent").css("width","auto");if(a){hmTouch.setSize()}var d=$("#hmpagePageHeader").outerHeight(true)+hmTouch.navOfs;var c=hmTouch.wHorizontal()?hmTouch.scrW-d:hmTouch.scrH-d;var b=hmTouch.wHorizontal()?hmTouch.scrH-hmTouch.navWd-(hmTouch.padOfs+10):hmTouch.scrW-hmTouch.navWd-(hmTouch.padOfs+10);$("#pageContent").css({width:(b+hmTouch.padOfs)+"px",height:c+"px"});$("#pageSizer").css("width",(b)+"px");$("div#pageScroller").css("width",hmTouch.curWd);if(a){setTimeout(function(){hmTouch.myScroll.refresh()},0)}},tOpener:function(b){var a=b+"_ICON";if($("img[id='"+a+"']").length>0){HMToggle("expand",b,a)}else{HMToggle("expand",b)}},toggleJump:function(d){var a=$(d).parents("div[id^='TOGGLE']");var e=0;if(a.length>0){for(var b=a.length-1;b>-1;b--){if($(a[b]).attr("hm.state")=="0"){var c=$(a[b]).attr("id");hmTouch.tOpener(c);e++}}}return e*200},openTargetT:function(c){var a=$(c).parent("p:has(a.dropdown-toggle)");if(a.length>0){a=$(a).find("a.dropdown-toggle").attr("href");var b=a.replace(/^.*?\,\'/,"");b=b.replace(/\'.*$/,"");hmTouch.tOpener(b)}else{a=$(c).siblings("img[hm.type='dropdown']");if(a.length>0){a=$(a).attr("id");var b=a.replace("_ICON","");hmTouch.tOpener(b)}}},scroller:function(c,b){if(b){c=b}var d=$("#pageContent").outerHeight()<$("#pageScroller").outerHeight();if(d&&$(c).position()!=null){var e=$(c).position().top;var a=$("#pageScroller").height()-($("#pageContent").height());e=e>a?-a:-e;setTimeout(function(){hmTouch.myScroll.scrollTo(0,e,600)},100)}},fixLinks:function(){$("a[href^='http'],a[href^='ftp']").attr("target","_blank");$("a").not("[href^='http'],[href^='ftp'],[href^='javascript']").each(function(){if($(this).attr("href")){if($(this).attr("href")=="#"){$(this).attr("href","javascript:void(0)");return false}var b=$(this).attr("href");if(b.indexOf("#")>-1){var a=b.indexOf("#");var c=b.substr(a);if(a===0){b=window.location.pathname;b=b.lastIndexOf("/")>-1?b.substr(b.lastIndexOf("/")+1):b}else{b=b.substr(0,a)}}$(this).click(function(d){d.preventDefault();parent.window.hmMobile.anchorTarget=c;if(b!==hmTouch.loc){if(parent.hmMobile.isIOS5){location.assign(b)}else{location.replace(b)}return false}else{var e=hmTouch.toggleJump(c);setTimeout(function(){hmTouch.scroller(c);setTimeout(function(){hmTouch.openTargetT(c)},600)},e)}})}})},init:function(){if(parent.hmMobile.isIOS5){if(parent.hmMobile.currentNav=="iframe#hmindex"&&!parent.document.getElementById("hmindex").contentWindow.hmTouch){parent.hmMobile.idxDoc.location.replace(parent.hmMobile.idxPage);$("a#ctLink",window.parent.document).trigger("click")}}hmTouch.fixLinks();var a=parent.window.hmMobile.anchorTarget;hmTouch.widestElem();hmTouch.setSize();$("div#pageScroller").css("width",hmTouch.curWd);$(document).bind("touchmove",function(c){c.preventDefault()});if($("div#pageSizer").length<1){$("div#pageScroller").wrapInner('<div id="pageSizer" />')}hmTouch.resizeWin(false);if(hmTouch.myScroll!=null){hmTouch.myScroll.destroy();hmTouch.myScroll=null}setTimeout(function(){hmTouch.myScroll=new iScroll("pageContent",{zoom:true,maxZoom:2,fadeScrollbar:false})},100);$("body").hide().css("visibility","visible").fadeIn("fast");if(a!=""||$("span.highlight").length>0){var b=hmTouch.toggleJump(a);setTimeout(function(){hmTouch.scroller(a,$("span.highlight")[0]);setTimeout(function(){hmTouch.openTargetT(a)},600)},b)}parent.window.hmMobile.anchorTarget=""},};$(document).ready(function(){if(!parent.hmMobile.schVisible&&!parent.hmMobile.isZoom){hmTouch.init();if(HMToggles.length>0||HMGallery.length>0){var a=setInterval(function(){if(hmTouch.myScroll.vScroll){clearInterval(a);setTimeout(function(){hmTouch.myScroll.refresh()},500)}},100)}}});
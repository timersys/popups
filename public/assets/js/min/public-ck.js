function createCookie(t,n,e){if(e){var i=new Date;i.setTime(i.getTime()+24*e*60*60*1e3);var o="; expires="+i.toGMTString()}else var o="";document.cookie=t+"="+n+o+"; path=/"}function readCookie(t){for(var n=t+"=",e=document.cookie.split(";"),i=0;i<e.length;i++){for(var o=e[i];" "==o.charAt(0);)o=o.substring(1,o.length);if(0==o.indexOf(n))return o.substring(n.length,o.length)}return null}jQuery(window).load(function(){window.SPU=function(t){function n(n){var e=a[n],i=t(window).width(),o=t(window).height(),r=e.height(),s=e.width();e.css({position:"fixed",top:o/2-r/2,left:i/2-s/2})}function e(n,e){var i=a[n],o=t("#spu-bg-"+n),r=i.data("bgopa");if(i.is(":animated"))return!1;if(e===!0&&i.is(":visible")||e===!1&&i.is(":hidden"))return!1;var s=i.data("animation");return"fade"===s?i.fadeToggle("slow"):i.slideToggle("slow"),e===!0&&r>0?o.fadeIn():o.fadeOut(),e}var i=t(window).height(),o=spuvar.is_admin,a=[];return t(".spu-content").children().first().css({"margin-top":0,"padding-top":0}).end().last().css({"margin-bottom":0,"padding-bottom":0}),t(".spu-box").each(function(){var r=t(this),s=r.data("trigger"),d=r.data("animation"),c=0,u=1===parseInt(r.data("test-mode")),l=r.data("box-id"),f=1===parseInt(r.data("auto-hide")),h=1===parseInt(r.data("advanced-close")),w=parseInt(r.data("seconds-close"));if(h){t(document).keyup(function(t){27==t.keyCode&&e(l,!1)});var g=navigator.userAgent,p=g.match(/iPad/i)||g.match(/iPhone/i)?"touchstart":"click";t("body").on(p,function(t){e(l,!1)}),t(".spu-box").click(function(t){t.stopPropagation()})}if(r.hide().css("left",""),a[l]=r,"seconds"==s)var m=parseInt(r.data("trigger-number"),10);else var v="percentage"==s?parseInt(r.data("trigger-number"),10)/100:.8,b=v*t(document).height();var k=function(){c&&clearTimeout(c),c=window.setTimeout(function(){var o=t(window).scrollTop(),a=o+i>=b;a?(f||t(window).unbind("scroll",k),r.hasClass("spu-centered")&&n(l),e(l,!0)):e(l,!1)},100)},T=function(){c&&clearTimeout(c),c=window.setTimeout(function(){r.hasClass("spu-centered")&&n(l),e(l,!0)},1e3*m)},x=readCookie("spu_box_"+l);if((void 0==x||o&&u)&&("seconds"==s?T():(t(window).bind("scroll",k),k()),window.location.hash&&window.location.hash.length>0)){var I=window.location.hash,C;I.substring(1)===r.attr("id")&&setTimeout(function(){e(l,!0)},100)}r.find(".spu-close").click(function(){e(l,!1),"percentage"==s&&t(window).unbind("scroll",k);var n=parseInt(r.data("cookie"));n>0&&createCookie("spu_box_"+l,!0,n)}),t('a[href="#'+r.attr("id")+'"]').click(function(){return e(l,!0),!1})}),{show:function(t){return e(t,!0)},hide:function(t){return e(t,!1)}}}(window.jQuery)});
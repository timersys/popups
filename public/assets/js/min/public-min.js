// (function(){function t(){}function e(t,e){for(var n=t.length;n--;)if(t[n].listener===e)return n;return-1}function n(t){return function(){return this[t].apply(this,arguments)}}var i=t.prototype,r=this,o=r.EventEmitter;i.getListeners=function(t){var e,n,i=this._getEvents();if("object"==typeof t){e={};for(n in i)i.hasOwnProperty(n)&&t.test(n)&&(e[n]=i[n])}else e=i[t]||(i[t]=[]);return e},i.flattenListeners=function(t){var e,n=[];for(e=0;t.length>e;e+=1)n.push(t[e].listener);return n},i.getListenersAsObject=function(t){var e,n=this.getListeners(t);return n instanceof Array&&(e={},e[t]=n),e||n},i.addListener=function(t,n){var i,r=this.getListenersAsObject(t),o="object"==typeof n;for(i in r)r.hasOwnProperty(i)&&-1===e(r[i],n)&&r[i].push(o?n:{listener:n,once:!1});return this},i.on=n("addListener"),i.addOnceListener=function(t,e){return this.addListener(t,{listener:e,once:!0})},i.once=n("addOnceListener"),i.defineEvent=function(t){return this.getListeners(t),this},i.defineEvents=function(t){for(var e=0;t.length>e;e+=1)this.defineEvent(t[e]);return this},i.removeListener=function(t,n){var i,r,o=this.getListenersAsObject(t);for(r in o)o.hasOwnProperty(r)&&(i=e(o[r],n),-1!==i&&o[r].splice(i,1));return this},i.off=n("removeListener"),i.addListeners=function(t,e){return this.manipulateListeners(!1,t,e)},i.removeListeners=function(t,e){return this.manipulateListeners(!0,t,e)},i.manipulateListeners=function(t,e,n){var i,r,o=t?this.removeListener:this.addListener,s=t?this.removeListeners:this.addListeners;if("object"!=typeof e||e instanceof RegExp)for(i=n.length;i--;)o.call(this,e,n[i]);else for(i in e)e.hasOwnProperty(i)&&(r=e[i])&&("function"==typeof r?o.call(this,i,r):s.call(this,i,r));return this},i.removeEvent=function(t){var e,n=typeof t,i=this._getEvents();if("string"===n)delete i[t];else if("object"===n)for(e in i)i.hasOwnProperty(e)&&t.test(e)&&delete i[e];else delete this._events;return this},i.removeAllListeners=n("removeEvent"),i.emitEvent=function(t,e){var n,i,r,o,s=this.getListenersAsObject(t);for(r in s)if(s.hasOwnProperty(r))for(i=s[r].length;i--;)n=s[r][i],n.once===!0&&this.removeListener(t,n.listener),o=n.listener.apply(this,e||[]),o===this._getOnceReturnValue()&&this.removeListener(t,n.listener);return this},i.trigger=n("emitEvent"),i.emit=function(t){var e=Array.prototype.slice.call(arguments,1);return this.emitEvent(t,e)},i.setOnceReturnValue=function(t){return this._onceReturnValue=t,this},i._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},i._getEvents=function(){return this._events||(this._events={})},t.noConflict=function(){return r.EventEmitter=o,t},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return t}):"object"==typeof module&&module.exports?module.exports=t:this.EventEmitter=t}).call(this),function(t){function e(e){var n=t.event;return n.target=n.target||n.srcElement||e,n}var n=document.documentElement,i=function(){};n.addEventListener?i=function(t,e,n){t.addEventListener(e,n,!1)}:n.attachEvent&&(i=function(t,n,i){t[n+i]=i.handleEvent?function(){var n=e(t);i.handleEvent.call(i,n)}:function(){var n=e(t);i.call(t,n)},t.attachEvent("on"+n,t[n+i])});var r=function(){};n.removeEventListener?r=function(t,e,n){t.removeEventListener(e,n,!1)}:n.detachEvent&&(r=function(t,e,n){t.detachEvent("on"+e,t[e+n]);try{delete t[e+n]}catch(i){t[e+n]=void 0}});var o={bind:i,unbind:r};"function"==typeof define&&define.amd?define("eventie/eventie",o):t.eventie=o}(this),function(t,e){"function"==typeof define&&define.amd?define(["eventEmitter/EventEmitter","eventie/eventie"],function(n,i){return e(t,n,i)}):"object"==typeof exports?module.exports=e(t,require("wolfy87-eventemitter"),require("eventie")):t.imagesLoaded=e(t,t.EventEmitter,t.eventie)}(window,function(t,e,n){function i(t,e){for(var n in e)t[n]=e[n];return t}function r(t){return"[object Array]"===p.call(t)}function o(t){var e=[];if(r(t))e=t;else if("number"==typeof t.length)for(var n=0,i=t.length;i>n;n++)e.push(t[n]);else e.push(t);return e}function s(t,e,n){if(!(this instanceof s))return new s(t,e);"string"==typeof t&&(t=document.querySelectorAll(t)),this.elements=o(t),this.options=i({},this.options),"function"==typeof e?n=e:i(this.options,e),n&&this.on("always",n),this.getImages(),f&&(this.jqDeferred=new f.Deferred);var r=this;setTimeout(function(){r.check()})}function a(t){this.img=t}function u(t){this.src=t,l[t]=this}var f=t.jQuery,c=t.console,d=void 0!==c,p=Object.prototype.toString;s.prototype=new e,s.prototype.options={},s.prototype.getImages=function(){this.images=[];for(var t=0,e=this.elements.length;e>t;t++){var n=this.elements[t];"IMG"===n.nodeName&&this.addImage(n);var i=n.nodeType;if(i&&(1===i||9===i||11===i))for(var r=n.querySelectorAll("img"),o=0,s=r.length;s>o;o++){var a=r[o];this.addImage(a)}}},s.prototype.addImage=function(t){var e=new a(t);this.images.push(e)},s.prototype.check=function(){function t(t,r){return e.options.debug&&d&&c.log("confirm",t,r),e.progress(t),n++,n===i&&e.complete(),!0}var e=this,n=0,i=this.images.length;if(this.hasAnyBroken=!1,!i)return void this.complete();for(var r=0;i>r;r++){var o=this.images[r];o.on("confirm",t),o.check()}},s.prototype.progress=function(t){this.hasAnyBroken=this.hasAnyBroken||!t.isLoaded;var e=this;setTimeout(function(){e.emit("progress",e,t),e.jqDeferred&&e.jqDeferred.notify&&e.jqDeferred.notify(e,t)})},s.prototype.complete=function(){var t=this.hasAnyBroken?"fail":"done";this.isComplete=!0;var e=this;setTimeout(function(){if(e.emit(t,e),e.emit("always",e),e.jqDeferred){var n=e.hasAnyBroken?"reject":"resolve";e.jqDeferred[n](e)}})},f&&(f.fn.imagesLoaded=function(t,e){var n=new s(this,t,e);return n.jqDeferred.promise(f(this))}),a.prototype=new e,a.prototype.check=function(){var t=l[this.img.src]||new u(this.img.src);if(t.isConfirmed)return void this.confirm(t.isLoaded,"cached was confirmed");if(this.img.complete&&void 0!==this.img.naturalWidth)return void this.confirm(0!==this.img.naturalWidth,"naturalWidth");var e=this;t.on("confirm",function(t,n){return e.confirm(t.isLoaded,n),!0}),t.check()},a.prototype.confirm=function(t,e){this.isLoaded=t,this.emit("confirm",this,e)};var l={};return u.prototype=new e,u.prototype.check=function(){if(!this.isChecked){var t=new Image;n.bind(t,"load",this),n.bind(t,"error",this),t.src=this.src,this.isChecked=!0}},u.prototype.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},u.prototype.onload=function(t){this.confirm(!0,"onload"),this.unbindProxyEvents(t)},u.prototype.onerror=function(t){this.confirm(!1,"onerror"),this.unbindProxyEvents(t)},u.prototype.confirm=function(t,e){this.isConfirmed=!0,this.isLoaded=t,this.emit("confirm",this,e)},u.prototype.unbindProxyEvents=function(t){n.unbind(t.target,"load",this),n.unbind(t.target,"error",this)},s}),function($){"use strict";function t(t,e,n,i,r){var o={url:spuvar.ajax_url,data:t,cache:!1,type:"POST",dataType:"json",timeout:3e4},r=r||!1,n=n||!1,i=i||!1;e&&(o.url=e),n&&(o.success=n),i&&(o.error=i),r&&(o.dataType=r),$.ajax(o)}function e(t,e,n){if(n){var i=new Date;i.setTime(i.getTime()+24*n*60*60*1e3);var r="; expires="+i.toGMTString()}else var r="";document.cookie=t+"="+e+r+"; path=/"}function n(t){for(var e=t+"=",n=document.cookie.split(";"),i=0;i<n.length;i++){for(var r=n[i];" "==r.charAt(0);)r=r.substring(1,r.length);if(0==r.indexOf(e))return r.substring(e.length,r.length)}return null}function i(){try{FB.Event.subscribe("edge.create",function(t,e){var n=$(e).parents(".spu-box").data("box-id");n&&SPU.hide(n,!1,!0)})}catch(t){}l=!0,clearInterval(h)}function r(t){var e=$(t.target).parents(".spu-box").data("box-id");e&&SPU.hide(e,!1,!0)}function o(t){if("on"==t.state){var e=jQuery(".spu-gogl").data("box-id");e&&SPU.hide(e,!1,!0)}}function s(t){if("confirm"==t.type){var e=jQuery(".spu-gogl").data("box-id");e&&SPU.hide(e,!1,!0)}}function a(){if("undefined"!=typeof spuvar_social&&spuvar_social.facebook)try{FB.XFBML.parse()}catch(t){}if("undefined"!=typeof spuvar_social&&spuvar_social.google)try{gapi.plusone.go()}catch(t){}if("undefined"!=typeof spuvar_social&&spuvar_social.twitter)try{twttr.widgets.load()}catch(t){}}function u(){$(".spu-box form").each(function(){var t=$(this).attr("action");t&&$(this).attr("action",t.replace("?spu_action=spu_load",""))}),$.fn.wpcf7InitForm&&$(".spu-box div.wpcf7 > form").wpcf7InitForm()}var f=function(){function i(t){var e=c[t],n=$(window).width(),i=$(window).height(),r=e.outerHeight(),o=e.outerWidth(),s=e.data("width"),a=0,u=i/2-r/2,f="fixed",d=$(document).scrollTop();e.hasClass("spu-centered")&&(n>s&&(a=n/2-o/2),e.css({left:a,position:f,top:u})),r+50>i&&(f="absolute",u=d,e.css({position:f,top:u,bottom:"auto"}))}function r(t){var e=$(t).find(".spu-facebook");if(e.length){var n=e.find(".fb-like > span").width();if(0==n){var i=e.find(".fb-like").data("layout");"box_count"==i?e.append('<style type="text/css"> #'+$(t).attr("id")+" .fb-like iframe, #"+$(t).attr("id")+" .fb_iframe_widget span, #"+$(t).attr("id")+" .fb_iframe_widget{ height: 63px !important;width: 80px !important;}</style>"):"button_count"==i?e.append('<style type="text/css"> #'+$(t).attr("id")+" .fb-like iframe, #"+$(t).attr("id")+" .fb_iframe_widget span, #"+$(t).attr("id")+" .fb_iframe_widget{ height: 20px !important;min-width: 120px !important;}</style>"):e.append('<style type="text/css"> #'+$(t).attr("id")+" .fb-like iframe, #"+$(t).attr("id")+" .fb_iframe_widget span, #"+$(t).attr("id")+" .fb_iframe_widget{ height: 20px !important;width: 80px !important;}</style>")}}}function o(t){var e=t,n=e.data("total");if(n){a();var i=0,r=0,o=e.outerWidth(),s=e.find(".spu-content").width();!spuvar.disable_style&&$(window).width()>o&&(e.find(".spu-shortcode").wrapAll('<div class="spu_shortcodes"/>'),e.find(".spu-shortcode").each(function(){i+=$(this).outerWidth()}),r=s-i-20*n),r>0&&(e.find(".spu-shortcode").each(function(){$(this).css("margin-left",r/2)}),2==n?e.find(".spu-shortcode").last().css("margin-left",0):3==n&&e.find(".spu-shortcode").first().css("margin-left",0))}}function s(t,n,r){var s=c[t],a=$("#spu-bg-"+t),u=s.data("bgopa");if(s.is(":animated"))return!1;if(n===!0&&s.is(":visible")||n===!1&&s.is(":hidden"))return!1;if(n===!1){var f=parseInt(s.data("close-cookie"));r===!0&&(f=parseInt(s.data("cookie"))),f>0&&e("spu_box_"+t,!0,f),s.trigger("spu.box_close",[t])}else setTimeout(function(){o(s)},1500),s.trigger("spu.box_open",[t]),$(window).resize(function(){i(t)}),i(t);var d=s.data("spuanimation"),p=s.data("close-on-conversion");return"fade"===d?n===!0?s.fadeIn("slow"):n===!1&&(p&&r||!r)&&s.fadeOut("slow"):n===!0?s.slideDown("slow"):n===!1&&(p&&r||!r)&&s.slideUp("slow"),n===!0&&u>0?a.fadeIn():n===!1&&(p&&r||!r)&&a.fadeOut(),n}var u=$(window).height(),f=spuvar.is_admin,c=[];return $(".spu-content").children().first().css({"margin-top":0,"padding-top":0}).end().last().css({"margin-bottom":0,"padding-bottom":0}),$(".spu-box").each(function(){spuvar.safe_mode&&$(this).prependTo("body");var e=$(this),i=e.data("trigger"),o=0,a=1===parseInt(e.data("test-mode")),d=e.data("box-id"),p=1===parseInt(e.data("auto-hide")),l=parseInt(e.data("seconds-close")),h=parseInt(e.data("trigger-number"),10),m="percentage"==i?parseInt(e.data("trigger-number"),10)/100:.8,v=m*$(document).height();r(e),e.on("click",'a:not(".spu-close-popup, .flp_wrapper a, .spu-not-close")',function(){s(d,!1,!0)}),$(document).keyup(function(t){27==t.keyCode&&s(d,!1,!1)});var g=navigator.userAgent,y=g.match(/iPad/i)||g.match(/iPhone/i)?"touchstart":"click";$("body").on(y,function(t){void 0!==t.originalEvent&&s(d,!1,!1)}),$("body").on(y,".spu-box,.spu-clickable",function(t){t.stopPropagation()}),e.hide().css("left",""),c[d]=e;var b=function(){o&&clearTimeout(o),o=window.setTimeout(function(){var t=$(window).scrollTop(),e=t+u>=v;e?(p||$(window).unbind("scroll",b),s(d,!0,!1)):s(d,!1,!1)},100)},w=function(){o&&clearTimeout(o),o=window.setTimeout(function(){s(d,!0,!1)},1e3*h)},_=n("spu_box_"+d);if((void 0==_||""==_||f&&a)&&("seconds"==i&&w(),"percentage"==i&&($(window).bind("scroll",b),b()),window.location.hash&&window.location.hash.length>0)){var x=window.location.hash,E;x.substring(1)===e.attr("id")&&setTimeout(function(){s(d,!0,!1)},100)}e.on("click",".spu-close-popup",function(){s(d,!1,!1),"percentage"==i&&$(window).unbind("scroll",b)}),$(document.body).on("click",'a[href="#spu-'+d+'"], .spu-open-'+d,function(t){t.preventDefault(),s(d,!0,!1)}),$('a[href="#spu-'+d+'"], .spu-open-'+d).css("cursor","pointer").addClass("spu-clickable"),e.find(".gform_wrapper form").addClass("gravity-form"),e.find(".mc4wp-form form").addClass("mc4wp-form"),e.find(".newsletter form").addClass("newsletter-form");var L=e.find("form");if(L.length){if(!L.is(".newsletter-form, .wpcf7-form, .gravity-form, .infusion-form, .widget_wysija, .ninja-forms-form")){var j=L.attr("action"),k=new RegExp(spuvar.site_url,"i");j&&j.length&&(k.test(j)||L.addClass("spu-disable-ajax"))}$(".spu-disable-ajax form").length&&$(".spu-disable-ajax form").addClass("spu-disable-ajax"),e.on("submit",'form.spu-disable-ajax:not(".flp_form")',function(){e.trigger("spu.form_submitted",[d]),s(d,!1,!0)}),e.on("submit",'form:not(".newsletter-form, .wpcf7-form, .gravity-form, .infusion-form, .spu-disable-ajax, .widget_wysija, .ninja-forms-form, .flp_form")',function(n){n.preventDefault();var i=!0,r=$(this),o=r.serialize(),a=r.hasClass("mc4wp-form")?spuvar.site_url+"/":r.attr("action"),u=function(t,e,n){console.log("Spu Form error: "+e+" - "+n)},f=function(t){var e=$(t).filter("#spu-"+d).html();$("#spu-"+d).html(e),$("#spu-"+d).find(".mc4wp-form-error").length||setTimeout(function(){s(d,!1,!0)},1e3*spuvar.seconds_confirmation_close)};return t(o,a,f,u,"html"),e.trigger("spu.form_submitted",[d]),i}),$("body").on("mailsent.wpcf7",function(){e.trigger("spu.form_submitted",[d]),s(d,!1,!0)}),$(document).on("gform_confirmation_loaded",function(){e.trigger("spu.form_submitted",[d]),s(d,!1,!0)}),e.on("submit",".infusion-form",function(t){t.preventDefault(),e.trigger("spu.form_submitted",[d]),s(d,!1,!0),this.submit()}),e.on("submit",".newsletter-form",function(t){t.preventDefault(),e.trigger("spu.form_submitted",[d]),s(d,!1,!0),this.submit()}),$("body").on("submitResponse.default",function(){e.trigger("spu.form_submitted",[d]),s(d,!1,!0)})}}),{show:function(t){return s(t,!0,!1)},hide:function(t,e,n){return s(t,!1,n)},request:function(e,n,i,r){return t(e,n,i,r)}}};if(spuvar.ajax_mode){var c={pid:spuvar.pid,referrer:document.referrer,query_string:document.location.search,is_category:spuvar.is_category,is_archive:spuvar.is_archive},d=function(t){$("body").append(t),$(".spu-box").imagesLoaded(function(){window.SPU=f(),u()})},p=function(t,e,n){console.log("Problem loading popups - error: "+e+" - "+n)};t(c,spuvar.ajax_mode_url,d,p,"html")}else $(".spu-box").imagesLoaded(function(){window.SPU=f()});var l=!1,h=setInterval(function(){"undefined"==typeof FB||l||i()},1e3);if("undefined"!=typeof twttr)try{twttr.ready(function(t){t.events.bind("tweet",r),t.events.bind("follow",r)})}catch(m){}}(jQuery);/*!
 /* imagesLoaded PACKAGED v3.1.8
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */
(function(){function e(){}function t(e,t){for(var n=e.length;n--;)if(e[n].listener===t)return n;return-1}function n(e){return function(){return this[e].apply(this,arguments)}}var i=e.prototype,r=this,o=r.EventEmitter;i.getListeners=function(e){var t,n,i=this._getEvents();if("object"==typeof e){t={};for(n in i)i.hasOwnProperty(n)&&e.test(n)&&(t[n]=i[n])}else t=i[e]||(i[e]=[]);return t},i.flattenListeners=function(e){var t,n=[];for(t=0;e.length>t;t+=1)n.push(e[t].listener);return n},i.getListenersAsObject=function(e){var t,n=this.getListeners(e);return n instanceof Array&&(t={},t[e]=n),t||n},i.addListener=function(e,n){var i,r=this.getListenersAsObject(e),o="object"==typeof n;for(i in r)r.hasOwnProperty(i)&&-1===t(r[i],n)&&r[i].push(o?n:{listener:n,once:!1});return this},i.on=n("addListener"),i.addOnceListener=function(e,t){return this.addListener(e,{listener:t,once:!0})},i.once=n("addOnceListener"),i.defineEvent=function(e){return this.getListeners(e),this},i.defineEvents=function(e){for(var t=0;e.length>t;t+=1)this.defineEvent(e[t]);return this},i.removeListener=function(e,n){var i,r,o=this.getListenersAsObject(e);for(r in o)o.hasOwnProperty(r)&&(i=t(o[r],n),-1!==i&&o[r].splice(i,1));return this},i.off=n("removeListener"),i.addListeners=function(e,t){return this.manipulateListeners(!1,e,t)},i.removeListeners=function(e,t){return this.manipulateListeners(!0,e,t)},i.manipulateListeners=function(e,t,n){var i,r,o=e?this.removeListener:this.addListener,s=e?this.removeListeners:this.addListeners;if("object"!=typeof t||t instanceof RegExp)for(i=n.length;i--;)o.call(this,t,n[i]);else for(i in t)t.hasOwnProperty(i)&&(r=t[i])&&("function"==typeof r?o.call(this,i,r):s.call(this,i,r));return this},i.removeEvent=function(e){var t,n=typeof e,i=this._getEvents();if("string"===n)delete i[e];else if("object"===n)for(t in i)i.hasOwnProperty(t)&&e.test(t)&&delete i[t];else delete this._events;return this},i.removeAllListeners=n("removeEvent"),i.emitEvent=function(e,t){var n,i,r,o,s=this.getListenersAsObject(e);for(r in s)if(s.hasOwnProperty(r))for(i=s[r].length;i--;)n=s[r][i],n.once===!0&&this.removeListener(e,n.listener),o=n.listener.apply(this,t||[]),o===this._getOnceReturnValue()&&this.removeListener(e,n.listener);return this},i.trigger=n("emitEvent"),i.emit=function(e){var t=Array.prototype.slice.call(arguments,1);return this.emitEvent(e,t)},i.setOnceReturnValue=function(e){return this._onceReturnValue=e,this},i._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},i._getEvents=function(){return this._events||(this._events={})},e.noConflict=function(){return r.EventEmitter=o,e},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return e}):"object"==typeof module&&module.exports?module.exports=e:this.EventEmitter=e}).call(this),function(e){function t(t){var n=e.event;return n.target=n.target||n.srcElement||t,n}var n=document.documentElement,i=function(){};n.addEventListener?i=function(e,t,n){e.addEventListener(t,n,!1)}:n.attachEvent&&(i=function(e,n,i){e[n+i]=i.handleEvent?function(){var n=t(e);i.handleEvent.call(i,n)}:function(){var n=t(e);i.call(e,n)},e.attachEvent("on"+n,e[n+i])});var r=function(){};n.removeEventListener?r=function(e,t,n){e.removeEventListener(t,n,!1)}:n.detachEvent&&(r=function(e,t,n){e.detachEvent("on"+t,e[t+n]);try{delete e[t+n]}catch(i){e[t+n]=void 0}});var o={bind:i,unbind:r};"function"==typeof define&&define.amd?define("eventie/eventie",o):e.eventie=o}(this),function(e,t){"function"==typeof define&&define.amd?define(["eventEmitter/EventEmitter","eventie/eventie"],function(n,i){return t(e,n,i)}):"object"==typeof exports?module.exports=t(e,require("wolfy87-eventemitter"),require("eventie")):e.imagesLoaded=t(e,e.EventEmitter,e.eventie)}(window,function(e,t,n){function i(e,t){for(var n in t)e[n]=t[n];return e}function r(e){return"[object Array]"===d.call(e)}function o(e){var t=[];if(r(e))t=e;else if("number"==typeof e.length)for(var n=0,i=e.length;i>n;n++)t.push(e[n]);else t.push(e);return t}function s(e,t,n){if(!(this instanceof s))return new s(e,t);"string"==typeof e&&(e=document.querySelectorAll(e)),this.elements=o(e),this.options=i({},this.options),"function"==typeof t?n=t:i(this.options,t),n&&this.on("always",n),this.getImages(),a&&(this.jqDeferred=new a.Deferred);var r=this;setTimeout(function(){r.check()})}function f(e){this.img=e}function c(e){this.src=e,v[e]=this}var a=e.jQuery,u=e.console,h=u!==void 0,d=Object.prototype.toString;s.prototype=new t,s.prototype.options={},s.prototype.getImages=function(){this.images=[];for(var e=0,t=this.elements.length;t>e;e++){var n=this.elements[e];"IMG"===n.nodeName&&this.addImage(n);var i=n.nodeType;if(i&&(1===i||9===i||11===i))for(var r=n.querySelectorAll("img"),o=0,s=r.length;s>o;o++){var f=r[o];this.addImage(f)}}},s.prototype.addImage=function(e){var t=new f(e);this.images.push(t)},s.prototype.check=function(){function e(e,r){return t.options.debug&&h&&u.log("confirm",e,r),t.progress(e),n++,n===i&&t.complete(),!0}var t=this,n=0,i=this.images.length;if(this.hasAnyBroken=!1,!i)return this.complete(),void 0;for(var r=0;i>r;r++){var o=this.images[r];o.on("confirm",e),o.check()}},s.prototype.progress=function(e){this.hasAnyBroken=this.hasAnyBroken||!e.isLoaded;var t=this;setTimeout(function(){t.emit("progress",t,e),t.jqDeferred&&t.jqDeferred.notify&&t.jqDeferred.notify(t,e)})},s.prototype.complete=function(){var e=this.hasAnyBroken?"fail":"done";this.isComplete=!0;var t=this;setTimeout(function(){if(t.emit(e,t),t.emit("always",t),t.jqDeferred){var n=t.hasAnyBroken?"reject":"resolve";t.jqDeferred[n](t)}})},a&&(a.fn.imagesLoaded=function(e,t){var n=new s(this,e,t);return n.jqDeferred.promise(a(this))}),f.prototype=new t,f.prototype.check=function(){var e=v[this.img.src]||new c(this.img.src);if(e.isConfirmed)return this.confirm(e.isLoaded,"cached was confirmed"),void 0;if(this.img.complete&&void 0!==this.img.naturalWidth)return this.confirm(0!==this.img.naturalWidth,"naturalWidth"),void 0;var t=this;e.on("confirm",function(e,n){return t.confirm(e.isLoaded,n),!0}),e.check()},f.prototype.confirm=function(e,t){this.isLoaded=e,this.emit("confirm",this,t)};var v={};return c.prototype=new t,c.prototype.check=function(){if(!this.isChecked){var e=new Image;n.bind(e,"load",this),n.bind(e,"error",this),e.src=this.src,this.isChecked=!0}},c.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},c.prototype.onload=function(e){this.confirm(!0,"onload"),this.unbindProxyEvents(e)},c.prototype.onerror=function(e){this.confirm(!1,"onerror"),this.unbindProxyEvents(e)},c.prototype.confirm=function(e,t){this.isConfirmed=!0,this.isLoaded=e,this.emit("confirm",this,t)},c.prototype.unbindProxyEvents=function(e){n.unbind(e.target,"load",this),n.unbind(e.target,"error",this)},s});

(function($){
    "use strict";

var SPU_master = function() {

	var windowHeight 	= $(window).height();
	var isAdmin 		= spuvar.is_admin;
	var $boxes 			= [];

	//remove paddings and margins from first and last items inside box
	$(".spu-content").children().first().css({
		"margin-top": 0,
		"padding-top": 0
	}).end().last().css({
		'margin-bottom': 0,
		'padding-bottom': 0
	});

	// loop through boxes
	$(".spu-box").each(function() {

		// move to parent in safe mode
		if( spuvar.safe_mode ){

			$(this).prependTo('body');

		}

		// vars
		var $box 			= $(this);
		var triggerMethod 	= $box.data('trigger');
		var timer 			= 0;
		var testMode 		= (parseInt($box.data('test-mode')) === 1);
		var id 				= $box.data('box-id');
    var background_close 				= $box.data('close-click-outside');
		var disable_keyboard 				= $box.data('disable-keyboard');
		var autoHide 		= (parseInt($box.data('auto-hide')) === 1);
		var secondsClose    = parseInt($box.data('seconds-close'));
		var triggerSeconds 	= parseInt( $box.data('trigger-number'), 10 );
		var triggerPercentage = ( triggerMethod == 'percentage' ) ? ( parseInt( $box.data('trigger-number'), 10 ) / 100 ) : 0.8;
		var triggerHeight 	= ( triggerPercentage * $(document).height() );

				console.log($box.data('disable-keyboard'));

		facebookFix( $box );

        // Custom links conversion
        $box.on('click', 'a:not(".spu-close-popup, .flp_wrapper a, .spu-not-close")', function(){
            // hide the popup and track conversion
            toggleBox( id, false, true);
        });
		//close with esc
			$(document).keyup(function(e) {
				if(disable_keyboard == 1){
					if (e.keyCode == 27) {
						toggleBox( id, false, false );
					}
				}
			});

		//close on ipads // iphones
		var ua = navigator.userAgent,
		event = (ua.match(/iPad/i) || ua.match(/iPhone/i)) ? "touchstart" : "click";

		$('body').on(event, function (ev) {
			// test that event is user triggered and not programatically
			if( ev.originalEvent !== undefined ) {
				if(background_close == 1){
						toggleBox( id, false, false );
				}
			}
		});
		//not on the box
		$('body' ).on(event,'.spu-box,.spu-clickable', function(event) {
			event.stopPropagation();
		});

		//hide boxes and remove left-99999px we cannot since beggining of facebook won't display
		$box.hide().css('left','');

		// add box to global boxes array
		$boxes[id] = $box;

		// functions that check % of height
		var triggerHeightCheck = function()
		{
			if(timer) {
				clearTimeout(timer);
			}

			timer = window.setTimeout(function() {
				var scrollY = $(window).scrollTop();
				var triggered = ((scrollY + windowHeight) >= triggerHeight);

				// show box when criteria for this box is matched
				if( triggered ) {

					// remove listen event if box shouldn't be hidden again
					if( ! autoHide ) {
						$(window).unbind('scroll', triggerHeightCheck);
					}

					toggleBox( id, true, false );
				} else {
					toggleBox( id, false, false );
				}

			}, 100);
		}
		// function that show popup after X secs
		var triggerSecondsCheck = function()
		{
			if(timer) {
				clearTimeout(timer);
			}

			timer = window.setTimeout(function() {

				toggleBox( id, true, false );

			}, triggerSeconds * 1000);
		}

		// show box if cookie not set or if in test mode
		var cookieValue = spuReadCookie( 'spu_box_' + id );

		if( ( cookieValue == undefined || cookieValue == '' ) || ( isAdmin && testMode ) ) {

			if(triggerMethod == 'seconds') {
				triggerSecondsCheck();
			}
            if(triggerMethod == 'percentage'){
				$(window).bind( 'scroll', triggerHeightCheck );
				// init, check box criteria once
				triggerHeightCheck();
			}

			// shows the box when hash refers to a box
			if(window.location.hash && window.location.hash.length > 0) {

				var hash = window.location.hash;
				var $element;

				if( hash.substring(1) === $box.attr( 'id' ) ) {
					setTimeout(function() {
						toggleBox( id, true, false );
					}, 100);
				}
			}
		}	/* end check cookie */
        //close popup
        $box.on('click','.spu-close-popup',function() {

			// hide box
			toggleBox( id, false, false );

			if(triggerMethod == 'percentage') {
				// unbind
				$(window).unbind( 'scroll', triggerHeightCheck );
			}

		});

		// add link listener for this box
		$(document.body).on('click','a[href="#spu-' + id +'"], .spu-open-' + id ,function(e) {
            e.preventDefault();
			toggleBox(id, true, false);
		});
		$('a[href="#spu-' + id +'"], .spu-open-' + id).css('cursor','pointer').addClass('spu-clickable');

		// add class to the gravity form if they exist within the box
		$box.find('.gform_wrapper form').addClass('gravity-form');
		// same for mc4wp
		$box.find('.mc4wp-form form').addClass('mc4wp-form');
		// same for newsletter plugin
		$box.find('.newsletter form').addClass('newsletter-form');

        // check if we have forms and perform different actions
        var box_form = $box.find('form');
        if( box_form.length ) {
            // Only if form is not a known one disable ajax
            if( ! box_form.is(".newsletter-form, .wpcf7-form, .gravity-form, .infusion-form, .widget_wysija, .ninja-forms-form") ) {
                var action = box_form.attr('action'),
                    pattern = new RegExp(spuvar.site_url, "i");
                if (action && action.length) {
                    if (!pattern.test(action))
                        box_form.addClass('spu-disable-ajax');
                }
            }
            // if spu-disable-ajax is on container add it to form (usp forms for example)
            if( $('.spu-disable-ajax form').length ) {
                $('.spu-disable-ajax form').addClass('spu-disable-ajax');
            }
            // Disable ajax on form by adding .spu-disable-ajax class to it
            $box.on('submit','form.spu-disable-ajax:not(".flp_form")', function(){

                $box.trigger('spu.form_submitted', [id]);
                toggleBox(id, false, true );
            });

            // Add generic form tracking
            $box.on('submit','form:not(".newsletter-form, .wpcf7-form, .gravity-form, .infusion-form, .spu-disable-ajax, .widget_wysija, .ninja-forms-form, .flp_form")', function(e){
                e.preventDefault();


                var submit 	= true,
                    form 		= $(this),
                    data 	 	= form.serialize(),
                    url  	 	= form.hasClass('mc4wp-form') ? spuvar.site_url +'/' : form.attr('action'),
                    error_cb 	= function (data, error, errorThrown){
                        console.log('Spu Form error: ' + error + ' - ' + errorThrown);
                    },
                    success_cb 	= function (data){

                        var response = $(data).filter('#spu-'+ id ).html();
                        $('#spu-' + id ).html(response);

                        // check if an error was returned for m4wp
                        if( ! $('#spu-' + id ).find('.mc4wp-form-error').length ) {

                            // give 2 seconds for response
                            setTimeout( function(){

                                toggleBox(id, false, true );

                            }, spuvar.seconds_confirmation_close * 1000);

                        }
                    };
                // Send form by ajax and replace popup with response
                request(data, url, success_cb, error_cb, 'html');

                $box.trigger('spu.form_submitted', [id]);

                return submit;
            });

            // CF7 support
            $('body').on('mailsent.wpcf7', function(){
                $box.trigger('spu.form_submitted', [id]);
                toggleBox(id, false, true );
            });

            // Gravity forms support (only AJAX mode)
            $(document).on('gform_confirmation_loaded', function(){
                $box.trigger('spu.form_submitted', [id]);
                toggleBox(id, false, true );
            });

            // Infusion Software - not ajax
            $box.on('submit','.infusion-form', function(e){
                e.preventDefault();
                $box.trigger('spu.form_submitted', [id]);
                toggleBox(id, false, true );
                this.submit();
            });
            // The newsletter plugin - not ajax
            $box.on('submit','.newsletter-form', function(e){
                e.preventDefault();
                $box.trigger('spu.form_submitted', [id]);
                toggleBox(id, false, true );
                this.submit();
            });
			// Ninja form - popup not ajax, ajax on ninja form
			$('body').on('submitResponse.default', function(){
				$box.trigger('spu.form_submitted', [id]);
				toggleBox(id, false, true );
			});
        }



    });



	//function that center popup on screen
	function fixSize( id ) {
		var $box 			= $boxes[id];
		var windowWidth 	= $(window).width();
		var windowHeight 	= $(window).height();
		var popupHeight 	= $box.outerHeight();
		var popupWidth 		= $box.outerWidth();
		var intentWidth		= $box.data('width');
		var left 			= 0;
		var top 			= windowHeight / 2 - popupHeight / 2;
		var position 		= 'fixed';
		var currentScroll   = $(document).scrollTop();

		if( $box.hasClass('spu-centered') ){
			if( intentWidth < windowWidth ) {
				left = windowWidth / 2 - popupWidth / 2;
			}
			$box.css({
				"left": 	left,
				"position": position,
				"top": 		top,
			});
		}

		// if popup is higher than viewport we need to make it absolute
		if( (popupHeight + 50) > windowHeight ) {
			position 	= 'absolute';
			top 		= currentScroll;

			$box.css({
				"position": position,
				"top": 		top,
				"bottom": 	"auto",
				//"right": 	"auto",
				//"left": 	"auto",
			});
		}

	}

	//facebookBugFix
	function facebookFix( box ) {

		// Facebook bug that fails to resize
		var $fbbox = $(box).find('.spu-facebook');
		if( $fbbox.length ){
			//if exist and width is 0
			var $fbwidth = $fbbox.find('.fb-like > span').width();
			if ( $fbwidth == 0 ) {
				var $fblayout = $fbbox.find('.fb-like').data('layout');
				 if( $fblayout == 'box_count' ) {

				 	$fbbox.append('<style type="text/css"> #'+$(box).attr('id')+' .fb-like iframe, #'+$(box).attr('id')+' .fb_iframe_widget span, #'+$(box).attr('id')+' .fb_iframe_widget{ height: 63px !important;width: 80px !important;}</style>');

				 } else if( $fblayout == 'button_count' ) {

					$fbbox.append('<style type="text/css"> #'+$(box).attr('id')+' .fb-like iframe, #'+$(box).attr('id')+' .fb_iframe_widget span, #'+$(box).attr('id')+' .fb_iframe_widget{ height: 20px !important;min-width: 120px !important;}</style>');

				 } else {

					$fbbox.append('<style type="text/css"> #'+$(box).attr('id')+' .fb-like iframe, #'+$(box).attr('id')+' .fb_iframe_widget span, #'+$(box).attr('id')+' .fb_iframe_widget{ height: 20px !important;width: 80px !important;}</style>');

				 }
			}
		}
	}

    /**
     * Check all shortcodes and automatically center them
     * @param box
     */
    function centerShortcodes( box ){
        var $box 	= box;
        var total = $box.data('total'); //total of shortcodes used
        if( total ) { //if we have shortcodes
            SPU_reload_socials();

            //wrap them all
            //center spu-shortcodes
            var swidth = 0;
            var free_width = 0;
            var boxwidth = $box.outerWidth();
            var cwidth = $box.find(".spu-content").width();
            if (!spuvar.disable_style && $(window).width() > boxwidth) {
                $box.find(".spu-shortcode").wrapAll('<div class="spu_shortcodes"/>');
                //calculate total width of shortcodes all togheter
                $box.find(".spu-shortcode").each(function () {
                    swidth = swidth + $(this).outerWidth();
                });
                //available space to split margins
                free_width = cwidth - swidth - (total*20);

            }
            if (free_width > 0) {
                //leave some margin
                $box.find(".spu-shortcode").each(function () {

                    $(this).css('margin-left', (free_width / 2 ));

                });
                //remove margin when neccesary
                if (total == 2) {

                    $box.find(".spu-shortcode").last().css('margin-left', 0);

                } else if (total == 3) {

                    $box.find(".spu-shortcode").first().css('margin-left', 0);

                }
            }
        }
    }
    /**
     * Main function to show or hide the popup
     * @param id int box id
     * @param show boolean it's hiding or showing?
     * @param conversion boolean - Its a conversion or we are just closing
     * @returns {*}
     */
    function toggleBox( id, show, conversion ) {
		var $box 	= $boxes[id];
		var $bg	 	= $('#spu-bg-'+id);
		var $bgopa 	= $box.data('bgopa');

		// don't do anything if box is undergoing an animation
		if( $box.is( ":animated" ) ) {
			return false;
		}

		// is box already at desired visibility?
		if( ( show === true && $box.is( ":visible" ) ) || ( show === false && $box.is( ":hidden" ) ) ) {
			return false;
		}

		//if we are closing , set cookie
		if( show === false) {
			// set cookie
			var days = parseInt( $box.data('close-cookie') );
			if( conversion === true )
				days = parseInt( $box.data('cookie') );

			if( days > 0 ) {
				spuCreateCookie( 'spu_box_' + id, true, days );
			}
            $box.trigger('spu.box_close', [id]);
		} else {
            setTimeout(function(){
                centerShortcodes($box);
            },1500);
            $box.trigger('spu.box_open', [id]);
			//bind for resize
			$(window).resize(function(){

				fixSize( id );

			});
			fixSize( id );

		}

		// show box
		var animation = $box.data('spuanimation'),
            conversion_close = $box.data('close-on-conversion');


        if (animation === 'fade') {
            if (show === true) {
                $box.fadeIn('slow');
            } else if (show === false && ( (conversion_close && conversion ) || !conversion )  ) {
                    $box.fadeOut('slow');
            }
        } else {
            if (show === true ) {
                $box.slideDown('slow');
            } else if (show === false && ( (conversion_close && conversion ) || !conversion )  ) {
                $box.slideUp('slow');
            }
        }

        //background
        if (show === true && $bgopa > 0) {
            $bg.fadeIn();
        } else if (show === false && ( (conversion_close && conversion ) || !conversion ) ) {
            $bg.fadeOut();
        }

		return show;
	}

	return {
		show: function( box_id ) {
			return toggleBox( box_id, true, false );
		},
		hide: function( box_id, show, conversion ) {
			return toggleBox( box_id, false, conversion );
		},
		request: function( data, url, success_cb, error_cb ) {
			return request( data, url, success_cb, error_cb );
		}
	}

}
if( spuvar.ajax_mode ) {

    var data = {
        pid : spuvar.pid,
        referrer : document.referrer,
        query_string : document.location.search,
        is_category : spuvar.is_category,
        is_archive : spuvar.is_archive
    }
    ,success_cb = function(response) {

    	$('body').append(response);
        $(".spu-box").imagesLoaded( function() {
            window.SPU = SPU_master();
            SPU_reload_forms(); //remove spu_Action from forms
        });
    },
    error_cb 	= function (data, error, errorThrown){
        console.log('Problem loading popups - error: ' + error + ' - ' + errorThrown);
    }
    request(data, spuvar.ajax_mode_url , success_cb, error_cb, 'html');
} else {
	$(".spu-box").imagesLoaded( function(){
        window.SPU = SPU_master();
    });
}

    /**
     * Ajax requests
     * @param data
     * @param url
     * @param success_cb
     * @param error_cb
     * @param dataType
     */
    function request(data, url, success_cb, error_cb, dataType){
        // Prepare variables.
        var ajax       = {
                url:      spuvar.ajax_url,
                data:     data,
                cache:    false,
                type:     'POST',
                dataType: 'json',
                timeout:  30000
            },
            dataType   = dataType || false,
            success_cb = success_cb || false,
            error_cb   = error_cb   || false;

        // Set ajax url is supplied
        if ( url ) {
            ajax.url = url;
        }
        // Set success callback if supplied.
        if ( success_cb ) {
            ajax.success = success_cb;
        }

        // Set error callback if supplied.
        if ( error_cb ) {
            ajax.error = error_cb;
        }

        // Change dataType if supplied.
        if ( dataType ) {
            ajax.dataType = dataType;
        }
        // Make the ajax request.
        $.ajax(ajax);

    }
/**
 * Cookie functions
 */
function spuCreateCookie(name, value, days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		var expires = "; expires=" + date.toGMTString();
	} else var expires = "";
	document.cookie = name + "=" + value + expires + "; path=/";
}

function spuReadCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
	}
	return null;
}

/**
 * Social Callbacks
 */
var SPUfb = false;

var FbTimer = setInterval(function(){
	if( typeof FB !== 'undefined' && ! SPUfb) {
		subscribeFbEvent();

	}
},1000);

if ( typeof twttr !== 'undefined') {
    try{
        twttr.ready(function(twttr) {
            twttr.events.bind('tweet', twitterCB);
            twttr.events.bind('follow', twitterCB);
        });
    }catch(ex){}
}


function subscribeFbEvent(){
    try {
        FB.Event.subscribe('edge.create', function (href, html_element) {
            var box_id = $(html_element).parents('.spu-box').data('box-id');
            if (box_id) {
                SPU.hide(box_id, false, true);
            }
        });
    }catch(ex){}
	SPUfb = true;
	clearInterval(FbTimer);
}
function twitterCB(intent_event) {

	var box_id = $(intent_event.target).parents('.spu-box').data('box-id');

	if( box_id) {
		SPU.hide(box_id, false, true);
	}
}
function googleCB(a) {

	if( "on" == a.state ) {

		var box_id = jQuery('.spu-gogl').data('box-id');
		if( box_id) {
			SPU.hide(box_id, false, true);
		}
	}
}
function closeGoogle(a){
	if( "confirm" == a.type )
	{
		var box_id = jQuery('.spu-gogl').data('box-id');
		if( box_id) {
			SPU.hide(box_id, false, true);

		}
	}
}
function SPU_reload_socials(){
	if( typeof spuvar_social != 'undefined' && spuvar_social.facebook) {

		// reload fb
		try{
			FB.XFBML.parse();
		}catch(ex){}
	}
	if( typeof spuvar_social != 'undefined' && spuvar_social.google){
        try {
            // reload google
            gapi.plusone.go();
        }catch(ex){}
	}
	if( typeof spuvar_social != 'undefined' && spuvar_social.twitter ) {
        try {
            //reload twitter
            twttr.widgets.load();
        }catch(ex){}
	}
}
function SPU_reload_forms(){
	// Clear actions
	$('.spu-box form').each( function(){
		var action = $(this).attr('action');
        if( action ){
            $(this).attr('action' , action.replace('?spu_action=spu_load',''));
        }
	});
	if ($.fn.wpcf7InitForm) {
		$('.spu-box div.wpcf7 > form').wpcf7InitForm();
	}
}
})(jQuery);

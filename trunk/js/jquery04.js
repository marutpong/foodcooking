/* ------------------------------------------------------------------------
	Class: prettyPhoto
	Use: Lightbox clone for jQuery
	Author: Stephane Caron (http://www.no-margin-for-errors.com)
	Version: 3.1.3
------------------------------------------------------------------------- */

(function($){$.prettyPhoto={version:'3.1.3'};$.fn.prettyPhoto=function(pp_settings){pp_settings=jQuery.extend({animation_speed:'fast',slideshow:5000,autoplay_slideshow:false,opacity:0.80,show_title:true,allow_resize:true,default_width:500,default_height:344,counter_separator_label:'/',theme:'pp_default',horizontal_padding:20,hideflash:false,wmode:'opaque',autoplay:true,modal:false,deeplinking:true,overlay_gallery:true,keyboard_shortcuts:true,changepicturecallback:function(){},callback:function(){},ie6_fallback:true,markup:'<div class="pp_pic_holder"> \
      <div class="ppt">&nbsp;</div> \
      <div class="pp_top"> \
       <div class="pp_left"></div> \
       <div class="pp_middle"></div> \
       <div class="pp_right"></div> \
      </div> \
      <div class="pp_content_container"> \
       <div class="pp_left"> \
       <div class="pp_right"> \
        <div class="pp_content"> \
         <div class="pp_loaderIcon"></div> \
         <div class="pp_fade"> \
          <a href="#" class="pp_expand" title="Expand the image"></a> \
          <div class="pp_hoverContainer"> \
           <a class="pp_next" href="#"></a> \
           <a class="pp_previous" href="#"></a> \
          </div> \
          <div id="pp_full_res"></div> \
          <div class="pp_details"> \
           <div class="pp_nav"> \
            <a href="#" class="pp_arrow_previous"></a> \
            <p class="currentTextHolder">0/0</p> \
            <a href="#" class="pp_arrow_next"></a> \
           </div> \
           <p class="pp_description"></p> \
           <div class="pp_social">{pp_social}</div> \
           <a class="pp_close" href="#"></a> \
          </div> \
         </div> \
        </div> \
       </div> \
       </div> \
      </div> \
      <div class="pp_bottom"> \
       <div class="pp_left"></div> \
       <div class="pp_middle"></div> \
       <div class="pp_right"></div> \
      </div> \
     </div> \
     <div class="pp_overlay"></div>',gallery_markup:'<div class="pp_gallery"> \
        <a href="#" class="pp_arrow_previous"></a> \
        <div> \
         <ul> \
          {gallery} \
         </ul> \
        </div> \
        <a href="#" class="pp_arrow_next"></a> \
       </div>',image_markup:'<img id="fullResImage" src="{path}" />',flash_markup:'<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="{width}" height="{height}"><param name="wmode" value="{wmode}" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="{path}" /><embed src="{path}" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="{width}" height="{height}" wmode="{wmode}"></embed></object>',quicktime_markup:'<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" height="{height}" width="{width}"><param name="src" value="{path}"><param name="autoplay" value="{autoplay}"><param name="type" value="video/quicktime"><embed src="{path}" height="{height}" width="{width}" autoplay="{autoplay}" type="video/quicktime" pluginspage="http://www.apple.com/quicktime/download/"></embed></object>',iframe_markup:'<iframe src ="{path}" width="{width}" height="{height}" frameborder="no"></iframe>',inline_markup:'<div class="pp_inline">{content}</div>',custom_markup:''},pp_settings);var matchedObjects=this,percentBased=false,pp_dimensions,pp_open,pp_contentHeight,pp_contentWidth,pp_containerHeight,pp_containerWidth,windowHeight=$(window).height(),windowWidth=$(window).width(),pp_slideshow;doresize=true,scroll_pos=_get_scroll();$(window).unbind('resize.prettyphoto').bind('resize.prettyphoto',function(){_center_overlay();_resize_overlay();});if(pp_settings.keyboard_shortcuts){$(document).unbind('keydown.prettyphoto').bind('keydown.prettyphoto',function(e){if(typeof $pp_pic_holder!='undefined'){if($pp_pic_holder.is(':visible')){switch(e.keyCode){case 37:$.prettyPhoto.changePage('previous');e.preventDefault();break;case 39:$.prettyPhoto.changePage('next');e.preventDefault();break;case 27:if(!settings.modal)
$.prettyPhoto.close();e.preventDefault();break;};};};});};$.prettyPhoto.initialize=function(){settings=pp_settings;if(settings.theme=='pp_default')settings.horizontal_padding=16;if(settings.ie6_fallback&&$.browser.msie&&parseInt($.browser.version)==6)settings.theme="light_square";theRel=$(this).attr('rel');galleryRegExp=/\[(?:.*)\]/;isSet=(galleryRegExp.exec(theRel))?true:false;pp_images=(isSet)?jQuery.map(matchedObjects,function(n,i){if($(n).attr('rel').indexOf(theRel)!=-1)return $(n).attr('href');}):$.makeArray($(this).attr('href'));pp_titles=(isSet)?jQuery.map(matchedObjects,function(n,i){if($(n).attr('rel').indexOf(theRel)!=-1)return($(n).find('img').attr('alt'))?$(n).find('img').attr('alt'):"";}):$.makeArray($(this).find('img').attr('alt'));pp_descriptions=(isSet)?jQuery.map(matchedObjects,function(n,i){if($(n).attr('rel').indexOf(theRel)!=-1)return($(n).attr('title'))?$(n).attr('title'):"";}):$.makeArray($(this).attr('title'));if(pp_images.length>30)settings.overlay_gallery=false;set_position=jQuery.inArray($(this).attr('href'),pp_images);rel_index=(isSet)?set_position:$("a[rel^='"+theRel+"']").index($(this));_build_overlay(this);if(settings.allow_resize)
$(window).bind('scroll.prettyphoto',function(){_center_overlay();});$.prettyPhoto.open();return false;}
$.prettyPhoto.open=function(event){if(typeof settings=="undefined"){settings=pp_settings;if($.browser.msie&&$.browser.version==6)settings.theme="light_square";pp_images=$.makeArray(arguments[0]);pp_titles=(arguments[1])?$.makeArray(arguments[1]):$.makeArray("");pp_descriptions=(arguments[2])?$.makeArray(arguments[2]):$.makeArray("");isSet=(pp_images.length>1)?true:false;set_position=0;_build_overlay(event.target);}
if($.browser.msie&&$.browser.version==6)$('select').css('visibility','hidden');if(settings.hideflash)$('object,embed,iframe[src*=youtube],iframe[src*=vimeo]').css('visibility','hidden');_checkPosition($(pp_images).size());$('.pp_loaderIcon').show();if(settings.deeplinking)
setHashtag();if(settings.social_tools){facebook_like_link=settings.social_tools.replace('{location_href}',encodeURIComponent(location.href));$pp_pic_holder.find('.pp_social').html(facebook_like_link);}
if($ppt.is(':hidden'))$ppt.css('opacity',0).show();$pp_overlay.show().fadeTo(settings.animation_speed,settings.opacity);$pp_pic_holder.find('.currentTextHolder').text((set_position+1)+settings.counter_separator_label+$(pp_images).size());if(pp_descriptions[set_position]!=""){$pp_pic_holder.find('.pp_description').show().html(unescape(pp_descriptions[set_position]));}else{$pp_pic_holder.find('.pp_description').hide();}
movie_width=(parseFloat(getParam('width',pp_images[set_position])))?getParam('width',pp_images[set_position]):settings.default_width.toString();movie_height=(parseFloat(getParam('height',pp_images[set_position])))?getParam('height',pp_images[set_position]):settings.default_height.toString();percentBased=false;if(movie_height.indexOf('%')!=-1){movie_height=parseFloat(($(window).height()*parseFloat(movie_height)/100)-150);percentBased=true;}
if(movie_width.indexOf('%')!=-1){movie_width=parseFloat(($(window).width()*parseFloat(movie_width)/100)-150);percentBased=true;}
$pp_pic_holder.fadeIn(function(){(settings.show_title&&pp_titles[set_position]!=""&&typeof pp_titles[set_position]!="undefined")?$ppt.html(unescape(pp_titles[set_position])):$ppt.html('&nbsp;');imgPreloader="";skipInjection=false;switch(_getFileType(pp_images[set_position])){case'image':imgPreloader=new Image();nextImage=new Image();if(isSet&&set_position<$(pp_images).size()-1)nextImage.src=pp_images[set_position+1];prevImage=new Image();if(isSet&&pp_images[set_position-1])prevImage.src=pp_images[set_position-1];$pp_pic_holder.find('#pp_full_res')[0].innerHTML=settings.image_markup.replace(/{path}/g,pp_images[set_position]);imgPreloader.onload=function(){pp_dimensions=_fitToViewport(imgPreloader.width,imgPreloader.height);_showContent();};imgPreloader.onerror=function(){alert('Image cannot be loaded. Make sure the path is correct and image exist.');$.prettyPhoto.close();};imgPreloader.src=pp_images[set_position];break;case'youtube':pp_dimensions=_fitToViewport(movie_width,movie_height);movie_id=getParam('v',pp_images[set_position]);if(movie_id==""){movie_id=pp_images[set_position].split('youtu.be/');movie_id=movie_id[1];if(movie_id.indexOf('?')>0)
movie_id=movie_id.substr(0,movie_id.indexOf('?'));if(movie_id.indexOf('&')>0)
movie_id=movie_id.substr(0,movie_id.indexOf('&'));}
movie='http://www.youtube.com/embed/'+movie_id;(getParam('rel',pp_images[set_position]))?movie+="?rel="+getParam('rel',pp_images[set_position]):movie+="?rel=1";if(settings.autoplay)movie+="&autoplay=1";toInject=settings.iframe_markup.replace(/{width}/g,pp_dimensions['width']).replace(/{height}/g,pp_dimensions['height']).replace(/{wmode}/g,settings.wmode).replace(/{path}/g,movie);break;case'vimeo':pp_dimensions=_fitToViewport(movie_width,movie_height);movie_id=pp_images[set_position];var regExp=/http:\/\/(www\.)?vimeo.com\/(\d+)/;var match=movie_id.match(regExp);movie='http://player.vimeo.com/video/'+match[2]+'?title=0&amp;byline=0&amp;portrait=0';if(settings.autoplay)movie+="&autoplay=1;";vimeo_width=pp_dimensions['width']+'/embed/?moog_width='+pp_dimensions['width'];toInject=settings.iframe_markup.replace(/{width}/g,vimeo_width).replace(/{height}/g,pp_dimensions['height']).replace(/{path}/g,movie);break;case'quicktime':pp_dimensions=_fitToViewport(movie_width,movie_height);pp_dimensions['height']+=15;pp_dimensions['contentHeight']+=15;pp_dimensions['containerHeight']+=15;toInject=settings.quicktime_markup.replace(/{width}/g,pp_dimensions['width']).replace(/{height}/g,pp_dimensions['height']).replace(/{wmode}/g,settings.wmode).replace(/{path}/g,pp_images[set_position]).replace(/{autoplay}/g,settings.autoplay);break;case'flash':pp_dimensions=_fitToViewport(movie_width,movie_height);flash_vars=pp_images[set_position];flash_vars=flash_vars.substring(pp_images[set_position].indexOf('flashvars')+10,pp_images[set_position].length);filename=pp_images[set_position];filename=filename.substring(0,filename.indexOf('?'));toInject=settings.flash_markup.replace(/{width}/g,pp_dimensions['width']).replace(/{height}/g,pp_dimensions['height']).replace(/{wmode}/g,settings.wmode).replace(/{path}/g,filename+'?'+flash_vars);break;case'iframe':pp_dimensions=_fitToViewport(movie_width,movie_height);frame_url=pp_images[set_position];frame_url=frame_url.substr(0,frame_url.indexOf('iframe')-1);toInject=settings.iframe_markup.replace(/{width}/g,pp_dimensions['width']).replace(/{height}/g,pp_dimensions['height']).replace(/{path}/g,frame_url);break;case'ajax':doresize=false;pp_dimensions=_fitToViewport(movie_width,movie_height);doresize=true;skipInjection=true;$.get(pp_images[set_position],function(responseHTML){toInject=settings.inline_markup.replace(/{content}/g,responseHTML);$pp_pic_holder.find('#pp_full_res')[0].innerHTML=toInject;_showContent();});break;case'custom':pp_dimensions=_fitToViewport(movie_width,movie_height);toInject=settings.custom_markup;break;case'inline':myClone=$(pp_images[set_position]).clone().append('<br clear="all" />').css({'width':settings.default_width}).wrapInner('<div id="pp_full_res"><div class="pp_inline"></div></div>').appendTo($('body')).show();doresize=false;pp_dimensions=_fitToViewport($(myClone).width(),$(myClone).height());doresize=true;$(myClone).remove();toInject=settings.inline_markup.replace(/{content}/g,$(pp_images[set_position]).html());break;};if(!imgPreloader&&!skipInjection){$pp_pic_holder.find('#pp_full_res')[0].innerHTML=toInject;_showContent();};});return false;};$.prettyPhoto.changePage=function(direction){currentGalleryPage=0;if(direction=='previous'){set_position--;if(set_position<0)set_position=$(pp_images).size()-1;}else if(direction=='next'){set_position++;if(set_position>$(pp_images).size()-1)set_position=0;}else{set_position=direction;};rel_index=set_position;if(!doresize)doresize=true;$('.pp_contract').removeClass('pp_contract').addClass('pp_expand');_hideContent(function(){$.prettyPhoto.open();});};$.prettyPhoto.changeGalleryPage=function(direction){if(direction=='next'){currentGalleryPage++;if(currentGalleryPage>totalPage)currentGalleryPage=0;}else if(direction=='previous'){currentGalleryPage--;if(currentGalleryPage<0)currentGalleryPage=totalPage;}else{currentGalleryPage=direction;};slide_speed=(direction=='next'||direction=='previous')?settings.animation_speed:0;slide_to=currentGalleryPage*(itemsPerPage*itemWidth);$pp_gallery.find('ul').animate({left:-slide_to},slide_speed);};$.prettyPhoto.startSlideshow=function(){if(typeof pp_slideshow=='undefined'){$pp_pic_holder.find('.pp_play').unbind('click').removeClass('pp_play').addClass('pp_pause').click(function(){$.prettyPhoto.stopSlideshow();return false;});pp_slideshow=setInterval($.prettyPhoto.startSlideshow,settings.slideshow);}else{$.prettyPhoto.changePage('next');};}
$.prettyPhoto.stopSlideshow=function(){$pp_pic_holder.find('.pp_pause').unbind('click').removeClass('pp_pause').addClass('pp_play').click(function(){$.prettyPhoto.startSlideshow();return false;});clearInterval(pp_slideshow);pp_slideshow=undefined;}
$.prettyPhoto.close=function(){if($pp_overlay.is(":animated"))return;$.prettyPhoto.stopSlideshow();$pp_pic_holder.stop().find('object,embed').css('visibility','hidden');$('div.pp_pic_holder,div.ppt,.pp_fade').fadeOut(settings.animation_speed,function(){$(this).remove();});$pp_overlay.fadeOut(settings.animation_speed,function(){if($.browser.msie&&$.browser.version==6)$('select').css('visibility','visible');if(settings.hideflash)$('object,embed,iframe[src*=youtube],iframe[src*=vimeo]').css('visibility','visible');$(this).remove();$(window).unbind('scroll.prettyphoto');clearHashtag();settings.callback();doresize=true;pp_open=false;delete settings;});};function _showContent(){$('.pp_loaderIcon').hide();projectedTop=scroll_pos['scrollTop']+((windowHeight/2)-(pp_dimensions['containerHeight']/2));if(projectedTop<0)projectedTop=0;$ppt.fadeTo(settings.animation_speed,1);$pp_pic_holder.find('.pp_content').animate({height:pp_dimensions['contentHeight'],width:pp_dimensions['contentWidth']},settings.animation_speed);$pp_pic_holder.animate({'top':projectedTop,'left':(windowWidth/2)-(pp_dimensions['containerWidth']/2),width:pp_dimensions['containerWidth']},settings.animation_speed,function(){$pp_pic_holder.find('.pp_hoverContainer,#fullResImage').height(pp_dimensions['height']).width(pp_dimensions['width']);$pp_pic_holder.find('.pp_fade').fadeIn(settings.animation_speed);if(isSet&&_getFileType(pp_images[set_position])=="image"){$pp_pic_holder.find('.pp_hoverContainer').show();}else{$pp_pic_holder.find('.pp_hoverContainer').hide();}
if(pp_dimensions['resized']){$('a.pp_expand,a.pp_contract').show();}else{$('a.pp_expand').hide();}
if(settings.autoplay_slideshow&&!pp_slideshow&&!pp_open)$.prettyPhoto.startSlideshow();settings.changepicturecallback();pp_open=true;});_insert_gallery();};function _hideContent(callback){$pp_pic_holder.find('#pp_full_res object,#pp_full_res embed').css('visibility','hidden');$pp_pic_holder.find('.pp_fade').fadeOut(settings.animation_speed,function(){$('.pp_loaderIcon').show();callback();});};function _checkPosition(setCount){(setCount>1)?$('.pp_nav').show():$('.pp_nav').hide();};function _fitToViewport(width,height){resized=false;_getDimensions(width,height);imageWidth=width,imageHeight=height;if(((pp_containerWidth>windowWidth)||(pp_containerHeight>windowHeight))&&doresize&&settings.allow_resize&&!percentBased){resized=true,fitting=false;while(!fitting){if((pp_containerWidth>windowWidth)){imageWidth=(windowWidth-200);imageHeight=(height/width)*imageWidth;}else if((pp_containerHeight>windowHeight)){imageHeight=(windowHeight-200);imageWidth=(width/height)*imageHeight;}else{fitting=true;};pp_containerHeight=imageHeight,pp_containerWidth=imageWidth;};_getDimensions(imageWidth,imageHeight);if((pp_containerWidth>windowWidth)||(pp_containerHeight>windowHeight)){_fitToViewport(pp_containerWidth,pp_containerHeight)};};return{width:Math.floor(imageWidth),height:Math.floor(imageHeight),containerHeight:Math.floor(pp_containerHeight),containerWidth:Math.floor(pp_containerWidth)+(settings.horizontal_padding*2),contentHeight:Math.floor(pp_contentHeight),contentWidth:Math.floor(pp_contentWidth),resized:resized};};function _getDimensions(width,height){width=parseFloat(width);height=parseFloat(height);$pp_details=$pp_pic_holder.find('.pp_details');$pp_details.width(width);detailsHeight=parseFloat($pp_details.css('marginTop'))+parseFloat($pp_details.css('marginBottom'));$pp_details=$pp_details.clone().addClass(settings.theme).width(width).appendTo($('body')).css({'position':'absolute','top':-10000});detailsHeight+=$pp_details.height();detailsHeight=(detailsHeight<=34)?36:detailsHeight;if($.browser.msie&&$.browser.version==7)detailsHeight+=8;$pp_details.remove();$pp_title=$pp_pic_holder.find('.ppt');$pp_title.width(width);titleHeight=parseFloat($pp_title.css('marginTop'))+parseFloat($pp_title.css('marginBottom'));$pp_title=$pp_title.clone().appendTo($('body')).css({'position':'absolute','top':-10000});titleHeight+=$pp_title.height();$pp_title.remove();pp_contentHeight=height+detailsHeight;pp_contentWidth=width;pp_containerHeight=pp_contentHeight+titleHeight+$pp_pic_holder.find('.pp_top').height()+$pp_pic_holder.find('.pp_bottom').height();pp_containerWidth=width;}
function _getFileType(itemSrc){if(itemSrc.match(/youtube\.com\/watch/i)||itemSrc.match(/youtu\.be/i)){return'youtube';}else if(itemSrc.match(/vimeo\.com/i)){return'vimeo';}else if(itemSrc.match(/\b.mov\b/i)){return'quicktime';}else if(itemSrc.match(/\b.swf\b/i)){return'flash';}else if(itemSrc.match(/\biframe=true\b/i)){return'iframe';}else if(itemSrc.match(/\bajax=true\b/i)){return'ajax';}else if(itemSrc.match(/\bcustom=true\b/i)){return'custom';}else if(itemSrc.substr(0,1)=='#'){return'inline';}else{return'image';};};function _center_overlay(){if(doresize&&typeof $pp_pic_holder!='undefined'){scroll_pos=_get_scroll();contentHeight=$pp_pic_holder.height(),contentwidth=$pp_pic_holder.width();projectedTop=(windowHeight/2)+scroll_pos['scrollTop']-(contentHeight/2);if(projectedTop<0)projectedTop=0;if(contentHeight>windowHeight)
return;$pp_pic_holder.css({'top':projectedTop,'left':(windowWidth/2)+scroll_pos['scrollLeft']-(contentwidth/2)});};};function _get_scroll(){if(self.pageYOffset){return{scrollTop:self.pageYOffset,scrollLeft:self.pageXOffset};}else if(document.documentElement&&document.documentElement.scrollTop){return{scrollTop:document.documentElement.scrollTop,scrollLeft:document.documentElement.scrollLeft};}else if(document.body){return{scrollTop:document.body.scrollTop,scrollLeft:document.body.scrollLeft};};};function _resize_overlay(){windowHeight=$(window).height(),windowWidth=$(window).width();if(typeof $pp_overlay!="undefined")$pp_overlay.height($(document).height()).width(windowWidth);};function _insert_gallery(){if(isSet&&settings.overlay_gallery&&_getFileType(pp_images[set_position])=="image"&&(settings.ie6_fallback&&!($.browser.msie&&parseInt($.browser.version)==6))){itemWidth=52+5;navWidth=(settings.theme=="facebook"||settings.theme=="pp_default")?50:30;itemsPerPage=Math.floor((pp_dimensions['containerWidth']-100-navWidth)/itemWidth);itemsPerPage=(itemsPerPage<pp_images.length)?itemsPerPage:pp_images.length;totalPage=Math.ceil(pp_images.length/itemsPerPage)-1;if(totalPage==0){navWidth=0;$pp_gallery.find('.pp_arrow_next,.pp_arrow_previous').hide();}else{$pp_gallery.find('.pp_arrow_next,.pp_arrow_previous').show();};galleryWidth=itemsPerPage*itemWidth;fullGalleryWidth=pp_images.length*itemWidth;$pp_gallery.css('margin-left',-((galleryWidth/2)+(navWidth/2))).find('div:first').width(galleryWidth+5).find('ul').width(fullGalleryWidth).find('li.selected').removeClass('selected');goToPage=(Math.floor(set_position/itemsPerPage)<totalPage)?Math.floor(set_position/itemsPerPage):totalPage;$.prettyPhoto.changeGalleryPage(goToPage);$pp_gallery_li.filter(':eq('+set_position+')').addClass('selected');}else{$pp_pic_holder.find('.pp_content').unbind('mouseenter mouseleave');}}
function _build_overlay(caller){if(settings.social_tools)
facebook_like_link=settings.social_tools.replace('{location_href}',encodeURIComponent(location.href));settings.markup=settings.markup.replace('{pp_social}',(settings.social_tools)?facebook_like_link:'');$('body').append(settings.markup);$pp_pic_holder=$('.pp_pic_holder'),$ppt=$('.ppt'),$pp_overlay=$('div.pp_overlay');if(isSet&&settings.overlay_gallery){currentGalleryPage=0;toInject="";for(var i=0;i<pp_images.length;i++){if(!pp_images[i].match(/\b(jpg|jpeg|png|gif)\b/gi)){classname='default';img_src='';}else{classname='';img_src=pp_images[i];}
toInject+="<li class='"+classname+"'><a href='#'><img src='"+img_src+"' width='50' alt='' /></a></li>";};toInject=settings.gallery_markup.replace(/{gallery}/g,toInject);$pp_pic_holder.find('#pp_full_res').after(toInject);$pp_gallery=$('.pp_pic_holder .pp_gallery'),$pp_gallery_li=$pp_gallery.find('li');$pp_gallery.find('.pp_arrow_next').click(function(){$.prettyPhoto.changeGalleryPage('next');$.prettyPhoto.stopSlideshow();return false;});$pp_gallery.find('.pp_arrow_previous').click(function(){$.prettyPhoto.changeGalleryPage('previous');$.prettyPhoto.stopSlideshow();return false;});$pp_pic_holder.find('.pp_content').hover(function(){$pp_pic_holder.find('.pp_gallery:not(.disabled)').fadeIn();},function(){$pp_pic_holder.find('.pp_gallery:not(.disabled)').fadeOut();});itemWidth=52+5;$pp_gallery_li.each(function(i){$(this).find('a').click(function(){$.prettyPhoto.changePage(i);$.prettyPhoto.stopSlideshow();return false;});});};if(settings.slideshow){$pp_pic_holder.find('.pp_nav').prepend('<a href="#" class="pp_play"></a>')
$pp_pic_holder.find('.pp_nav .pp_play').click(function(){$.prettyPhoto.startSlideshow();return false;});}
$pp_pic_holder.attr('class','pp_pic_holder '+settings.theme);$pp_overlay.css({'opacity':0,'height':$(document).height(),'width':$(window).width()}).bind('click',function(){if(!settings.modal)$.prettyPhoto.close();});$('a.pp_close').bind('click',function(){$.prettyPhoto.close();return false;});$('a.pp_expand').bind('click',function(e){if($(this).hasClass('pp_expand')){$(this).removeClass('pp_expand').addClass('pp_contract');doresize=false;}else{$(this).removeClass('pp_contract').addClass('pp_expand');doresize=true;};_hideContent(function(){$.prettyPhoto.open();});return false;});$pp_pic_holder.find('.pp_previous, .pp_nav .pp_arrow_previous').bind('click',function(){$.prettyPhoto.changePage('previous');$.prettyPhoto.stopSlideshow();return false;});$pp_pic_holder.find('.pp_next, .pp_nav .pp_arrow_next').bind('click',function(){$.prettyPhoto.changePage('next');$.prettyPhoto.stopSlideshow();return false;});_center_overlay();};if(!pp_alreadyInitialized&&getHashtag()){pp_alreadyInitialized=true;hashIndex=getHashtag();hashRel=hashIndex;hashIndex=hashIndex.substring(hashIndex.indexOf('/')+1,hashIndex.length-1);hashRel=hashRel.substring(0,hashRel.indexOf('/'));setTimeout(function(){$("a[rel^='"+hashRel+"']:eq("+hashIndex+")").trigger('click');},50);}
return this.unbind('click.prettyphoto').bind('click.prettyphoto',$.prettyPhoto.initialize);};function getHashtag(){url=location.href;hashtag=(url.indexOf('#!')!=-1)?decodeURI(url.substring(url.indexOf('#!')+2,url.length)):false;return hashtag;};function setHashtag(){if(typeof theRel=='undefined')return;location.hash='!'+theRel+'/'+rel_index+'/';};function clearHashtag(){url=location.href;hashtag=(url.indexOf('#!'))?true:false;if(hashtag)location.hash="";}
function getParam(name,url){name=name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");var regexS="[\\?&]"+name+"=([^&#]*)";var regex=new RegExp(regexS);var results=regex.exec(url);return(results==null)?"":results[1];}})(jQuery);var pp_alreadyInitialized=false;



window.selectnav = (function(){
	
			
	var selectnav = function(element,options){
		
		element = document.getElementById(element);

		// return immediately if element doesn't exist	
		if( ! element) 
			return;
		
	};
	
	return function (element,options) { 
		selectnav(element,options);
	};


})();













/*! (c) Mat Marquis (@wilto). MIT License. http://wil.to/3a */

(function( $, undefined ) {
	var inst = 0;

	$.fn.getPercentage = function() {
		var oPercent = this.attr('style').match(/margin\-left:(.*[0-9])/i) && parseInt(RegExp.$1);

		return oPercent;
	};

	$.fn.adjRounding = function(slide) {
		var $el = $(this),
			$slides = $el.find( slide ),
			diff = $el.parent().width() - $($slides[0]).width();

		if (diff !== 0) { 
			$($slides).css( "position", "relative" );

			for (var i = 0; i < $slides.length; i++) {
				$($slides[i]).css( "left", (diff * i) + "px" );
			}
		}

		return this;
	};

	$.fn.carousel = function(config) {

		// Prevent re-init:
		if( this.data( "carousel-initialized" ) ) { return; }

		// Carousel is being initialized:
		this.data( "carousel-initialized", true );

		var defaults = {
			slider			: '.slider',
			slide			: '.slide',
			prevSlide		: null,
			nextSlide		: null,
			slideHed		: null,
			addPagination	: false,
			addNav			: ( config != undefined && ( config.prevSlide || config.nextSlide ) ) ? false : true,
			namespace		: 'carousel',
			speed			: 300
		},
		opt               = $.extend(defaults, config),
		$slidewrap        = this,
		dBody            = (document.body || document.documentElement),
		transitionSupport = function() {
			// Original code from Modernizr : http://www.modernizr.com/
		    var prop = 'transitionProperty',
				modElem = document.createElement('tester'),
				mStyle = modElem.style,
				prefixes = ' -webkit- -moz- -o- -ms- -khtml- '.split(' '),
				domPrefixes = 'Webkit Moz O ms Khtml'.split(' '),
				ucProp  = prop.charAt(0).toUpperCase() + prop.substr(1),
				props   = (prop + ' ' + domPrefixes.join(ucProp + ' ') + ucProp).split(' ');

			for ( var i in props ) {
				if ( mStyle[ props[i] ] !== undefined ) {
					return true;
				}
			}
			return false;
		},
		carousel = {
			init : function() {				
				inst++;

				$slidewrap.each(function(carInt) {
						var $wrap      = $(this),
							$slider    = $wrap.find(opt.slider),
							$slide     = $wrap.find(opt.slide),			
							slidenum   = $slide.length,
							transition = "margin-left " + ( opt.speed / 1000 ) + "s ease",
							tmp        = 'carousel-' + inst + '-' + carInt;

						if( $slide.length <= 1 ) {
							return; /* No sense running all this code if the carousel functionality is unnecessary. */
						}

						$wrap
							.css({
								overflow             : "hidden",
								width                : "100.2%"
							})
							.attr('role' , 'application');

						$slider
							.attr( 'id', ( $slider[0].id || 'carousel-' + inst + '-' + carInt ) )
							.css({
								"marginLeft"         : "0px",
								"float"              : "left",
								"width"              : 100 * slidenum + "%",
								"-webkit-transition" : transition,
								"-moz-transition"    : transition,
								"-ms-transition"     : transition,
								"-o-transition"      : transition,
								"transition"         : transition
							})
							.bind( 'carouselmove' , carousel.move )
							.bind( 'nextprev'     , carousel.nextPrev )
							.bind( 'navstate'     , carousel.navState );

						$slide
							.css({
								"float": "left",
								width: (100 / slidenum) + "%"				
							})
							.each(function(i) {
								var $el = $(this);

								$el.attr({
									role : "tabpanel document",
									id   : tmp + '-slide' + i
								});

								if( opt.addPagination ) {
									$el.attr('aria-labelledby', tmp + '-tab' + i);
								}
							});

						// Build and insert navigation/pagination, if specified in the options:
						opt.addPagination   && carousel.addPagination();
						opt.addNav 			&& carousel.addNav();

						$slider.trigger( "navstate", { current: 0 });
				});
			},
			addNav : function() {
				$slidewrap.each(function(i) {						
					var $oEl = $(this),
						$slider = $oEl.find(opt.slider),
						currentSlider = $slider[0].id,
						navMarkup = [
							'<ul class="slidecontrols" role="navigation">',
							'	<li role="presentation"><a href="#' + currentSlider + '" class="' + opt.namespace + '-next">Next</a></li>',
							'	<li role="presentation"><a href="#' + currentSlider + '" class="' + opt.namespace + '-prev">Prev</a></li>',
							'</ul>'
							].join(''),
						nextprev = {
							nextSlide : '.' + opt.namespace + '-next',
							prevSlide : '.' + opt.namespace + '-prev'
						};

					opt = $.extend(opt, nextprev);

					$oEl.prepend(navMarkup);
				});
			},
			addPagination : function() {
				$slidewrap.each(function(i) {
					var $oEl        = $(this),
						$pagination = $('<ol class="' + opt.namespace + '-tabs" role="tablist navigation" />'),
						$slider     = $oEl.find(opt.slider),
						$slides     = $oEl.find(opt.slide)
						slideNum    = $slides.length,
						associated  = 'carousel-' + inst + '-' + i;

					while( slideNum-- ) {
						var hed = $( $slides[ slideNum ] ).find( opt.slideHed ).text() || 'Page ' + ( slideNum + 1 ),
							tabMarkup = [
								'<li role="presentation">',
									'<a href="#' + associated + '-slide' + slideNum +'"',
									' aria-controls="' + associated + '-slide' + slideNum +'"',
									' id="' + associated + '-tab' + slideNum + '" role="tab">' + hed + '</a>',
								'</li>'
							].join('');

						$pagination.prepend(tabMarkup);
					};

					$pagination
						.appendTo( $oEl )
						.find('li').keydown( function(e) {
							var $el      = $(this),
								$prevTab = $el.prev().find('a'),
								$nextTab = $el.next().find('a');

							switch( e.which ) {
								case 37:
								case 38:		
									$prevTab.length && $prevTab.trigger('click').focus();
									e.preventDefault();
									break;
								case 39: 
								case 40:
									$nextTab.length && $nextTab.trigger('click').focus();
									e.preventDefault();
									break;
							}
						})
						.find('a').click( function(e) {
							var $el = $(this);

							if( $el.attr('aria-selected') == 'false' ) { 
								var current = $el.parent().index(),
									move    = -( 100 * ( current ) ),
									$slider = $oEl.find( opt.slider );

								$slider.trigger( 'carouselmove', { moveTo: move });
							}
							e.preventDefault();
						});
				});
			},
			roundDown : function(oVal) {
				var val = parseInt(oVal, 10);

				return Math.ceil( (val - (val % 100 ) ) / 100) * 100;
			},
			navState : function(e, ui) {
				var $el          = $(this),
					$slides      = $el.find(opt.slide),
					ind          = -(ui.current / 100),
					$activeSlide = $($slides[ind]);

				$el.attr('aria-activedescendant', $activeSlide[0].id);

				// Update state of active tabpanel:
				$activeSlide
					.addClass( opt.namespace + "-active-slide" )
					.attr( 'aria-hidden', false )
					.siblings()	
						.removeClass( opt.namespace + "-active-slide" )
						.attr( 'aria-hidden', true );

				// Update state of next/prev navigation:
				if( ( !!opt.prevSlide || !!opt.nextSlide ) ) {
					var $target = $('[href*="#' + this.id + '"]');

					$target.removeClass( opt.namespace + '-disabled' );

					if( ind == 0 ) {
						$target.filter(opt.prevSlide).addClass( opt.namespace + '-disabled' );
					} else if( ind == $slides.length - 1 ) {
						$target.filter(opt.nextSlide).addClass( opt.namespace + '-disabled' );
					}
				}

				// Update state of pagination tabs:
				if( !!opt.addPagination ) {
					var tabId = $activeSlide.attr('aria-labelledby'),
						$tab  = $('#' + tabId );

					$tab
						.parent()
						.addClass(opt.namespace + '-active-tab')
						.siblings()
						.removeClass(opt.namespace + '-active-tab')
						.find('a')
							.attr({
								'aria-selected' : false,
								'tabindex' : -1
							});

					$tab.attr({
						'aria-selected' : true,
						'tabindex' : 0
					});
				}
			},
			move : function(e, ui) {
				var $el = $(this);

				$el
					.trigger(opt.namespace + "-beforemove")
					.trigger("navstate", { current: ui.moveTo });

				if( transitionSupport() ) {

					$el
						.adjRounding( opt.slide ) /* Accounts for browser rounding errors. Lookin' at you, iOS Safari. */
						.css('marginLeft', ui.moveTo + "%")
						.one("transitionend webkitTransitionEnd OTransitionEnd", function() {
							$(this).trigger( opt.namespace + "-aftermove" );
						});

				} else {					
					$el
						.adjRounding( opt.slide )
						.animate({ marginLeft: ui.moveTo + "%" }, { duration : opt.speed, queue : false }, function() {
							$(this).trigger( opt.namespace + "-aftermove" );
						});
				}
			},
			nextPrev : function(e, ui) {				
				var $el = $(this),
					left = ( $el ) ? $el.getPercentage() : 0,
					$slide = $el.find(opt.slide),
					constrain = ui.dir === 'prev' ? left != 0 : -left < ($slide.length - 1) * 100,
					$target = $( '[href="#' + this.id + '"]');

				if (!$el.is(":animated") && constrain ) {

					if ( ui.dir === 'prev' ) {
						left = ( left % 100 != 0 ) ? carousel.roundDown(left) : left + 100;
					} else {
						left = ( ( left % 100 ) != 0 ) ? carousel.roundDown(left) - 100 : left - 100;
					}

					$el.trigger('carouselmove', { moveTo: left });

					$target
						.removeClass( opt.namespace + '-disabled')
						.removeAttr('aria-disabled');

					switch( left ) {
						case ( -($slide.length - 1) * 100 ):
							$target.filter(opt.nextSlide)
								.addClass( opt.namespace + '-disabled')
								.attr('aria-disabled', true);
							break;
						case 0:
							$target.filter(opt.prevSlide)
								.addClass( opt.namespace + '-disabled')
								.attr('aria-disabled', true);
							break;
					}
				} else {
					var reset = carousel.roundDown(left);

					$el.trigger('carouselmove', { moveTo: reset });
				}

			}
		};

		carousel.init(this);

		$(opt.nextSlide + ',' + opt.prevSlide)
			.bind('click', function(e) {				
				var $el = $(this),
					link = this.hash,
					dir = ( $el.is(opt.prevSlide) ) ? 'prev' : 'next',
					$slider = $(link);

					if ( $el.is('.' + opt.namespace + '-disabled') ) { 
						return false;
					}

					$slider.trigger('nextprev', { dir: dir });

				e.preventDefault();
			})
			.bind('keydown', function(e) {
				var $el = $(this),
					link = this.hash;

				switch (e.which) {
					case 37:
					case 38:
						$('#' + link).trigger('nextprev', { dir: 'next' });
						e.preventDefault();
						break;
					case 39:
					case 40:
						$('#' + link).trigger('nextprev', { dir: 'prev' });
						e.preventDefault();
						break;
				}
			});

		var setup = {
			wrap : this,
			slider : opt.slider
		};
		$slidewrap.bind( "dragSnap", setup, function(e, ui){
			var $slider = $(this).find( opt.slider ),
				dir = ( ui.direction === "left" ) ? 'next' : 'prev';

			$slider.trigger("nextprev", { dir: dir });	
		});


// start new code for auto rotate carousel slider

		$slidewrap.filter('[data-autorotate]').each(function() {
	var auto,
				$el         = $(this),
				speed       = $el.attr('data-autorotate'),
        $slider     = $el.find(opt.slider),
        slidenum    = $el.find(opt.slide).length,
        forward     = true,
				autoAdvance = function() {
					var active   = -( $slider.getPercentage() / 100 ) + 1;

          switch ( active ) {
              case slidenum:
                  forward = false;
                  break;
              case 1:
                  forward = true;
                  break;
          }

          $slider.trigger("nextprev", { dir: (forward) ? 'next' : 'prev' });
				};

			auto = setInterval(autoAdvance, speed);

			$el
				.attr('aria-live', 'polite')
				.bind('mouseenter click touchstart', function() {
					clearInterval(auto);
				});
		});

		return this;
	};
})(jQuery);


// End new code 


$.event.special.dragSnap = {
	setup: function(setup) {

		var $el = $(this),
			transitionSwap = function($el, tog) {
				var speed = .3,
					transition = ( tog ) ? "margin-left " + speed + "s ease" : 'none';

				$el.css({
					"-webkit-transition" : transition,
					"-moz-transition"    : transition,
					"-ms-transition"     : transition,
					"-o-transition"      : transition,
					"transition"         : transition
				});
			},
			roundDown = function(left) {
				var left = parseInt(left, 10);

				return Math.ceil( (left - (left % 100 ) ) / 100) * 100;
			},
			snapBack = function(e, ui) {
				var $el = ui.target,
					currentPos = ( $el.attr('style') != undefined ) ? $el.getPercentage() : 0,
					left = (ui.left === false) ? roundDown(currentPos) - 100 : roundDown(currentPos),
					dStyle = document.body.style,
					transitionSupport = function() {
						// Original code from Modernizr : http://www.modernizr.com/
					    var prop = 'transitionProperty',
							modElem = document.createElement('tester'),
							mStyle = modElem.style,
							prefixes = ' -webkit- -moz- -o- -ms- -khtml- '.split(' '),
							domPrefixes = 'Webkit Moz O ms Khtml'.split(' '),
							ucProp  = prop.charAt(0).toUpperCase() + prop.substr(1),
							props   = (prop + ' ' + domPrefixes.join(ucProp + ' ') + ucProp).split(' ');

						for ( var i in props ) {
							if ( mStyle[ props[i] ] !== undefined ) {
								return true;
							}
						}
						return false;
					};

				transitionSwap($el, true);

				if( transitionSupport() ) {
					$el.css('marginLeft', left + "%");
				} else {
					$el.animate({ marginLeft: left + "%" }, opt.speed);
				}
			};

		$el
			.bind("snapback", snapBack)
			.bind("touchstart", function(e) {
				var data = e.originalEvent.touches ? e.originalEvent.touches[0] : e,
					start = {
						time: (new Date).getTime(),
						coords: [ data.pageX, data.pageY ],
						origin: $(e.target).closest( setup.wrap )
					},
					stop,
					$tEl = $(e.target).closest( setup.slider ),
					currentPos = ( $tEl.attr('style') != undefined ) ? $tEl.getPercentage() : 0;

				transitionSwap($tEl, false);

				function moveHandler(e) {
					var data = e.originalEvent.touches ? e.originalEvent.touches[0] : e;
					stop = {
							time: (new Date).getTime(),
							coords: [ data.pageX, data.pageY ]
					};

					if(!start || Math.abs(start.coords[0] - stop.coords[0]) < Math.abs(start.coords[1] - stop.coords[1]) ) {
						return;
					}

					$tEl.css({"margin-left": currentPos + ( ( (stop.coords[0] - start.coords[0]) / start.origin.width() ) * 100 ) + '%' });						

					// prevent scrolling
					if (Math.abs(start.coords[0] - stop.coords[0]) > 10) {
						e.preventDefault();
					}

				};

				$el
					.bind("gesturestart", function(e) {
						$el
							.unbind("touchmove", moveHandler)
							.unbind("touchend", moveHandler);
					})
					.bind("touchmove", moveHandler)
					.one("touchend", function(e) {

						$el.unbind("touchmove", moveHandler);

						transitionSwap($tEl, true);

						if (start && stop ) {

							if (Math.abs(start.coords[0] - stop.coords[0]) > 10
								&& Math.abs(start.coords[0] - stop.coords[0]) > Math.abs(start.coords[1] - stop.coords[1])) {
								e.preventDefault();
							} else {
								$el.trigger('snapback', { target: $tEl, left: true });
								return;
							}

							if (Math.abs(start.coords[0] - stop.coords[0]) > 1 && Math.abs(start.coords[1] - stop.coords[1]) < 75) {
								var left = start.coords[0] > stop.coords[0];

							if( -( stop.coords[0] - start.coords[0]) > ( start.origin.width() / 4 ) || ( stop.coords[0] - start.coords[0]) > ( start.origin.width() / 4 ) ) {

								start.origin.trigger("dragSnap", {direction: left ? "left" : "right"});

								} else {								
									$el.trigger('snapback', { target: $tEl, left: left });
								}

							}
						}
						start = stop = undefined;
					});
			});
	}
};

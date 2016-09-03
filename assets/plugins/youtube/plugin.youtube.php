<?php
/**
 * YoutubeModxEvo
 * YoutubeModxEvo plugin for MODX Evo
 *
 *
 * @category	plugin 
 * @version		1.0
 * @license		http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL) 
 * @internal	@properties 
 * @internal	@events OnWebPagePrerender 
 * @internal	@modx_category Content 
 * @internal	@legacy_names YoutubeModxEvo
 * @internal	@installset base
 * @author		ProjectSoft (projectsoft2009@yandex.ru)
*/
//author ProjectSoft (projectsoft@ioweb.ru)
if(!defined('MODX_BASE_PATH')) die('What are you doing? Get out of here!');

global $modx, $YtBetpl, $defYtStyle, $YtStyle, $icludeYtStyle;
$YtBetpl = isset($tpl) ? $modx->getChunk($tpl) : null;
$defYtStyle = $icludeYtStyle = 0;
$YtStyle = '
<style>
.embed-responsive {
	position: relative;
	display: block;
	height: 0;
	padding: 0;
	overflow: hidden;
}
.embed-responsive iframe,
.embed-responsive embed,
.embed-responsive object,
.embed-responsive video {
	position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    height: 100%;
    width: 100%;
    border: 0;
}
.embed-responsive-16by9 {
	padding-bottom: 56.25%;
}

.embed-responsive-4by3 {
	padding-bottom: 75%;
}
</style>';
$defaultTpl = '
<div class="embed-responsive embed-responsive-16by9">
	<iframe src="[+youtube+]" frameborder="0" allowfullscreen></iframe>
</div>';
$e =&$modx->event;

if(empty($YtBetpl)){
	$defYtStyle = 1;
	$YtBetpl = $defaultTpl;
}
/*
<iframe width="1366" height="668" src="https://www.youtube.com/embed/axd2JccV8MA?list=PLfpYsuT2dXbzcDEvD7e8qApvGNvtpf1Fq" frameborder="0" allowfullscreen></iframe>
*/
if(!function_exists("youtube_clear")) {
	function youtube_clear(){
		return "<noindex><strong style=\"color:red;\">Invalid Video Embed</strong></noindex>";
	}
}
if(!function_exists("youtube_replacer")) {
	function youtube_replacer(&$matches){
		global $modx, $YtBetpl, $defYtStyle, $YtStyle, $icludeYtStyle;
		$html = "";
		/**
		MATCH 1
		1.	[0-62]	`{youtube}https://www.youtube.com/watch?v=E_cb5Dc5vbA{/youtube}`
		2.	[0-9]	`{youtube}`
		3.	[41-52]	`E_cb5Dc5vbA`
		5.	[52-62]	`{/youtube}`
		
		**
		**
		MATCH 2
		1.	[64-174]	`{youtube}https://www.youtube.com/watch?v=0Nv-yFuT-BQ&list=PLfpYsuT2dXbzcDEvD7e8qApvGNvtpf1Fq&index=2{/youtube}`
		2.	[64-73]	`{youtube}`
		3.	[105-116]	`0Nv-yFuT-BQ`
		4.	[122-156]	`PLfpYsuT2dXbzcDEvD7e8qApvGNvtpf1Fq`
		5.	[164-174]	`{/youtube}`
		**/
		
		
		if(empty($matches[3])){
			return $html;
		}
		$html = ($defYtStyle==1 && $icludeYtStyle==0) ? $YtStyle : "";
		$icludeYtStyle = 1;
		$list = (empty($matches[4])) ? "?rel=0" : "?list={$matches[4]}&rel=0";
		$youtube = array("//www.youtube-nocookie.com/embed/", $matches[3], $list);
		
		$embed = array("youtube"=>implode("", $youtube));
		
		$html .= $modx->parseText($YtBetpl, $embed, '[+', '+]');
		
		return $html;
	}
}

switch ($e->name) {
	case "OnWebPagePrerender":{
		$outputPrepare = $modx->documentOutput;
		$re = "@((\{youtube\})(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|playlist\?|watch\?v=|watch\?.+(?:&|&#38;|&amp;);v=))([a-zA-Z0-9\-_]{11})?(?:(?:\?|&|&#38;|&amp;)?list=([a-zA-Z\-_0-9]{34}))?(?:\S+)?(\{\/youtube\}))@i";
		$outputPrepare = preg_replace_callback($re, 'youtube_replacer', $outputPrepare);
		/**
		*** Добавить поддержку других серверов видео
		*** (ProjectSoft)
		**/
		
		/**
		*** Очищаем
		**/
		$reclean = "@((\{youtube\})(.+)(\{\/youtube\}))@i";
		$outputPrepare = preg_replace_callback($reclean, 'youtube_clear', $outputPrepare);
		$modx->documentOutput = $outputPrepare;
		break;
	}
}
?>
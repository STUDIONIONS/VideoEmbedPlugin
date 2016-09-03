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
global $modx;
$tpl = isset($tpl) ? $tpl : ;
$e =&$modx->event;

if(!function_exists("youtube_replacer")) {
	function youtube_replacer(&$matches){
		global $modx;
		$html = print_r($matches, true);
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
		
		$id = $matches[3];
		$list = $matches[4];
		if(empty($id)){
			return $html;
		}
		return $html;
	}
}
if(!function_exists("youtube_parsetext")) {
	function youtube_parsetext(){
		global $modx;
		$embed = "https://www.youtube-nocookie.com/embed/%id%%list%";
		$out = "";
		return $out;
	}
}
switch ($e->name) {
	case "OnWebPagePrerender":{
		$outputPrepare = $modx->documentOutput;
		$re = "@((\{youtube\})(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|playlist\?|watch\?v=|watch\?.+(?:&|&#38;);v=))([a-zA-Z0-9\-_]{11})?(?:(?:\?|&|&#38;)?list=([a-zA-Z\-_0-9]{34}))?(?:\S+)?(\{\/youtube\}))@i";
		$outputPrepare = preg_replace_callback($re, 'youtube_replacer', $outputPrepare);
		$modx->documentOutput = $outputPrepare;
		break;
	}
}
?>
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
$e =&$modx->event;

if(!function_exists("youtube_replacer")) {
	function youtube_replacer(&$matches){
		$html = "";
		return $html;
	}
}
switch ($e->name) {
	case "OnWebPagePrerender":{
		$outputPrepare = $modx->documentOutput;
		$regex = "#(\{youtube\}(.+)\{\/youtube})#Usi";
		$outputPrepare = preg_replace_callback($regex, 'youtube_replacer', $outputPrepare);
		$modx->documentOutput = $outputPrepare;
		break;
	}
}
?>
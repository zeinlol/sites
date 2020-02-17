<?php
/**
* @package Helix Framework
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2015 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

function String2Stars($string='',$first=0,$last=0){
  $begin  = substr($string,0,$first);
  $end    = substr($string,$last);
  $stars  = $begin.$end;
  return $stars;
}

function modChrome_sp_xhtml($module, $params, $attribs) {

	$moduleTag     = $params->get('module_tag', 'div');
	$bootstrapSize = (int) $params->get('bootstrap_size', 0);
	$moduleClass   = $bootstrapSize != 0 ? ' col-sm-' . $bootstrapSize : '';
	$headerTag     = htmlspecialchars($params->get('header_tag', 'h3'));
	$headerClass   = htmlspecialchars($params->get('header_class', 'sp-module-title'));
	
	if ($module->content) {
		echo '<' . $moduleTag . ' class="sp-module ' . htmlspecialchars($params->get('moduleclass_sfx')) . $moduleClass . '">';
			$title_start = strrpos($module->title,"[");
			$title_end =  strrpos($module->title,"]");
			if ($module->showtitle && is_int($title_start))
			{
				$title = String2Stars($module->title,$title_start,$title_end + 1);
				$strtitle = trim($title);
				echo '<div class="' . $headerClass . '"><' . $headerTag . '><span>'. $strtitle . '</span><i class="cross-icon"><i></i></i></' . $headerTag . '></div>';
			}
			else if ($module->showtitle) 
			{
				echo '<div class="' . $headerClass . '"><' . $headerTag . '><span>' . $module->title . '</span><i class="cross-icon"><i></i></i></' . $headerTag . '></div>';
			}

			echo '<div class="sp-module-content">';
			echo $module->content;
			echo '</div>';

		echo '</' . $moduleTag . '>';
	}
}
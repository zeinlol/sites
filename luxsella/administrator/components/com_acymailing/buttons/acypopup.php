<?php
/**
 * @package	AcyMailing for Joomla!
 * @version	4.9.4
 * @author	acyba.com
 * @copyright	(C) 2009-2015 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php

class JButtonAcypopup extends JButton
{
	var $_name = 'Acypopup';

	function fetchButton($type = 'Acypopup', $name = '', $text = '', $url = '', $width = 640, $height = 480){
		$params = array();
		$onClick = '';

		if(in_array($name, array('acyabtesting','acyaction'))){
			$doc = JFactory::getDocument();
			if(empty($doc->_script['text/javascript']) || strpos($doc->_script['text/javascript'], 'getAcyPopupUrl') === false){
				$js = "
function getAcyPopupUrl(mylink){
	i = 0;
	mymailids = '';
	while(window.document.getElementById('cb'+i)){
		if(window.document.getElementById('cb'+i).checked) mymailids += window.document.getElementById('cb'+i).value+',';
		i++;
	}
	mylink += mymailids.slice(0,-1);
	return mylink;
}";
				$doc->addScriptDeclaration($js);
			}

			if($name == 'acyabtesting'){
				$mylink = 'index.php?option=com_acymailing&ctrl=newsletter&task=abtesting&tmpl=component&mailid=';
				$url = JURI::base()."index.php?option=com_acymailing&ctrl=newsletter&task=abtesting&tmpl=component";
			}elseif($name == 'acyaction'){
				$mylink = 'index.php?option=com_acymailing&ctrl=filter&tmpl=component&subid=';
				$url = JURI::base()."index.php?option=com_acymailing&ctrl=filter&tmpl=component";
			}

			$onClick = ' onclick="this.href=getAcyPopupUrl(\''.$mylink.'\');"';
			$params['url'] = '\'+getAcyPopupUrl(\''.$mylink.'\')+\'';
		}else{
			$params['url'] = $url;
		}

		if(!ACYMAILING_J30){
			JHTML::_('behavior.modal','a.modal');
			$html  = '<a'.$onClick.' id="a_'.$name.'" class="modal" href="'.$url.'" rel="{handler: \'iframe\', size: {x: '.$width.', y: '.$height.'}}">';
			$html .= '<span class="icon-32-'.$name.'" title="'.$text.'"></span>'.$text.'</a>';
			return $html;
		}

		$html = '<button class="btn btn-small modal" data-toggle="modal" data-target="#modal-'.$name.'"><i class="icon-'.$name.'"></i> '.$text.'</button>';
		$params['height'] = $height;
		$params['width']  = $width;
		$params['title']  = $text;

		$modalHtml = JHtml::_('bootstrap.renderModal', 'modal-'.$name, $params);

		$html .= str_replace(
				array('id="modal-'.$name.'"', 'class="modal-body"', 'id="modal-'.$name.'-container"','class="iframe"'),
				array('id="modal-'.$name.'" style="width:82%;height:84%;margin-left:9%;left:0;"', 'class="modal-body" style="height:85%;"', 'id="modal-'.$name.'-container" style="height:100%"','class="iframe" style="width:100%"'),
				$modalHtml
		);
		$html .= '<script>'."\r\n" . 'jQuery(document).ready(function(){jQuery("#modal-'.$name.'").appendTo(jQuery(document.body));});'."\r\n".'</script>';
		$html .= '<style type="text/css">#modal-'.$name.' iframe.iframe{ height: 98%; }</style>';
		return $html;
	}

	function fetchId($type = 'Acypopup', $html = '', $id = 'Acypopup'){
		if(empty($html)) $html = $id;
		return 'toolbar-'.$html;
	}
}

class JToolbarButtonAcypopup extends JButtonAcypopup{}

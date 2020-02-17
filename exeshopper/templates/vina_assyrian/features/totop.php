<?php
/**
 * @package Helix Framework
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2014 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/
//no direct accees
defined ('_JEXEC') or die('resticted aceess');
 
class Helix3FeatureTotop {

	private $helix3;
	public $position;

	public function __construct($helix3){
		$this->helix3 = $helix3;		
		$this->position = $this->helix3->getParam('totop_position', 'footer2');		
	}
	
	public function renderFeature() {
		return '<a class="sp-totop" href="javascript:;" title="' . JText::_('LANG_GOTO_TOP') . '" rel="nofollow"><small>'. JText::_('LANG_GOTO_TOP') .' </small><i class="fa fa-chevron-up"></i></a>';
	}
}
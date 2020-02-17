<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2014 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/
//no direct accees
defined ('_JEXEC') or die('resticted aceess');

class Helix3FeatureContact {

	private $helix3;

	public function __construct($helix3){
		$this->helix3 = $helix3;
		$this->position = $this->helix3->getParam('contact_position');
	}

	public function renderFeature() {

		if($this->helix3->getParam('enable_contactinfo')) {

			$output = '<div class="top-contact">';
			
			if($this->helix3->getParam('contact_email')) $output .= '<div class="header-email widget"><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:'. $this->helix3->getParam('contact_email') .'">'. $this->helix3->getParam('contact_email') . '</a></div>';
			if($this->helix3->getParam('contact_phone')) $output .= '<div class="header-phone widget"><i class="fa  fa-phone"></i> <strong>Phone:</strong> ' . $this->helix3->getParam('contact_phone') . '</div>';
			
			$output .= '</div>';

			return $output;
		}
		
	}    
}
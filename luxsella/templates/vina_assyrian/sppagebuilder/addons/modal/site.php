<?php
/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2015 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

AddonParser::addAddon('sp_modal','sp_modal_addon');

function sp_modal_addon($atts) {
	extract(spAddonAtts(array(
		'modal_selector' 			=> '',
		'button_text' 				=> '',
		'button_size' 				=> '',
		'button_type' 				=> '',
		'button_icon' 				=> '',
		'button_block' 				=> '',
		'selector_image' 			=> '',
		'alignment' 				=> '',
		'modal_window_size' 		=> '',
		'modal_window_title' 		=> '',
		'modal_content_text' 		=> '',
		'modal_content_image' 		=> '',
		'modal_content_video_url' 	=> '',
		'class' 					=> '',
		), $atts));

	if($modal_window_title=='') $modal_window_title = 'Modal Title';

	if($button_icon !='') {
		$button_text = '<i class="fa ' . $button_icon . '"></i> ' . $button_text;
	}

	$output = '';

	$output .= '<div class="sppb-modal-selector-container ' . $alignment . '">';

	if($modal_selector=='image') {
		if($selector_image) $output .= '<a class="sppb-modal-selector" href="#" data-toggle="sppb-modal"><img src="' . $selector_image . '" alt=""></a>';
	} else {
		$output .= '<button class="sppb-btn sppb-btn-'. $button_type .' sppb-btn-'. $button_size . ' ' . $button_block .' sppb-modal-selector" data-toggle="sppb-modal">'. $button_text .'</button>';
	}

	$output .= '</div>';

	$output .= '<div class="sppb-modal sppb-fade '. $class .'" tabindex="-1" role="dialog" aria-hidden="true">';
	$output .= '<div class="sppb-modal-dialog ' . $modal_window_size . '">';
	$output .= '<div class="sppb-modal-content">';

	$output .= '<div class="sppb-modal-header">';
	$output .= '<button type="button" class="sppb-close" data-dismiss="sppb-modal"><span aria-hidden="true">&times;</span></button>';
	$output .= '<h4 class="sppb-modal-title">' . $modal_window_title . '</h4>';
	$output .= '</div>';

	$output .= '<div class="sppb-modal-body">';

	if($modal_content_text) $output .= '<div class="sppb-modal-text">'. $modal_content_text .'</div>';
	if($modal_content_image) $output .= '<div class="sppb-modal-image"><img class="sppb-img-responsive" src="'. $modal_content_image .'" alt=""></div>';

	//Video
	if($modal_content_video_url) {

		$video = parse_url($modal_content_video_url);
		
		switch($video['host']) {
			case 'youtu.be':
				$id = trim($video['path'],'/');
				$src = '//www.youtube.com/embed/' . $id;
			break;
			
			case 'www.youtube.com':
			case 'youtube.com':
				parse_str($video['query'], $query);
				$id = $query['v'];
				$src = '//www.youtube.com/embed/' . $id;
			break;
			
			case 'vimeo.com':
			case 'www.vimeo.com':
				$id = trim($video['path'],'/');
				$src = "//player.vimeo.com/video/{$id}";
		}

		$output .= '<div class="sppb-modal-video sppb-embed-responsive sppb-embed-responsive-16by9">';
		$output .= '<iframe class="sppb-embed-responsive-item" src="' . $src . '"></iframe>';
		$output .= '</div>';
	}

	$output .= '</div>';
	
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}
<?php

defined ('_JEXEC') or die('resticted aceess');

AddonParser::addAddon('sp_testimonialpro','sp_testimonialpro_addon');
AddonParser::addAddon('sp_testimonialpro_item','sp_testimonialpro_item_addon');

function sp_testimonialpro_addon($atts, $content){

	extract(spAddonAtts(array(	
		'autoplay'=>'',
		'arrows'=>'',
		'controllers'=>'',
		'margin'=>'',
		'padding'=>'50px 0',
		'background_color'=>'#663399',
		"class"=>'',
		), $atts));
	$style = '';		
	
	if($margin) $style .='margin:'.$margin.'; ';
	if($padding) $style .='padding:'.$padding.'; ';
	if($background_color) $style .='background-color:'.$background_color.'; ';
	$carousel_autoplay = ($autoplay)?'data-sppb-ride="sppb-carousel"':'';
	
	$output  .= '<div style="' . $style . '" class="sppb-carousel sppb-testimonial-pro sppb-slide ' . $class . ' sppb-text-center" ' . $carousel_autoplay . '>';

	$output .= '<div class="sppb-carousel-inner">';
	$output .= AddonParser::spDoAddon($content);
	$output	.= '</div>';

	if($arrows) {
		$output	.= '<a class="left sppb-carousel-control" role="button" data-slide="prev"><i class="fa fa-angle-left"></i></a>';
		$output	.= '<a class="right sppb-carousel-control" role="button" data-slide="next"><i class="fa fa-angle-right"></i></a>';
	}
	
	if($controllers) {
		$output .= '<ol class="sppb-carousel-indicators">';
		$output .= '</ol>';
	}
	
	$output .= '</div>';

	return $output;

}

function sp_testimonialpro_item_addon( $atts ){

	extract(spAddonAtts(array(
		"title"=>'',
		"avatar"=>'',
		"avatar_style"=>'',
		"avatar_position"=>'top',
		'message'=>'',
		"company"=> '',
		"url"=>'',
		), $atts));

	$output   = '<div class="sppb-item">';
	
	$title = '<strong class="pro-client-name">'. $title .'</strong>';
	if($company) $title .= ' <span class="company">'.$company.'</span>';
	if($url) $title .= ' - <span class="pro-client-url">'. $url .'</span>';		
	
	if($avatar) $media = '<img class="sppb-img-responsive sppb-avatar '. $avatar_style .'" src="'. $avatar .'" alt="">';
	
	if($title) $text_body = '<div class="sppb-testimonial-message">' . $message . '</div>';
	$text_body .= '<div class="sppb-testimonial-client">' . $title . '</div>';
	if ($avatar_position == 'top') {
		$output .= $media;
		$output .= $text_body;		

	} else if ($avatar_position == 'bottom') {
		$output .= $text_body;
		$output .= $media;		

	} else {
		$output .= '<div class="sppb-media">';
		$output .= '<div class="pull-'. $avatar_position .'">';
		$output .= '<img class="sppb-img-responsive sppb-avatar '. $avatar_style .'" src="'. $avatar .'" alt="">';
		$output .= '</div>';
		$output .= '<div class="sppb-media-body" style="text-align:'.$avatar_position.';">';
		$output .= '<div class="sppb-testimonial-message">' . $message . '</div>';
		if($title) $output .= '<div class="sppb-testimonial-client">' . $title . '</div>';
		$output .= '</div>';
		$output .= '</div>';		
	}
	
	$output  .= '</div>';
	return $output;

}
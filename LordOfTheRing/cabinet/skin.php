<?php
	define ( 'ROOT_LK_DIR', dirname ( __FILE__ ) );
	
	include( ROOT_LK_DIR . '/config.php' );
	
	if ( isset($_GET['username']) )
		$username = strip_tags($_GET['username']); else $username = 'default';
			
	$path_to_skin = ROOT_LK_DIR . $config_lk['skin']['path_to_skin'] . $username . '.png';
	$path_to_cloak = ROOT_LK_DIR . $config_lk['skin']['path_to_cloak'] . $username . '.png';
	
	if ( !file_exists($path_to_skin) ) {
		$path_to_skin = ROOT_LK_DIR . $config_lk['skin']['path_to_skin'] . 'default.png';
	}
	
	if ( !file_exists($path_to_cloak) ) {
		$path_to_cloak = false;
	}
	
	if ( $path_to_skin != false ) $skin = imagecreatefrompng($path_to_skin);
	if ( $path_to_cloak != false ) $cloak = imagecreatefrompng($path_to_cloak);
	
	$skin_size = getimagesize($path_to_skin);
	$h = $skin_size[0];
	$w = $skin_size[1];
	$ratio = $h / 64;
	
	$preview = imagecreatetruecolor(16 * $ratio, 32 * $ratio);
	$alpha = imagecolorallocatealpha($preview, 255, 255, 255, 127);
	imagefill($preview, 0, 0, $alpha);
	
	if ( !isset( $_GET['mode2'] ) )
	{
		if ( !isset( $_GET['mode'] ) )
		{
			//плащ
			if ( $path_to_cloak != false )
			{
				imagecopy($preview, $cloak, 3 * $ratio, 8 * $ratio, 12 * $ratio, 1 * $ratio, 10 * $ratio, 16 * $ratio);
			}
			
			//голова
			imagecopy($preview, $skin, 4 * $ratio, 0 * $ratio, 8 * $ratio, 8 * $ratio, 8 * $ratio, 8 * $ratio);
			//тело
			imagecopy($preview, $skin, 4 * $ratio, 8 * $ratio, 20 * $ratio, 20 * $ratio, 8 * $ratio, 12 * $ratio);
			//руки
			imagecopy($preview, $skin, 0 * $ratio, 8 * $ratio, 44 * $ratio, 20 * $ratio, 4 * $ratio, 12 * $ratio);
			_imageflip($preview, $skin, 12 * $ratio, 8 * $ratio, 44 * $ratio, 20 * $ratio, 4 * $ratio, 12 * $ratio);
			//ноги
			imagecopy($preview, $skin, 4 * $ratio, 20 * $ratio, 4 * $ratio, 20 * $ratio, 4 * $ratio, 12 * $ratio);
			_imageflip($preview, $skin, 8 * $ratio, 20 * $ratio, 4 * $ratio, 20 * $ratio, 4 * $ratio, 12 * $ratio);
		} else {
		
			//голова
			imagecopy($preview, $skin, 4 * $ratio, 0 * $ratio, 24 * $ratio, 8 * $ratio, 8 * $ratio, 8 * $ratio);
			//тело
			imagecopy($preview, $skin, 4 * $ratio, 8 * $ratio, 32 * $ratio, 20 * $ratio, 8 * $ratio, 12 * $ratio);
			//руки
			_imageflip($preview, $skin, 0 * $ratio, 8 * $ratio, 52 * $ratio, 20 * $ratio, 4 * $ratio, 12 * $ratio);
			imagecopy($preview, $skin, 12 * $ratio, 8 * $ratio, 52 * $ratio, 20 * $ratio, 4 * $ratio, 12 * $ratio);
			//ноги
			_imageflip($preview, $skin, 4 * $ratio, 20 * $ratio, 12 * $ratio, 20 * $ratio, 4 * $ratio, 12 * $ratio);
			imagecopy($preview, $skin, 8 * $ratio, 20 * $ratio, 12 * $ratio, 20 * $ratio, 4 * $ratio, 12 * $ratio);
			
			//плащ
			if ( $path_to_cloak != false )
			{
				imagecopy($preview, $cloak, 3 * $ratio, 8 * $ratio, 1 * $ratio, 1 * $ratio, 10 * $ratio, 16 * $ratio);
			}
		}
	} else {
		
		if ( !isset( $_GET['mode'] ) )
		{
			
			//голова
			imagecopy($preview, $skin, 4 * $ratio, 0 * $ratio, 0 * $ratio, 8 * $ratio, 8 * $ratio, 8 * $ratio);
			//рука
			imagecopy($preview, $skin, 6 * $ratio, 8 * $ratio, 40 * $ratio, 20 * $ratio, 4 * $ratio, 12 * $ratio);
			//нога
			imagecopy($preview, $skin, 6 * $ratio, 20 * $ratio, 0 * $ratio, 20 * $ratio, 4 * $ratio, 12 * $ratio);
			
			//плащ
			if ( $path_to_cloak != false )
			{
				imagecopy($preview, $cloak, 5 * $ratio, 8 * $ratio, 0 * $ratio, 0 * $ratio, 1 * $ratio, 16 * $ratio);
			}
		} else {
			
			//голова
			imagecopy($preview, $skin, 4 * $ratio, 0 * $ratio, 16 * $ratio, 8 * $ratio, 8 * $ratio, 8 * $ratio);
			//рука
			imagecopy($preview, $skin, 6 * $ratio, 8 * $ratio, 40 * $ratio, 20 * $ratio, 4 * $ratio, 12 * $ratio);
			//нога
			imagecopy($preview, $skin, 6 * $ratio, 20 * $ratio, 8 * $ratio, 20 * $ratio, 4 * $ratio, 12 * $ratio);
			
			//плащ
			if ( $path_to_cloak != false )
			{
				imagecopy($preview, $cloak, 10 * $ratio, 8 * $ratio, 11 * $ratio, 0 * $ratio, 1 * $ratio, 16 * $ratio);
			}
		}
	}
	
	
	$fullsize = imagecreatetruecolor(90 * $config_lk['skin']['zoom_k'], 180 * $config_lk['skin']['zoom_k']);
	
	imagesavealpha($fullsize, true);
	$alpha = imagecolorallocatealpha($fullsize, 255, 255, 255, 127);
	imagefill($fullsize, 0, 0, $alpha);
	
	imagecopyresized($fullsize, $preview, 0, 0, 0, 0, imagesx($fullsize), imagesy($fullsize), imagesx($preview), imagesy($preview));
	
	header('Content-type: image/png');
	imagepng($fullsize);
	imagedestroy($preview);
	imagedestroy($fullsize);
	imagedestroy($skin);
	if ( $path_to_cloak != false ) imagedestroy($cloak);
	
	function _imageflip(&$result, &$img, $rx = 0, $ry = 0, $x = 0, $y = 0, $size_x = null, $size_y = null)
	{
		if ( $size_x  < 1 ) $size_x = imagesx($img);
		if ( $size_y  < 1 ) $size_y = imagesy($img);
	 
		imagecopyresampled($result, $img, $rx, $ry, ($x + $size_x-1), $y, $size_x, $size_y, 0-$size_x, $size_y);
	}
?>
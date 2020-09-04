<?php
	
	class payment_ik {
	
		public function create_req( $params, $prefix )
		{
			$url = '';
			
			foreach ( $params as $key => $val )
			{
				if ( !preg_match('/'. $prefix .'/', $key) || empty($val) ) continue;
				$url .= '&' . $key . '=' . urlencode( $val );
			}
			
			$url{0} = '?';
			
			return $url;
		}
		
		public function sign( $params, $key )
		{
			ksort($params, SORT_STRING);
			array_push($params, $key);
			return base64_encode(md5(implode(':', $params), true));
		}
		
	}
	
?>
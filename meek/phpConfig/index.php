<?php
	/**
	 * A php reflector for meek.
	 */
	$forwardURL = "https://10.5.0.5:7002/";
	$headerArray = array();
	if ( array_key_exists("HTTP_X_SESSION_ID", $_SERVER) ) {
		$headerArray[] = "X-Session-Id: " . $_SERVER["HTTP_X_SESSION_ID"];
	}
	function HeaderFunc( $ch, $header ) {
		if ( explode( ":", $header )[0] == "Content-Type" ) {
			header( $header );
		}
		return strlen( $header );
	}
	$curlOpt = array(
		CURLOPT_HTTPHEADER => $headerArray,
		CURLOPT_CUSTOMREQUEST => $_SERVER["REQUEST_METHOD"],
		CURLOPT_POSTFIELDS => file_get_contents("php://input"),
		CURLOPT_HEADERFUNCTION => "HeaderFunc",
	);
	$ch = curl_init( $forwardURL );
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查  
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在  
	curl_setopt_array( $ch, $curlOpt );
	if ( !curl_exec( $ch ) ) {
		header("HTTP/1.1 502 Bad Gateway");
		echo "502 Bad Gateway\n";
	}
	curl_close( $ch );
?>
<?php

class WpRandomRedirectHelper {
	public static function full_url( $use_forwarded_host = false ) {
		$s = self::getServer();

		return self::url_origin( $use_forwarded_host ) . $s['REQUEST_URI'];
	}

	public static function getServer() {
		return $_SERVER;
	}

	public static function url_origin( $use_forwarded_host = false ) {
		$s        = self::getServer();
		$ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
		$sp       = strtolower( $s['SERVER_PROTOCOL'] );
		$protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
		$port     = $s['SERVER_PORT'];
		$port     = ( ( ! $ssl && $port == '80' ) || ( $ssl && $port == '443' ) ) ? '' : ':' . $port;
		$host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
		$host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;

		return $protocol . '://' . $host;
	}

	public static function getRequest() {
		$s = self::getServer();

		return $s['REQUEST_URI'];
	}

	public static function dd( $data, $exit = true ) {
		echo "<PRE>";
		var_dump( $data );
		echo "</PRE>";
		if ( $exit ) {
			exit;
		}

	}


}
<?php
class EncoderDecoder
{
	public function getHashPass($pass)
	{
		return password_hash($pass, PASSWORD_DEFAULT);
	}
	public function validPass($hash, $pass)
	{
		return password_verify($pass, $hash);
	}
}



?>
<?php 
class MiniWSSE implements MiniAuth{
	
	public function auth(MiniRequest $request){
		if($request->protocol()==='SOAP'){
			$request->prop('soap.headers', 'test');
		}else{
			$wsse_header = $this->generate_wsse_header(
					$request->prop('auth.username'), $request->prop('auth.password'));
			$request->header('X-WSSE', $wsse_header);
		}
	}
	
	private function generate_wsse_header($username, $secret)
	{
		$nonce = mt_rand();
		$base64nonce = base64_encode($nonce);
		$created = gmdate('c');
		$digest = base64_encode(sha1($nonce.$created.$secret,true));
	
		return sprintf('UsernameToken Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"',
				$username,
				$digest,
				$base64nonce,
				$created
		);
	}
	
}
?>
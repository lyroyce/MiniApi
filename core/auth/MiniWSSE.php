<?php 
/**
 * A WSSE header generator
 * @author yinli
 *
 */
class MiniWSSE extends MiniAuth{
	
	const USERNAME = 'auth.username';
	const PASSWORD = 'auth.password';
	
	public function auth(MiniRequest $request){
		$this->validate($request);
		if($request->protocol()==='SOAP'){
			$request->prop('soap.headers', 'test');
		}else{
			$wsse_header = $this->generate_wsse_header(
					$request->prop(self::USERNAME), $request->prop(self::PASSWORD));
			$request->header('X-WSSE', $wsse_header);
		}
	}
	
	private function validate(MiniRequest $request){
		if($request->prop(self::USERNAME)===null || $request->prop(self::PASSWORD)===null){
			throw new Exception(sprintf("'%s' and '%s' are required in WSSE authentication", self::USERNAME, self::PASSWORD));
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
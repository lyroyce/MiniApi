<?php 
/**
 * A WSSE header generator
 * @author yinli
 * @see SOAPHeader
 */
namespace MiniApi\Auth;

use MiniApi\MiniAuth;
use MiniApi\MiniRequest;

class MiniWSSE extends MiniAuth{
	
	const USERNAME = 'wsse.username';
	const PASSWORD = 'wsse.password';
	
	public function auth(MiniRequest $request){
		$username = $request->prop('wsse.username');
		$password = $request->prop('wsse.password');
		if($username===null || $password===null){
			throw new \Exception(sprintf("'%s' and '%s' are required in WSSE authentication", 
					'wsse.username', 'wsse.password'));
		}
		
		if($request->protocol()==='SOAP'){
			$namespace = $request->prop('wsse.namespace');
			if($namespace===null){
				throw new \Exception(sprintf("'%s' is required in SOAP WSSE authentication", 
						'wsse.namespace'));
			}
			$wsse_header = $this->generate_wsse_header_soap($username, $password, $namespace);
		}else{
			$wsse_header = $this->generate_wsse_header($username, $password);
		}
		$request->header('X-WSSE', $wsse_header);
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
	
	private function generate_wsse_header_soap($username, $secret, $namespace)
	{
		$nonce = mt_rand();
		$created = gmdate('c');
	
		$digest = base64_encode(sha1($nonce.$created.$secret,true));
		$base64nonce = base64_encode($nonce);
	
		$header = sprintf('<wsse:Security wsse:mustUnderstand="1" xmlns:wsse="%s">
	          <wsse:UsernameToken wsse:Id="User">
	              <wsse:Username>%s</wsse:Username>
	              <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordDigest">%s</wsse:Password>
	              <wsse:Nonce>%s</wsse:Nonce>
	              <wsse:Created>%s</wsse:Created>
	          </wsse:UsernameToken></wsse:Security>',
			$namespace,
		    $username,
		    $digest,
		    $base64nonce,
		    $created
		);
		return new \SOAPHeader($namespace, 'Security', new \SoapVar($header, XSD_ANYXML));
	}
}
?>
<?php
/**
 * Extend this class to enable more authentication methods
 * @author yinli
 *
 */
abstract class MiniAuth {

	/**
	 * Add authentication related info to the specified request
	 * @param MiniRequest $request
	 * @see MiniWSSE
	 */
	public abstract function auth(MiniRequest $request);
}
?>
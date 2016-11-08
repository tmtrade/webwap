<?
/**
 * 接口基类
 *
 * 发送请求
 *
 * @package	Bi
 * @author	void
 * @since	2015-03-26
 */
abstract class Bi extends RpcClient
{
	/**
	 * 接口标识
	 */
	public $apiId = 0;

	/**
	 * 接口地址
	 */
	public $url   = '';

	/**
	 * 接口访问令牌
	 */
	public $token = '';

	/**
	 * 发送请求
	 * @author	void
	 * @since	2015-03-26
	 *
	 * @access	public
	 * @param	string	$name	请求的接口
	 * @param	string  $param	提交的参数
	 * @return	array
	 */
	public function request($name, $param)
	{
		$response = parent::request($name, $param);
		//if ( empty($response) ) {
		//	return array('code' => '404', 'msg' => '系统异常', 'data' => '');
		//}
		
		return $response;
	}

	/**
	 * 发送请求(curl请求)
	 * @author	void
	 * @since	2016-01-16
	 *
	 * @access	public
	 * @param	string	$name	请求的接口
	 * @param	string  $param	提交的参数
	 * @return	array
	 */
	public function invoke($name, $param)
	{
		$param['token'] = $this->token;
		$response       = httpRequest($this->url.$name, 1, http_build_query($param));
		$response       = json_decode($response, true);

		return isset($response['body']['data']) ? $response['body']['data'] : array();
	}
}
?>
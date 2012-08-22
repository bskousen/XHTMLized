<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * masPortales
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		masPortales
 * @author		eloy pineda
 * @since		Version 0.5
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Date Helpers
 *
 * @package		masPortales
 * @subpackage	Helpers
 * @category	Helpers
 * @author		eloy pineda
 */

// ------------------------------------------------------------------------

/**
 * Añade al final del archivo, antes de la extension el texto indicado en $size
 *
 *
 * @access public
 *
 * @param	string $uri
 * @param string $size
 * @param string $url
 *
 * @return string
 */
if ( ! function_exists('get_image_url'))
{
	function get_image_url($uri, $size = false, $url = '')
	{
		if ($size) {
			$filename = pathinfo($uri, PATHINFO_FILENAME);
			$ext = pathinfo($uri, PATHINFO_EXTENSION);
			$img_url = $url . $filename . '_' . $size . '.' . $ext;
		} else {
			$img_url = $url . $uri;
		}
		
		return $img_url;
	}
}

/**
 * Devuelve el valor del registro $func
 *
 *
 * @access public
 *
 * @param	string $func
 *
 * @return string
 */
if ( ! function_exists('_reg'))
{
	function _reg($func)
	{
		$CI =& get_instance();
		if (method_exists($CI->registry, $func)) {
			return $CI->registry->$func();
		} else {
			return 'Not valid method: ' . $func;
		}
	}
}

/**
 * Imprime con echo el valor del registro $func
 *
 *
 * @access public
 *
 * @param	string $func
 *
 * @return string
 */
if ( ! function_exists('_e'))
{
	function _e($func)
	{
		$CI =& get_instance();
		if (method_exists($CI->registry, $func)) {
			echo $CI->registry->$func();
		} else {
			echo 'Not valid method: ' . $func;
		}
	}
}

/**
 * Devuelve la ID del sitio usando la clase Registry
 *
 * It is a short alias of $this->request->site_id()
 *
 * @access	public
 *
 * @return	int
 */
if ( ! function_exists('site_id'))
{
	function site_id()
	{
		$CI =& get_instance();
		return $CI->registry->site_id();
	}
}

/**
 * Header Redirect
 *
 * Header redirect in two flavors
 * For very fine grained control over headers, you could use the Output
 * Library's set_header() function.
 *
 * @access	public
 * @param	string	the URL
 * @param	string	the method: location or redirect
 * @return	string
 */
if ( ! function_exists('mp_redirect'))
{
	function mp_redirect($uri = '', $method = 'location', $http_response_code = 302)
	{
		if ( ! preg_match('#^https?://#i', $uri))
		{
			$uri = _reg('site_url') . $uri;
		}

		switch($method)
		{
			case 'refresh'	: header("Refresh:0;url=".$uri);
				break;
			default			: header("Location: ".$uri, TRUE, $http_response_code);
				break;
		}
		exit;
	}
}

/* End of file MP_tools_helper.php */
/* Location: ./application/helpers/MP_tools_helper.php */
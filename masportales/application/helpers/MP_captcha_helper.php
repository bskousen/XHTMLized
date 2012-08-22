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
 * masPortales CAPTCHA Helpers
 *
 * @package		masPortales
 * @subpackage	Helpers
 * @category	Helpers
 * @author		eloy pineda
 */

// ------------------------------------------------------------------------

/**
 * Comprueba un captcha recibido de un formalario
 *
 * 'short': dd/mm/aaaa
 * 'medium': dd/mm/aaaa a las hh:mm:ss
 * 'large': diadelasemana, dd de mes de aaaa
 * 'day': dd
 * 'month': mm
 * 'monthname': month name
 * 'year': yyyy
 * 'yyyymmdd': yyyymmdd
 * 'shortmonthname': 3 first characters of month name
 *
 * @access public
 * @param	string $db_date
 * @param string $format = 'short'
 * @return string
 */
if ( ! function_exists('check_captcha'))
{
	function check_captcha()
	{
		global $CI;
		// First, delete old captchas
		$expiration = time()-7200; // Two hour limit
		$CI->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);	
		
		// Then see if a captcha exists:
		$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
		$binds = array($CI->input->post('captcha', true), $CI->input->ip_address(), $expiration);
		$query = $CI->db->query($sql, $binds);
		$row = $query->row();
		
		if ($row->count == 0) {
			return false;
		} else {
			return true;
		}
	}
}








/* End of file MP_captcha_helper.php */
/* Location: ./application/helpers/MP_captcha_helper.php */
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
 * masPortales Date Helpers
 *
 * @package		masPortales
 * @subpackage	Helpers
 * @category	Helpers
 * @author		eloy pineda
 */

// ------------------------------------------------------------------------

/**
 * Recibe una fecha con el formato de la DB y la deveuelve en formato español
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
if ( ! function_exists('fecha'))
{
	function fecha($db_date = null, $format = 'short')
	{
		$weekdays = array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado');
		$months = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
		
		if ($db_date) {
			$unix_date = mysql_to_unix($db_date);
		} else {
			$unix_date = now();
		}
		
		switch ($format) {
			case 'short':
				$formated_date = date('d/m/Y', $unix_date);
				break;
			case 'medium':
				$formated_date = date('d/m/Y \a \l\a\s H:i:s', $unix_date);
				break;
			case 'large':
				$weekday = $weekdays[date('w', $unix_date)];
				$month = $months[date('n', $unix_date)];
				$monthday = date('j', $unix_date);
				$year = date('Y', $unix_date);
				$formated_date = $weekday . ', ' . $monthday . ' de ' . $month . ' de ' . $year;
				break;
			case 'day':
				$formated_date = date('d', $unix_date);
				break;
			case 'month':
				$formated_date = date('m', $unix_date);
				break;
			case 'monthname':
				$formated_date = $months[date('n', $unix_date)];
				break;
			case 'shortmonthname':
				$formated_date = strtolower(substr($months[date('n', $unix_date)], 0, 3));
				break;
			case 'year':
				$formated_date = date('Y', $unix_date);
				break;
			case 'yyyymmdd':
				$formated_date = date('Ymd', $unix_date);
				break;
			default:
				$formated_date = false;
				break;
		}
		
		return $formated_date;
	}
}








/* End of file MP_date_helper.php */
/* Location: ./application/helpers/MP_date_helper.php */
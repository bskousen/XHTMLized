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
 * @category	PDF
 * @author		eloy pineda
 */

// ------------------------------------------------------------------------

if ( ! function_exists('pdf_create'))
{
	function pdf_create($html, $filename='', $stream=TRUE) 
	{
		require_once("dompdf/dompdf_config.inc.php");
		
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->render();
		if ($stream) {
			$dompdf->stream($filename.".pdf");
		} else {
			return $dompdf->output();
		}
	}
}

/* End of file MP_date_helper.php */
/* Location: ./application/helpers/MP_date_helper.php */
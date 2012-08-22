<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stats extends Front_Controller {

	public function index()
	{
		
	}
	
	public function bannerclicked($banner_id)
	{
		if (!$this->mpbanners->click_banner($banner_id)) {
			show_404('Banner does not exists.');
		}
	}
}

/* End of file stats.php */
/* Location: ./application/controllers/stats.php */
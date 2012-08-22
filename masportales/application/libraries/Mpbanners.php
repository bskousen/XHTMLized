<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MPBanners {

	protected $CI;
	
	protected $banners_positions = false;
	
	protected $banners = false;
	
	protected $banners_printed;

	public function MPBanners()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('banners_model');
		
		foreach ($this->CI->banners_model->getBannersPositions() as $position) {
			// load banners positions
			$this->banners_positions->$position['keyword'] = $position;
			// load banners
			$params = array(
				'limit'			=> $position['quantity'],
				'order_by'	=> 'RAND()',
				'filter_by'	=> array('banner_position_ID', 'status'),
				'filter'		=> array($position['banner_position_ID'], 'activo')
			);
			$this->banners->$position['keyword'] = $this->CI->banners_model->getBanners($params);
			// 
			$this->banners_printed->$position['keyword']->quantity = $position['quantity'];
			$this->banners_printed->$position['keyword']->nprinted = 0;
			$this->banners_printed->$position['keyword']->n_banners = ($this->banners->$position['keyword']) ? count($this->banners->$position['keyword']) : 0;
		}
	}
	
	public function get_banners_positions()
	{
		return $this->banners_positions;
	}
	
	public function get_banners($position = null)
	{
		if ($position == null) {
			return $this->banners;
		} else {
			return $this->banners->$position;
		}
	}
	
	public function get_banners_printed()
	{
		return $this->banners_printed;
	}
	
	public function print_banner($position, $class = false)
	{
		$class = ($class) ? ' class="' . $class . '"' : ''; 
		if (property_exists($this->banners_printed, $position)
				and ($this->banners_printed->$position->quantity > $this->banners_printed->$position->nprinted)) {
			if ($this->banners_printed->$position->nprinted < $this->banners_printed->$position->n_banners) {
				$banner_key = $this->banners_printed->$position->nprinted;
				$banners = $this->banners->$position;
				$banner = $banners[$banner_key];
				$image_url = get_image_url($banner['image_uri'], $banner['width'] . 'x' . $banner['height'], _reg('site_url') . 'usrs/banners/');
				$link = $banner['link'];
				$link = _reg('site_url') . 'stats/bannerclicked/' . $banner['banner_ID'];
				$html = '<a href="' . $link . '" target="_blank" rel="nofollow"><img' . $class . ' src="' . $image_url . '" /></a>';
				$this->banners_printed->$position->nprinted++;
				$this->CI->banners_model->logBannerPrinted($banner['banner_ID']);
				echo $html;
			} else {
				$position_data = $this->banners_positions->$position;
				$image_url = site_url() . 'usrs/' . $position_data['type_name'] . '_' . $position_data['width'] . 'x' . $position_data['height'] . '.png';
				$this->banners_printed->$position->nprinted++;
				echo '<img' . $class . ' src="' . $image_url . '" />';
			}
		} else {
			return false;
		}
	}
	
	public function click_banner($banner_id)
	{
		if ($banner_data = $this->CI->banners_model->getBanner($banner_id)) {
			$this->CI->banners_model->logBannerClicked($banner_id);
			redirect(prep_url($banner_data['link']));
			return true;
		} else {
			return false;
		}
	}

}

/* End of file Banners.php */
/* Location: ./application/libraries/Banners.php */
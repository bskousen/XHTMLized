<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registry {

	protected $CI;
	
	protected $core = false;
	
	protected $site = false;
	
	protected $user = false;
	
	protected $module = false;
	
	protected $company = false;
	
	protected $request = false;
	
	protected $message = false;
	
	protected $fe_columns = false;
	
	protected $cart = false;

	public function Registry()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('registry_model');
		
		$http_host = explode('.', $_SERVER['HTTP_HOST']);
		
		
		$this->load_core_settings();
		$this->load_site_settings($http_host);
	}
	
	public function set($key, $value, $property)
	{
		$this->$property->$key = $value;
	}
	
	public function load_core_settings()
	{
		$tmp_vars = array();
		$this->core = new stdClass();
		foreach ($this->CI->registry_model->get_group('core') as $core_var) {
			$meta_key = $core_var->meta_key;
			$this->core->$meta_key = $core_var->meta_value;
		}
	}
	
	public function load_site_settings($http_host)
	{
		if ($http_host[1] == 'masportales') {
			$site_id = $this->CI->registry_model->get_site_id($http_host[0]);
		} else {
			$site_id = $this->CI->registry_model->get_site_id(implode('.', $http_host), 'domain');
		}
		
		if ($site_id) {
			$this->site = $this->CI->registry_model->get_site($site_id);
		} else {
			show_404('Website ' . implode('.', $http_host) . ' doesn\'t exist.');
		}
		
		foreach ($this->CI->registry_model->get_group('site', $this->site_id()) as $core_var) {
			$meta_key = $core_var->meta_key;
			$this->site->$meta_key = $core_var->meta_value;
		}
	}
	
	public function core($property = null)
	{
		if ($property) {
			return (property_exists($this->core, $property)) ? $this->core->$property : false;
		} else {
			return $this->core;
		}
	}
	
	public function base_url()
	{
		return (isset($this->core->base_url)) ? $this->core->base_url : false;
	}
	
	public function base_path()
	{
		return (isset($this->core->base_path)) ? $this->core->base_path : false;
	}
	
	public function admin_url()
	{
		return $this->site_url() . 'admin/';
	}
	
	public function account_url()
	{
		return $this->site_url() . 'micuenta/';
	}
	
	public function site($property = null, $owner_property = null)
	{
		if ($property) {
			if ($property != 'owner') {
				return (property_exists($this->site, $property)) ? $this->site->$property : false;
			} elseif ($owner_property) {
				return (property_exists($this->site->owner_data, $owner_property)) ? $this->site->owner_data->$owner_property : false;
			} else {
				return $this->site->owner_data;
			}
		} else {
			return $this->site;
		}
	}
	
	public function site_id()
	{
		return ($this->site) ? $this->site->site_ID : false;
	}
	
	public function site_url()
	{
		if ($this->site->domain) {
			$url = $this->site->domain;
		} else {
			$url = $this->site->subdomain . '.' . $this->core->base_domain;
		}
		
		return 'http://' . $url . '/';
	}
	
	public function site_name()
	{
		return $this->site->name . '+Portales';
	}
	
	public function theme_path()
	{
		$theme_path = false;
		if ($this->request->environment == 'front-end') {
			$theme_path = $this->core->application_folder . '/views/themes/' . $this->site->theme . '/';
		} elseif ($this->request->interface == 'back-end') {
			$theme_path = false;
		}
		return $theme_path;
		//return $this->core['application_folder'] . '/views/themes/' . $this->site->theme . '/';
	}
	
	public function css_path()
	{
		$css_path = false;
		if ($this->request->environment == 'front-end') {
			$css_path = $this->core->application_folder . '/views/themes/' . $this->site->theme . '/css/';
		} elseif ($this->request->interface == 'back-end') {
			$css_path = $this->core->application_folder . '/views/admin/css/';
		}
		return $css_path;
	}
	
	public function css_url()
	{
		$css_url = false;
		if ($this->request->environment == 'front-end') {
			$css_url = $this->site_url() . $this->core->application_folder . '/views/themes/' . $this->site->theme . '/css/';
		} elseif ($this->request->environment == 'back-end') {
			$css_url = $this->site_url() . $this->core->application_folder . '/views/admin/css/';
		}
		return $css_url;
	}
	
	public function microsite_css_url($theme_name = 'default') {
		return $this->site_url() . $this->core->application_folder . '/views/microsites/' . $theme_name . '/css/';
	}
	
	public function js_path()
	{
		$js_path = false;
		if ($this->request->environment == 'front-end') {
			$js_path = $this->core->application_folder . '/views/themes/' . $this->site->theme . '/js/';
		} elseif ($this->request->environment == 'back-end') {
			$js_path = $this->core['application_folder'] . '/views/admin/js/';
		}
		return $js_path;
	}
	
	public function js_url()
	{
		$js_url = false;
		if ($this->request->environment == 'front-end') {
			$js_url = $this->site_url() . $this->core->application_folder . '/views/themes/' . $this->site->theme . '/js/';
		} elseif ($this->request->environment == 'back-end') {
			$js_url = $this->site_url() . $this->core->application_folder . '/views/admin/js/';
		}
		return $js_url;
	}
	
	public function module_url()
	{
		$module_url = false;
		if ($this->request->environment == 'front-end') {
			$module_url = $this->site_url() . $this->request->module . '/';
		} elseif ($this->request->environment == 'back-end') {
			$module_url = $this->admin_url() . $this->request->module . '/';
		}
		return $module_url;
	}
	
	public function request($property = null)
	{
		if ($property) {
			return (property_exists($this->request, $property)) ? $this->request->$property : false;
		} else {
			return $this->request;
		}
	}
	/*
	public function module()
	{
		return $this->request->module;
	}
	*/
	public function section()
	{
		return $this->request->section;
	}
	
	public function action()
	{
		return $this->request->action;
	}
	
	public function set_meta($keyword, $value)
	{
		$this->request->meta->$keyword = $value;
	}
	
	public function get_meta($property = null)
	{
		if ($property) {
			return (property_exists($this->request, 'meta') and property_exists($this->request->meta, $property)) ? $this->request->meta->$property : false;
		} else {
			return (property_exists($this->request, 'meta')) ? $this->request->meta : false;
		}
	}
	
	public function user($keyword = null)
	{
		if ($keyword) {
			return (isset($this->user[$keyword])) ? $this->user[$keyword] : false;
		} else {
			return $this->user;
		}
	}
	
	public function set_user($user_data)
	{
		$this->user = $user_data;
	}
	
	public function company($keyword = null)
	{
		if ($keyword) {
			return $this->company[$keyword];
		} else {
			return $this->company;
		}
	}
	
	public function set_company($company_data)
	{
		$this->company = $company_data;
	}
	
	public function module($keyword = null)
	{
		if ($keyword) {
			return $this->module[$keyword];
		} else {
			return $this->module;
		}
	}
	
	public function set_module($module_data)
	{
		$this->module = $module_data;
	}
	
	public function message($keyword = null)
	{
		if ($keyword) {
			return $this->message[$keyword];
		} else {
			return $this->message;
		}
	}
	
	public function set_message($value, $keyword = null)
	{
		if ($keyword) {
			$this->message[$keyword] = $value;
		} else {
			$this->message = $value;
		}
	}
	
	public function column($column = null)
	{
		if ($column) {
			return (isset($this->fe_columns[$column])) ? $this->fe_columns[$column] : false;
		} else {
			return $this->fe_columns;
		}
	}
	
	public function column_item($item_name)
	{
		if (isset($this->fe_columns['items'][$item_name])) {
			return $this->fe_columns['items'][$item_name];
		} else {
			return false;
		}
	}
	
	public function set_column($module_name, $module_data, $column = 1)
	{
		$this->fe_columns[$column][$module_name] = $module_name;
		$this->fe_columns['items'][$module_name] = $module_data;
	}
	
	public function cart($keyword = null)
	{
		if ($keyword) {
			return (property_exists($this->cart, $keyword)) ? $this->cart->$keyword : false;
		} else {
			if ($this->cart->n_items) {
				return $this->cart;
			} else {
				return false;
			}
		}
	}
	
	public function set_cart($value, $keyword = null)
	{
		if ($keyword) {
			$this->cart->$keyword = $value;
		} else {
			$this->cart = $value;
		}
	}

}

/* End of file Registry.php */
/* Location: ./application/libraries/Registry.php */
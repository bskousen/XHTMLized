<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ecommerce extends Admin_Controller
{

	public function _index_index($params = array())
	{
		
	}
	
	public function _products_index($params = array())
	{
		$this->load->model('ecommerce_model');
		
		// search
		$search = $this->input->post('search', true);
		$this->registry->set('search', $search, 'request');
	
		
		//var_dump($params);
		//$params = array_merge($defaults, $params);
		// pagination
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 10;
		
		$params = array(
			'search_by'	=> ($search) ? 'pd.name' : false,
			'search'		=> $search,
			'start'			=> $pagination_start,
			'limit'			=> $per_page
		);

		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'products/index/page/',
			'uri_segment'	=> 6,
			'total_rows'	=> $this->ecommerce_model->getNProducts($params),
			'per_page'		=> $per_page
		);
		
		$this->pagination->initialize($config_pagination);
		
		return array(
			'products'		=> $this->ecommerce_model->getProducts($params),
			'pagination'	=> $this->pagination->create_links()
		);
	}
	
	public function _products_view($params = array())
	{
		$this->load->model('ecommerce_model');
		$product_id = (isset($params[1])) ? $params[1] : 0;
		
		return array(
			'product'					=> $this->ecommerce_model->getProduct($product_id),
			'product_images'	=> $this->ecommerce_model->getProductImages($product_id)
		);
	}

	
	public function _products_edit($params = array())
	{
		$this->load->model('ecommerce_model');
		$this->load->model('companies_model');

		$this->load->library('form_validation');
	
		$companies = $this->companies_model->getCompanies();
		
		$product_id = (isset($params[1])) ? $params[1] : 0;
		
		return array(
			'products'			=> $this->ecommerce_model->getProduct($product_id),	
			'product_images'	=> $this->ecommerce_model->getProductImages($product_id),
			'companies'			=> $companies
		);
	}
	
	public function _products_save()
	{
		$product_id = $this->input->post('pid');
		$this->load->model('ecommerce_model');
		$this->load->model('companies_model');

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
		$this->form_validation->set_message('matches', '\'%s\' y \'%s\' son distintos.');
		$this->form_validation->set_message('valid_email', 'El campo \'%s\' debe contener un email válido.');
		$this->form_validation->set_message('exact_length', 'El campo \'%s\' debe tener 9 carácteres.');
		$this->form_validation->set_message('is_unique', 'Ya existe producto con el \'%s\' indicado.');
		
		$this->form_validation->set_rules('name', 'Nombre del producto', 'trim|required|xss_clean');

		if ($product_id == 0) {
			$this->form_validation->set_rules('slug', 'URL Amigable', 'trim|required|is_unique[products_description.slug]|xss_clean');
		}
		$this->form_validation->set_rules('description', 'Descripción', 'trim|required|xss_clean');
		$this->form_validation->set_rules('meta_keywords', 'Descripción', 'trim|required|xss_clean');
		$this->form_validation->set_rules('meta_description', 'Descripción', 'trim|required|xss_clean');
		$this->form_validation->set_rules('price', 'Precio', 'trim|required|xss_clean');
		
		$this->form_validation->set_rules('company_ID', 'ID Compañia', 'trim|required|xss_clean');
		$this->form_validation->set_rules('image', 'Imagen del producto', 'trim|xss_clean');
		$this->form_validation->set_rules('model', 'Modelo', 'trim|xss_clean');
		$this->form_validation->set_rules('status', 'Estado', 'trim|numeric|xss_clean');
		$this->form_validation->set_rules('quantity', 'Cantidad', 'trim|numeric|xss_clean');
		$this->form_validation->set_rules('shipping', 'Envío', 'trim|required|xss_clean');
		$this->form_validation->set_rules('manufacturer', 'Fabricante', 'trim|xss_clean');
		

		if ($this->form_validation->run() == false) {
			$this->registry->set('action', 'edit', 'request');
		} else {
			$company_id = $this->input->post('company_ID');
			$data['product'] = array(
				'user_ID'					=> $this->companies_model->getCompanyOwner($company_id),
			  'company_ID'			=> $this->input->post('company_ID'),
			  'image'						=> $this->input->post('image'),
			  'price'						=> $this->input->post('price'),
			  'model' 					=> $this->input->post('model'),
			  'status'					=> $this->input->post('status'),
			  'quantity'				=> $this->input->post('quantity'),
			  'shipping'      	=> $this->input->post('shipping'),
			  'manufacturer_ID' => $this->input->post('manufacturer'),
			  'date_modified'		=> date('Y-m-d H:i:s')
			);

			$data['product_description'] = array(
				'name'							=> $this->input->post('name'),
				'slug'							=> $this->input->post('slug'),
				'description'				=> $this->input->post('description'),
				'meta_keywords'			=> $this->input->post('meta_keywords'),
				'meta_description'	=> $this->input->post('meta_description')
			);
			$tmp_images = array(
				'name'	=> $this->input->post('images_name'),
				'ext'		=> $this->input->post('images_ext'),
				'type'	=> $this->input->post('images_type')
			);
			$data['product_images'] = array();
			if ($tmp_images['name']) {
				foreach ($tmp_images['name'] as $key => $image_name) {
					$data['product_images'][$image_name] = array(
						'name'				=> $image_name,
						'ext'					=> $tmp_images['ext'][$key],
						'mime_type'		=> $tmp_images['type'][$key],
						'status'			=> 'publish',
						'date_added'	=> date('Y-m-d H:i:s')
					);
				}
			} else {
				$data['product_images'] = false;
			}
			$data['product_image_main'] = ($this->input->post('images_main') ? $this->input->post('images_main') : null);
			

			if ($product_id == 0) {
				$data['product']['date_added'] = date('Y-m-d H:i:s');
				if ($this->ecommerce_model->addProduct($data)) {
					$this->registry->set_message(array(
						'class'		=> 'success',
					  'content'	=> 'Producto guardado correctamente.'
					));
				} else {
					$this->registry->set_message(array(
						'class'		=> 'error',
					  'content'	=> 'Error al guardar el Producto.'
					));
				}
			} else {
					if ($this->ecommerce_model->saveProduct($data, $product_id)) {
					$this->registry->set_message(array(
						'class'		=> 'success',
						'content'	=> 'Producto guardado correctamente.'
					));
				} else {
					$this->registry->set_message(array(
						'class'		=> 'error',
						'content'	=> 'Error al guardar el product_id.'
					));
				}
			}
		}
			
			$this->load->model('companies_model');
			$companies = $this->companies_model->getCompanies();

			$this->registry->set('action', 'edit', 'request');

			return array(
				'products'			=> $this->ecommerce_model->getProduct($product_id),
				'product_images'	=> $this->ecommerce_model->getProductImages($product_id),
				'companies'			=> $companies
			);
	}
	
	public function _products_delete($params = array())
	{
		$this->load->model('ecommerce_model');
		$product_id = (isset($params[1])) ? $params[1] : 0;
		
		
		if ($this->ecommerce_model->deleteProduct($product_id)) {
			$this->registry->set_message(array(
				'class'		=> 'success',
			  'content'	=> 'Producto borrado correctamente.'
			));
		} else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Error al borrar el producto.'
			));
		}
		$this->registry->set('action','index', 'request');
		
		// pagination
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 10;
		
		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'products/index/page/',
			'uri_segment'	=> 6,
			'total_rows'	=> $this->ecommerce_model->getNProducts($params),
			'per_page'		=> $per_page
		);
		
		$this->pagination->initialize($config_pagination);
		
		return array(
			'products'		=> $this->ecommerce_model->getProducts(),
			'pagination'	=> $this->pagination->create_links()
		);
	}

}

/* End of file ecommerce.php */
/* Location: ./application/controllers/admin/ecommerce.php */
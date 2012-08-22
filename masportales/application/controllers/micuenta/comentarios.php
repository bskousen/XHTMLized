<?php

class Comentarios extends Account_Controller
{

	public function _index_index()
	{
		$this->load->model('users_model');
		
		echo '<pre>';
		print_r($this->input->post());
		echo '</pre>';
		
		if ($this->input->post('ctpe') and $this->input->post('cmid')) {
			$comment_ID = $this->input->post('cmid', true);
			switch ($this->input->post('ctpe', true)) {
				case 'blog':
					$this->load->model('blog_model');
					$this->blog_model->deleteBlogComment($comment_ID);
					break;
				case 'product':
					$this->load->model('ecommerce_model');
					$this->ecommerce_model->deleteProductComment($comment_ID);
					echo '<p>product</p>';
					break;
			}
		}
		
		return $this->users_model->getUserComments($this->registry->user('user_ID'));
	}

}

/* End of file comentarios.php */
/* Location: ./application/controllers/micuenta/comentarios.php */
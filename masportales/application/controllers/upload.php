<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Upload controller that extends API Controller
 *
 * This Controller must manage the file uploading from diferent modules
 *
 * @since 0.5
 *
 * @package masPortales
 * @subpackage API
 */
class Upload extends API_Controller {

	private $options;
	
	public function index($params=null)
	{	
		include_once(APPPATH . '/config/mp_upload.php');
		$module = $this->input->get_post('umod');
		
		$this->options = $options[$module];
		
		header('Pragma: no-cache');
		header('Cache-Control: private, no-cache');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');
		
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'OPTIONS':
				break;
			case 'HEAD':
			case 'GET':
				$this->_get();
				break;
			case 'POST':
				$this->_post();
				break;
			case 'DELETE':
			  $this->options['filename'] = basename(stripslashes($params));
			  $this->_delete();
			  break;
			default:
			  header('HTTP/1.1 405 Method Not Allowed');
		}
	}
	
	function _getFullUrl() {
		return
			(isset($_SERVER['HTTPS']) ? 'https://' : 'http://').
			(isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
			(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
			(isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] === 443 ||
			$_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
			substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
	}
	
	private function _get_file_object($file_name) {
	    $file_path = $this->options['upload_dir'].$file_name;
	    if (is_file($file_path) && $file_name[0] !== '.') {
	        $file = new stdClass();
	        $file->name = $file_name;
	        $file->size = filesize($file_path);
	        $file->url = $this->options['upload_url'].rawurlencode($file->name);
	        foreach($this->options['image_versions'] as $version => $options) {
	            if (is_file($options['upload_dir'].$file_name)) {
	                $file->{$version.'_url'} = $options['upload_url']
	                    .rawurlencode($file->name);
	            }
	        }
	        $file->delete_url = $this->options['script_url']
	            .'?file='.rawurlencode($file->name);
	        $file->delete_type = 'DELETE';
	        return $file;
	    }
	    return null;
	}
	
	private function _get_file_objects() {
	    return array_values(array_filter(array_map(
	        array($this, '_get_file_object'),
	        scandir($this->options['upload_dir'])
	    )));
	}
	
	private function _create_scaled_image($file_name, $options) {
	    $file_path = $this->options['upload_dir'] . $file_name;
	    $new_file_name = pathinfo($file_name, PATHINFO_FILENAME);
	    $new_file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
	    $new_file_path = $this->options['upload_dir'] . $new_file_name . '_' . $options['max_width'] . 'x' . $options['max_height'] . '.' . $new_file_ext;
	    list($img_width, $img_height) = @getimagesize($file_path);
	    if (!$img_width || !$img_height) {
	        return false;
	    }
	    $scale = min(
	        $options['max_width'] / $img_width,
	        $options['max_height'] / $img_height
	    );
	    if ($scale > 1) {
	        $scale = 1;
	    }
	    $new_width = $img_width * $scale;
	    $new_height = $img_height * $scale;
	    $new_img = @imagecreatetruecolor($new_width, $new_height);
	    switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
	        case 'jpg':
	        case 'jpeg':
	            $src_img = @imagecreatefromjpeg($file_path);
	            $write_image = 'imagejpeg';
	            break;
	        case 'gif':
	            @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
	            $src_img = @imagecreatefromgif($file_path);
	            $write_image = 'imagegif';
	            break;
	        case 'png':
	            @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
	            @imagealphablending($new_img, false);
	            @imagesavealpha($new_img, true);
	            $src_img = @imagecreatefrompng($file_path);
	            $write_image = 'imagepng';
	            break;
	        default:
	            $src_img = $image_method = null;
	    }
	    $success = $src_img && @imagecopyresampled(
	        $new_img,
	        $src_img,
	        0, 0, 0, 0,
	        $new_width,
	        $new_height,
	        $img_width,
	        $img_height
	    ) && $write_image($new_img, $new_file_path);
	    // Free up memory (imagedestroy does not delete files):
	    @imagedestroy($src_img);
	    @imagedestroy($new_img);
	    return $success;
	}
	
	private function _scale_image($file_name, $options)
	{
		$this->load->library('image_lib');
		
		$file_path = $this->options['upload_dir'] . $file_name;
		$new_file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $options['max_width'] . 'x' . $options['max_height'];
		$new_file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
		$new_file_path = $this->options['upload_dir'] . $new_file_name . '.' . $new_file_ext;
		$temp_file_path = $this->options['upload_dir'] . $new_file_name . '_tmp.' . $new_file_ext;
		list($img_width, $img_height) = @getimagesize($file_path);
		if (!$img_width || !$img_height) {
		    return false;
		}
		
		$scale = max(
			$options['max_width'] / $img_width,
			$options['max_height'] / $img_height
		);
		$new_width = $img_width * $scale;
		$new_height = $img_height * $scale;
		
		$config['image_library'] = 'gd2';
		$config['source_image']	= $this->options['upload_dir'] . $file_name;
		$config['create_thumb'] = false;
		$config['new_image'] = $temp_file_path;
		$config['maintain_ratio'] = true;
		$config['width'] = $new_width;
		$config['height']	= $new_height;
		
		$this->image_lib->initialize($config);
		$success = $this->image_lib->resize();
		$this->image_lib->clear();
		
		$config['image_library'] = 'gd2';
		$config['source_image']	= $temp_file_path;
		$config['new_image'] = $new_file_path;
		$config['maintain_ratio'] = false;
		$config['width'] = $options['max_width'];
		$config['height']	= $options['max_height'];
		$config['x_axis'] = (int) (($new_width - $options['max_width']) / 2);
		$config['y_axis'] = (int) (($new_height - $options['max_height']) / 2);
		
		$this->image_lib->initialize($config); 
		$success = $success && $this->image_lib->crop();
		
		$this->image_lib->clear();
		
		unlink($temp_file_path);
		
		if ($success) {
			return $new_file_name . '.' . $new_file_ext;
		} else {
			return false;
		}
	}
	
	private function _has_error($uploaded_file, $file, $error) {
	    if ($error) {
	        return $error;
	    }
	    if (!preg_match($this->options['accept_file_types'], $file->name)) {
	        return 'acceptFileTypes';
	    }
	    if ($uploaded_file && is_uploaded_file($uploaded_file)) {
	        $file_size = filesize($uploaded_file);
	    } else {
	        $file_size = $_SERVER['CONTENT_LENGTH'];
	    }
	    if ($this->options['max_file_size'] && (
	            $file_size > $this->options['max_file_size'] ||
	            $file->size > $this->options['max_file_size'])
	        ) {
	        return 'maxFileSize';
	    }
	    if ($this->options['min_file_size'] &&
	        $file_size < $this->options['min_file_size']) {
	        return 'minFileSize';
	    }
	    if (is_int($this->options['max_number_of_files']) && (
	            count($this->_get_file_objects()) >= $this->options['max_number_of_files'])
	        ) {
	        return 'maxNumberOfFiles';
	    }
	    return $error;
	}
	
	private function _trim_file_name($name, $type) {
	    // Remove path information and dots around the filename, to prevent uploading
	    // into different directories or replacing hidden system files.
	    // Also remove control characters and spaces (\x00..\x20) around the filename:
	    $file_name = trim(basename(stripslashes($name)), ".\x00..\x20");
	    // Add missing file extension for known image types:
	    if (strpos($file_name, '.') === false &&
	        preg_match('/^image\/(gif|jpe?g|png)/', $type, $matches)) {
	        $file_name .= '.'.$matches[1];
	    }
	    return $file_name;
	}
	
	private function _orient_image($file_path) {
	  	$exif = exif_read_data($file_path);
	  	$orientation = intval(@$exif['Orientation']);
	  	if (!in_array($orientation, array(3, 6, 8))) { 
	  	    return false;
	  	}
	  	$image = @imagecreatefromjpeg($file_path);
	  	switch ($orientation) {
	    	  case 3:
	      	    $image = @imagerotate($image, 180, 0);
	      	    break;
	    	  case 6:
	      	    $image = @imagerotate($image, 270, 0);
	      	    break;
	    	  case 8:
	      	    $image = @imagerotate($image, 90, 0);
	      	    break;
	      	default:
	      	    return false;
	  	}
	  	$success = imagejpeg($image, $file_path);
	  	// Free up memory (imagedestroy does not delete files):
	  	@imagedestroy($image);
	  	return $success;
	}
	
	private function _handle_file_upload($uploaded_file, $name, $size, $type, $error) {
		$file = new stdClass();
		$file->name = $this->_trim_file_name($name, $type);
		$file->filename = random_string('unique'); //pathinfo($file->name, PATHINFO_FILENAME);
  	$file->ext = strtolower(pathinfo($file->name, PATHINFO_EXTENSION));
		$file->size = intval($size);
		$file->type = $type;
		$error = $this->_has_error($uploaded_file, $file, $error);
		if (!$error && $file->name) {
			$file->name = $file->filename . '.' . $file->ext;
			$file_path = $this->options['upload_dir'].$file->name;
			$append_file = !$this->options['discard_aborted_uploads'] && is_file($file_path) && $file->size > filesize($file_path);
			clearstatcache();
			if ($uploaded_file && is_uploaded_file($uploaded_file)) {
				// multipart/formdata uploads (POST method uploads)
				if ($append_file) {
				  file_put_contents(
				  	$file_path,
				  	fopen($uploaded_file, 'r'),
				  	FILE_APPEND
				  );
				} else {
				  move_uploaded_file($uploaded_file, $file_path);
				}
			} else {
				// Non-multipart uploads (PUT method support)
				file_put_contents(
					$file_path,
					fopen('php://input', 'r'),
					$append_file ? FILE_APPEND : 0
				);
			}
			$file_size = filesize($file_path);
			if ($file_size === $file->size) {
				if ($this->options['_orient_image']) {
					$this->_orient_image($file_path);
				}
				$file->url = $this->options['upload_url'].rawurlencode($file->name);
				foreach($this->options['image_versions'] as $version => $options) {
					/*
					if ($version == '210x96') {
						if ($name = $this->_create_scaled_image($file->name, $options)) {
							$file->{'url_'.$version} = $options['upload_url'] . rawurlencode($name);
							$file->{'name_'.$version} = $name;
						}
					} else {
						if ($name = $this->_scale_image($file->name, $options)) {
							$file->{'url_'.$version} = $options['upload_url'] . rawurlencode($name);
							$file->{'name_'.$version} = $name;
						}
					}
					*/
					if ($name = $this->_scale_image($file->name, $options)) {
						$file->{'url_'.$version} = $options['upload_url'] . rawurlencode($name);
					  $file->{'name_'.$version} = $name;
					}
				}
			} else if ($this->options['discard_aborted_uploads']) {
				unlink($file_path);
				$file->error = 'abort';
			}
			$file->size = $file_size;
			$file->delete_url = $this->options['script_url'] . '/'.rawurlencode($file->name);
			$file->delete_type = 'DELETE';
		} else {
			$file->error = $error;
		}
		return $file;
	}
	
	public function _get() {
	    $file_name = isset($_REQUEST['file']) ?
	        basename(stripslashes($_REQUEST['file'])) : null;
	    if ($file_name) {
	        $info = $this->_get_file_object($file_name);
	    } else {
	        $info = $this->_get_file_objects();
	    }
	    header('Content-type: application/json');
	    echo json_encode($info);
	}
	
	public function _post() {
	    if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
	        return $this->_delete();
	    }
	    $upload = isset($_FILES[$this->options['param_name']]) ?
	        $_FILES[$this->options['param_name']] : null;
	    $info = array();
	    if ($upload && is_array($upload['tmp_name'])) {
	        foreach ($upload['tmp_name'] as $index => $value) {
	            $info[] = $this->_handle_file_upload(
	                $upload['tmp_name'][$index],
	                isset($_SERVER['HTTP_X_FILE_NAME']) ?
	                    $_SERVER['HTTP_X_FILE_NAME'] : $upload['name'][$index],
	                isset($_SERVER['HTTP_X_FILE_SIZE']) ?
	                    $_SERVER['HTTP_X_FILE_SIZE'] : $upload['size'][$index],
	                isset($_SERVER['HTTP_X_FILE_TYPE']) ?
	                    $_SERVER['HTTP_X_FILE_TYPE'] : $upload['type'][$index],
	                $upload['error'][$index]
	            );
	        }
	    } elseif ($upload || isset($_SERVER['HTTP_X_FILE_NAME'])) {
	        $info[] = $this->_handle_file_upload(
	            isset($upload['tmp_name']) ? $upload['tmp_name'] : null,
	            isset($_SERVER['HTTP_X_FILE_NAME']) ?
	                $_SERVER['HTTP_X_FILE_NAME'] : (isset($upload['name']) ?
	                    isset($upload['name']) : null),
	            isset($_SERVER['HTTP_X_FILE_SIZE']) ?
	                $_SERVER['HTTP_X_FILE_SIZE'] : (isset($upload['size']) ?
	                    isset($upload['size']) : null),
	            isset($_SERVER['HTTP_X_FILE_TYPE']) ?
	                $_SERVER['HTTP_X_FILE_TYPE'] : (isset($upload['type']) ?
	                    isset($upload['type']) : null),
	            isset($upload['error']) ? $upload['error'] : null
	        );
	    }
	    header('Vary: Accept');
	    $json = json_encode($info);
	    $redirect = isset($_REQUEST['redirect']) ?
	        stripslashes($_REQUEST['redirect']) : null;
	    if ($redirect) {
	        header('Location: '.sprintf($redirect, rawurlencode($json)));
	        return;
	    }
	    if (isset($_SERVER['HTTP_ACCEPT']) &&
	        (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
	        header('Content-type: application/json');
	    } else {
	        header('Content-type: text/plain');
	    }
	    echo $json;
	}
	
	public function _delete() {
		$file_path = $this->options['upload_dir'].$this->options['filename'];
		$success = is_file($file_path) && $this->options['filename'][0] !== '.' && unlink($file_path);
		if ($success) {
			$name = pathinfo($this->options['filename'], PATHINFO_FILENAME);
  		$ext = strtolower(pathinfo($this->options['filename'], PATHINFO_EXTENSION));
			foreach ($this->options['image_versions'] as $version => $options) {
				$file = $options['upload_dir'] . $name . '_' . $version . '.' . $ext;
				if (is_file($file)) {
					unlink($file);
				}
			}
		}
		header('Content-type: application/json');
		echo json_encode($success);
	}
}

/* End of file upload.php */
/* Location: ./application/controllers/upload.php */
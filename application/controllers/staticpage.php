<?php
class Staticpage extends MY_Controller {
	public function __construct() {
		parent::__construct ();
	}
	public function index() {
		$this->load->helper ( 'url' );
		redirect ( '/' );
	}
	public function _remap($page) {
		if (strlen ( $page ) == 0 || $page == 'index') {
			$this->index ();
		} else {
			$this->set_title ( $this->config->item ( 'app_name' ) );
			$data = array ();
			if(file_exists(APPPATH . 'views/static/' . $page . EXT)){
				$this->template->write_view ( 'content', 'static/' . $page, $data, true );
				$this->template->render ();
			} else {
				show_404();
			}
		}
	}
}

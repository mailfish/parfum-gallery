<?php
class ControllerCommonSearch extends Controller {
public function autocomplete() {
					$json = array();

					if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
						$this->load->model('catalog/product');
						$this->load->model('tool/image');

						if (isset($this->request->get['filter_name'])) {
							$filter_name = $this->request->get['filter_name'];
						} else {
							$filter_name = '';
						}

						if (isset($this->request->get['filter_model'])) {
							$filter_model = $this->request->get['filter_model'];
						} else {
							$filter_model = '';
						}

						if (isset($this->request->get['limit'])) {
							$limit = $this->request->get['limit'];
						} else {
							$limit = 5;
						}

						$filter_data = array(
							'filter_name'  => $filter_name,
							'filter_child' => 1,
							'start'        => 0,
							'limit'        => $limit
						);

						$results = $this->model_catalog_product->getProductsSearch($filter_data);

						foreach ($results as $result) {
							if (is_file(DIR_IMAGE . $result['image'])) {
								$image = $this->model_tool_image->resize($result['image'], 40, 40);
								$img ='<img src='.$image.' class="right circle">';
							} else {
								$image = $this->model_tool_image->resize('no_image.png', 40, 40);
								$img ='<img src='.$image.' class="right circle" width="40" height="40">';
							}
							$json[] = array(
								'product_id' => $result['product_id'],
								'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
								'img'        => $img,
								'sku'	     => $result['sku'],
								'status'     => $result['status']
							);
						}
					}

					$this->response->addHeader('Content-Type: application/json');
					$this->response->setOutput(json_encode($json));
				}
	public function index() {
$data['product_path'] = $this->url->link('product/product');
		$this->load->language('common/search');

		$data['text_search'] = $this->language->get('text_search');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		return $this->load->view('common/search', $data);
	}
}
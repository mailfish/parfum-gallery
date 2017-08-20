<?php
class ControllerCommonHeader extends Controller {
	public function index() {
$css = file_get_contents('catalog/view/theme/materialize/stylesheet/style.css');
				$css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
				$css = str_replace(': ', ':', $css);
				$css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
				$data['css'] = $css;
		// Analytics
		$this->load->model('extension/extension');

		$data['analytics'] = array();

		$analytics = $this->model_extension_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get($analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('extension/analytics/' . $analytic['code'], $this->config->get($analytic['code'] . '_status'));
			}
		}

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->load->model('tool/image');
				$icon_type = exif_imagetype($server . 'image/' . $this->config->get('config_icon'));
				if ($icon_type == 1) {$icon_type = 'image/gif';}
				if ($icon_type == 2) {$icon_type = 'image/jpeg';}
				if ($icon_type == 3) {$icon_type = 'image/png';}
				if ($icon_type == 17) {$icon_type = 'image/x-icon';}
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 16, 16), 'icon', $icon_type, '16x16');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 32, 32), 'icon', $icon_type, '32x32');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 48, 48), 'icon', $icon_type, '48x48');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 96, 96), 'icon', $icon_type, '96x96');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 128, 128), 'icon', $icon_type, '128x128');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 160, 160), 'icon', $icon_type, '160x160');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 196, 196), 'icon', $icon_type, '196x196');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 228, 228), 'icon', $icon_type, '228x228');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 256, 256), 'icon', $icon_type, '256x256');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 57, 57), 'apple-touch-icon', $icon_type, '57x57');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 60, 60), 'apple-touch-icon', $icon_type, '60x60');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 72, 72), 'apple-touch-icon', $icon_type, '72x72');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 76, 76), 'apple-touch-icon', $icon_type, '76x76');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 114, 114), 'apple-touch-icon', $icon_type, '114x114');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 120, 120), 'apple-touch-icon', $icon_type, '120x120');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 144, 144), 'apple-touch-icon', $icon_type, '144x144');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 152, 152), 'apple-touch-icon', $icon_type, '152x152');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 167, 167), 'apple-touch-icon', $icon_type, '167x167');
				$this->document->addLink($this->model_tool_image->resize($this->config->get('config_icon'), 180, 180), 'apple-touch-icon', $icon_type, '180x180');
		}

		$data['title'] = $this->document->getTitle();

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$data['name'] = $this->config->get('config_name');
$data['email'] = $this->config->get('config_email');
			$data['open'] = nl2br($this->config->get('config_open'));

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
list($logo_width, $logo_height) = getimagesize($data['logo']);
				$data['logo_height'] = $logo_height;
				$data['logo_width'] = $logo_width;
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');
$data['quicksignup'] = $this->load->controller('common/quicksignup');
				$data['signin_or_register'] = $this->language->get('signin_or_register');
		$data['og_url'] = (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')) ? HTTPS_SERVER : HTTP_SERVER) . substr($this->request->server['REQUEST_URI'], 1, (strlen($this->request->server['REQUEST_URI'])-1));
		$data['og_image'] = $this->document->getOgImage();

		$data['text_home'] = $this->language->get('text_home');

		// Wishlist
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');

			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
		} else {
			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}

		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));

		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_page'] = $this->language->get('text_page');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');
$data['text_contact'] = $this->language->get('text_contact');
				$data['text_about'] = $this->language->get('text_about');
				$data['text_delivery'] = $this->language->get('text_delivery');
				$data['text_call_back'] = $this->language->get('text_call_back');
				$data['text_call_free'] = $this->language->get('text_call_free');

		$data['home'] = $this->url->link('common/home');
$data['compare'] = $this->url->link('product/compare');
				$this->language->load('product/compare');
				$data['text_compare'] = sprintf((isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
				$data['text_comparison_list'] = $this->language->get('text_comparison_list');
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$children_data[] = array(
						'name' => ($this->config->get('config_product_count') ? '<span class="new-badge" data-badge="' . $this->model_catalog_product->getTotalProducts($filter_data) . '">' . $child['name'] . '</span>' : $child['name']),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}

				// Level 1
				$data['categories'][] = array(
'id'       => $category['category_id'],
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');

		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} elseif (isset($this->request->get['information_id'])) {
				$class = '-' . $this->request->get['information_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

		return $this->load->view('common/header', $data);
	}
}

<?php

namespace Financi;

use Symfony\Component\Yaml\Yaml;

class Menu
{
	static $menu = [

		'cadastros' => [
			'descricao' => 'Cadastro',
			'items' => [
				'matricula' => [
					'link' => '/clientes',
					'descricao' => 'Clientes'
				],
				'enturmacao' => [
					'link' => '/lotes',
					'descricao' => 'Lotes'
				],
				
			]
		]
	];

	static public function getMenu($menu)
	{
		$config = Yaml::parse(APP_CONFIG_PATH . DS . 'app.yml');
		return $config[$menu];
	}

	static public function render($menu)
	{
		$io_menu = new ioMenu();
		$io_menu->setAttributes(['class'=>'nav navbar-nav']);

		foreach (static::getMenu($menu) as $menu) {
			$io_menu->addChild($menu['descricao'], isset($menu['link']) ? $menu['link'] : '#' );

			if (isset($menu['link']) && $menu['link'] !== '#') {
				// if (!\Financi\User::isPermited($menu['link'])) {
				// 	$io_menu->removeChild($menu['descricao']);
				// 	continue;
				// }
			}

			if(isset($menu['items'])) {
				$name = $menu['descricao'] . ' <b class="caret"></b>';
				$io_menu[$menu['descricao']]->setName($name);

				foreach ($menu['items'] as $item) {

					// if (isset($item['link']) && $item['link'] !== '#') {
					// 	if (!\Financi\User::isPermited($item['link'])) {
					// 		continue;
					// 	}
					// }

					$io_menu[$name]->setAttributes(['class'=>'dropdown']);
					$io_menu[$name]->setLinkOptions(['class'=>'dropdown-toggle', 'data-toggle'=>'dropdown']);
					$io_menu[$name]->addChild($item['descricao'], $item['link']);
				}
			}

			if(isset($menu['items'])) {
				if ( ! count($io_menu[$menu['descricao'] . ' <b class="caret"></b>']->getChildren())) {
					$io_menu->removeChild($menu['descricao'] . ' <b class="caret"></b>');
				}
			}
		}

		return $io_menu->render();
	}

	static public function renderForAll()
	{
		$ul = '<ul>';
		$li = '';
		$ulsubmenu = '';
		foreach(\Financi\User::getAllPermissions() as $k=>$m) {	
				$li .= '<li';
				if ( is_array($m) ) {

					$li .= '>';
					$li .= '<a href="javascript://" class="inactive">'.strtoupper($k).'</a>';
					$ulsubmenu = '<ul>';
					foreach($m as $n) {
						$ulsubmenu .= '<li><a class="inactive" href="javascript://">'.$n.'</a></li>';
					}
					$ulsubmenu .= '</ul>';
				} else {
					$li .= '><a class="inactive" href="javascript://"> ' . $m . '</a>';
				}
				$li .= $ulsubmenu;
				$ulsubmenu = '';
				$li .= '</li>';
			}
		//}
		$ul .= $li;
		$ul .= '</ul>';

		return $ul;
	}
}

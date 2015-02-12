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
        $elements = [
            'li' => '<li>
                        <a href="%s" class="navigation-link">
                            <i class="hide toggle-icon fa fa-%s"></i>
                            <span>%s</span>
                        </a>
                    </li>',

            'li-menu' => '<li data-position="%s">
                            <a href="%s" class="navigation-link">
                                <i class="hide toggle-icon fa fa-%s"></i>
                                <i class="fa fa-angle-down pull-right"></i>
                                <span>%s</span>
                            </a>
                            <ul class="sub-menu">%s</ul>
                        </li>',

            'li-sub' => '<li>
                            <a href="%s" class="navigation-link">%s</a>
                        </li>'
        ];

        $html = '';

        foreach (static::getMenu($menu) as $name => $childs) {

        	if (isset($childs['items'])) {
        		
        		$lis = '';

                foreach ($childs['items'] as $child) {
                    $lis .= sprintf($elements['li-sub'], $child['link'], $child['descricao']);
                }

                $html .= sprintf($elements['li-menu'], '', '#', $childs['icon'], $childs['descricao'], $lis);
        	} else {
        		$html .= sprintf($elements['li'], '#', $childs['icon'], $childs['descricao']);
        	}
        }

        return $html;
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

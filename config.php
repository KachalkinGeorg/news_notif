<?php

if (!defined('NGCMS')) die ('HAL');

pluginsLoadConfig();
LoadPluginLang('news_notif', 'config', '', '', '#');

switch ($_REQUEST['action']) {
	case 'about':			about();		break;
	default: main();
}

function about()
{global $twig, $lang, $breadcrumb;
	$tpath = locatePluginTemplates(array('main', 'about'), 'news_notif', 1);
	$breadcrumb = breadcrumb('<i class="fa fa-comment-o btn-position"></i><span class="text-semibold">'.$lang['news_notif']['news_notif'].'</span>', array('?mod=extras' => '<i class="fa fa-puzzle-piece btn-position"></i>'.$lang['extras'].'', '?mod=extra-config&plugin=news_notif' => '<i class="fa fa-comment-o btn-position"></i>'.$lang['news_notif']['news_notif'].'',  '<i class="fa fa-exclamation-circle btn-position"></i>'.$lang['news_notif']['about'].'' ) );

	$xt = $twig->loadTemplate($tpath['about'].'about.tpl');
	$tVars = array();
	$xg = $twig->loadTemplate($tpath['main'].'main.tpl');
	
	$about = 'версия 0.1';
	
	$tVars = array(
		'global' => 'О плагине',
		'header' => $about,
		'entries' => $xt->render($tVars)
	);
	
	print $xg->render($tVars);
}

function main()
{global $twig, $lang, $breadcrumb;
	
	$tpath = locatePluginTemplates(array('main', 'general.from'), 'news_notif', 1);
	$breadcrumb = breadcrumb('<i class="fa fa-comment-o btn-position"></i><span class="text-semibold">'.$lang['news_notif']['news_notif'].'</span>', array('?mod=extras' => '<i class="fa fa-puzzle-piece btn-position"></i>'.$lang['extras'].'', '?mod=extra-config&plugin=news_notif' => '<i class="fa fa-comment-o btn-position"></i>'.$lang['news_notif']['news_notif'].'' ) );

	if (isset($_REQUEST['submit'])){
		pluginSetVariable('news_notif', 'localsource', (int)$_REQUEST['localsource']);
		pluginSetVariable('news_notif', 'limit', intval($_REQUEST['limit']));
		pluginsSaveConfig();
		msg(array("type" => "info", "info" => "сохранение прошло успешно"));
		return print_msg( 'info', ''.$lang['news_notif']['news_notif'].'', 'Cохранение прошло успешно', '?mod=extra-config&plugin=news_notif' );
	}

	$limit = pluginGetVariable('news_notif', 'limit');
	$limit = '<option value="5000" '.($limit==5000?'selected':'').'>по умолчанию</option><option value="10000" '.($limit==10000?'selected':'').'>10сек</option><option value="30000" '.($limit==30000?'selected':'').'>30сек</option><option value="120000" '.($limit==120000?'selected':'').'>1мин</option>';
	
	$xt = $twig->loadTemplate($tpath['general.from'].'general.from.tpl');
	$xg = $twig->loadTemplate($tpath['main'].'main.tpl');
	
	$tVars = array(
		'localsource'       => MakeDropDown(array(0 => 'Шаблон сайта', 1 => 'Плагина'), 'localsource', (int)pluginGetVariable('news_notif', 'localsource')),
		'limit' => $limit,
	);
	
	$tVars = array(
		'global' => 'Общие',
		'header' => '<i class="fa fa-exclamation-circle"></i> <a href="?mod=extra-config&plugin=news_notif&action=about">'.$lang['news_notif']['about'].'</a>',
		'entries' => $xt->render($tVars)
	);
	
	print $xg->render($tVars);
}

?>
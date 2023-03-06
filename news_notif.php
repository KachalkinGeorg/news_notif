<?php

if (!defined('NGCMS')) die ('HAL');

add_act('index', 'news_notif');

function news_notif() {
	global $lang, $template, $mysql, $twig, $userROW;
	
	$new = 0;
	$query = "select id, title, author, approve from " . prefix . "_news where approve = 0 order by id desc";
    foreach ($mysql->select($query) as $row) {
		$alert .= '<br><b>&raquo; '.$row['title'].'</b><br>';
		$new++;
	}

	$tpath = locatePluginTemplates(array('skins/notif'), 'news_notif', pluginGetVariable('news_notif', 'localsource'));
	$xt = $twig->loadTemplate($tpath['skins/notif'].'skins/notif.tpl');
	
	$limit = pluginGetVariable('news_notif', 'limit') ? pluginGetVariable('news_notif', 'limit') : '5000';
	
	$tVars = array(
		'news_alert' 	=> $alert,
		'news_text' 	=> '<b style="font-size:14px">ВНИМАНИЕ '.$row['author'].'!!!</b>',
		'news_info'		=> 'У Вас есть '.$new.' новости ожидающие модерацию:',
		'limit' 		=> $limit,
	);

	if ($row['approve'] != '') {
		$xtpl = $xt->render($tVars);
	}else{
		$xtpl = '';
	}
	
	if (is_array($userROW) && ($userROW['status'] == 1 || $userROW['status'] == 2)) {
		$template['vars']['news_notif'] = $xtpl;
	}else{
		$template['vars']['news_notif'] = '';
	}

}

?>
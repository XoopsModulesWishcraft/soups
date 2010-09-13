<?php

	include ( '../../mainfile.php' );
	
	$op = !empty($_REQUEST['op']) ? strtolower($_REQUEST['op']) : 'display';
	$id = !empty($_REQUEST['id']) ? (int)($_REQUEST['id']) : 0;
	
	$compoundHandler =& xoops_getmodulehandler('compound', 'compounds');
	$uidLinkHandler =& xoops_getmodulehandler('uid_link', 'compounds');
	$compound = $compoundHandler->get($id);
	
	if (!is_object($compound)) {
		redirect_header('index.php', 5, sprintf(_SUP_INFO_NOID, $id));
		exit(0);
	}

	if (!is_object($GLOBALS['xoopsUser']))
		$sql = "UPDATE ".$GLOBALS['xoopsDB']->prefix('compound'). ' SET hits = hits +1, runners = runners + 1 WHERE id = ' . $id;
	else
		$sql = "UPDATE ".$GLOBALS['xoopsDB']->prefix('compound'). ' SET hits = hits +1 WHERE id = ' . $id;
	@$GLOBALS['xoopsDB']->queryF($sql);
		
	if (!is_object($GLOBALS['xoopsUser']))
		$sql = "UPDATE ".$GLOBALS['xoopsDB']->prefix('uid_link'). ' SET hits = hits +1, runners = runners + 1 WHERE uid = ' . $compound->getVar('uid');
	else
		$sql = "UPDATE ".$GLOBALS['xoopsDB']->prefix('uid_link'). ' SET hits = hits +1 WHERE uid = ' . $compound->getVar('uid');
	@$GLOBALS['xoopsDB']->queryF($sql);	
	
	$compound = $compoundHandler->get($id);
		
	switch($op) {
	case 'display':
	default:
			$xoopsOption['template_main'] = "compounds_info.html";
			include XOOPS_ROOT_PATH . '/header.php';
			
			$compound['symbol'] = $compoundHandler->renderSymbolisation($compound->getVar('symbol'));
			$compound['hyposise'] = htmlspecialchars_decode($compound->language->getVar('hyposise'));
			$compound['process'] = htmlspecialchars_decode($compound->language->getVar('process'));
			$compound['synopsise'] = htmlspecialchars_decode($compound->language->getVar('process'));
			$compound['views'] = intval($compound->getVar('hits'));
			$compound['runners'] = intval($compound->getVar('runners'));
			$compound['id'] = intval($compound->getVar('id'));
			$compound['stars'] = sprintf('%01.2f', intval(($compound->getVar('stars')/$compound->getVar('votes'))*10));
			
			$user_handler = xoops_gethandler('user');
			$uuser = $user_handler->get($compound->getVar('uid'));
			$ulink = $uidLinkHandler->get($compound->getVar('uid'));

			$user['views'] = intval($ulink->getVar('hits'));
			$user['runners'] = intval($ulink->getVar('runners'));
			$user['stars'] = sprintf('%01.2f', intval(($compound->getVar('stars')/$compound->getVar('votes'))*10));
			$user['uname'] = $uuser->getVar('uname');
			$user['name'] = $uuser->getVar('name');
			$user['url'] = $uuser->getVar('url');
			$user['profile_url'] = XOOPS_URL.'/userinfo.php?uid='.$compound->getVar('uid');
			$xoopsTpl->assign('user', $user);			
			$xoopsTpl->assign('compound', $compound);
			
			include_once XOOPS_ROOT_PATH . "/include/comment_view.php";
			
			include XOOPS_ROOT_PATH . '/footer.php';
		break;
	}
<?php

	include ( '../../mainfile.php' );
	include_once 'include/form.compound.php';
	
	$op = !empty($_REQUEST['op']) ? strtolower($_REQUEST['op']) : 'display';
	$id = !empty($_REQUEST['id']) ? (int)($_REQUEST['id']) : 0;
	
	$compoundHandler =& xoops_getmodulehandler('compound', 'compounds');
	$voteDataHandler =& xoops_getmodulehandler('votedata', 'compounds');
	$compound = $compoundHandler->get($id);
	
	$session['id'] = intval($id);
	$session['ip'] = $_SERVER['REMOTE_ADDR'];
	$session['addy'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	
	$criteria = new CriteriaCompo(new Criteria('id', $id));
	$criteria->add(new Criteria('ip', $session['ip']));
	$criteria->add(new Criteria('addy', $session['addy']));
	
	if ($voteDataHandler->getCount($criteria)) {
		redirect_header('info.php?id='.$id, 4, sprintf(_SUP_VOTE_ALREADYTAKEN, $compoundHandler->renderSymbolisation($compound->getVar('symbol')),$session['ip']));
		exit(0);
	}
		
	switch($op) {
	case 'vote':
	
		if ($session['ip'] == $_POST['ip'] &&  $session['addy'] == gethostbyaddr($_SERVER['REMOTE_ADDR']))
		{
	
			$sql = "UPDATE ".$GLOBALS['xoopsDB']->prefix('compound'). ' SET votes = votes +1, stars = stars + '.$_POST['stars'].' WHERE id = ' . $id;
			@$GLOBALS['xoopsDB']->queryF($sql);
				
			$sql = "UPDATE ".$GLOBALS['xoopsDB']->prefix('uid_link'). ' SET votes = votes +1, stars = stars + '.$_POST['stars'].' WHERE uid = ' . $compound->getVar('uid');
			@$GLOBALS['xoopsDB']->queryF($sql);	

			$votedata = $voteDataHandler->create();
			$votedata->setVar('id', $id);
			$votedata->setVar('ip', $session['ip']);
			$votedata->setVar('addy', $session['addy']);
			$votedata->setVar('created', time());
			$voteDataHandler->insert($votedata);
		
			redirect_header('info.php?id='.$id, 4, sprintf(_SUP_VOTE_TAKEN, $compoundHandler->renderSymbolisation($compound->getVar('symbol')),$session['ip']));
		} else {
			redirect_header('info.php?id='.$id, 4, sprintf(_SUP_VOTE_UNMATCHED, $compoundHandler->renderSymbolisation($compound->getVar('symbol')),$session['ip']));
		}
		exit(0);

	case 'display':
	default:
			$xoopsOption['template_main'] = "compounds_vote.html";
			include XOOPS_ROOT_PATH . '/header.php';
		
			$xoopsTpl->assign('compound_symbol', $compoundHandler->renderSymbolisation($compound->getVar('symbol')));			
			$xoopsTpl->assign('voteform', formVote($session));
			
			include_once XOOPS_ROOT_PATH . "/include/comment_view.php";
			
			include XOOPS_ROOT_PATH . '/footer.php';
		break;
	}	
	
?>
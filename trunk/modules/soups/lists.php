<?php

	include_once ( '../../mainfile.php' );
	include_once ( '../../class/pagenav.php' );

	$userHandler =& xoops_gethandler('user');
	$compoundHandler =& xoops_getmodulehandler('compound', 'compounds');
	$periodicalHandler =& xoops_getmodulehandler('periodical', 'compounds');
	$chainLinkHandler =& xoops_getmodulehandler('chain_link', 'compounds');
	$chainComponentsHandler =& xoops_getmodulehandler('chain_components', 'compounds');
	$uidLinkHandler =& xoops_getmodulehandler('uid_link', 'compounds');
	
	$sql = "SELECT SUM(`donations`) as ttlDonations FROM " . $GLOBALS['xoopsDB']->prefix('uid_link');
	
	list($donation) = $GLOBALS['xoopsDB']->fetchRow($GLOBALS['xoopsDB']->queryF($sql));
	
		$sql = "SELECT SUM(`amount`) as ttlAmount FROM " . $GLOBALS['xoopsDB']->prefix('uid_link');
	
	list($amount) = $GLOBALS['xoopsDB']->fetchRow($GLOBALS['xoopsDB']->queryF($sql));
	
	$donations['total_done'] = empty($donation)?'0':$donation;
	$donations['total_cash'] = empty($amount)?'0.0000':$amount;
	
	$userSubmissions['count'] = $compoundHandler->getCount(new Criteria('uid', '0', '>'));
	$molecularSubmissions['count'] = $compoundHandler->getCount(NULL);
	$sevendaySubmissions['count'] = $compoundHandler->getCount(new Criteria('created', time() - (((60*60)*24)*7), '>'));
	$criteria = new CriteriaCompo(new Criteria('created', time() - (((60*60)*24)*7), '<'));
	$criteria->add(new Criteria('created', time() - (((60*60)*24)*14), '>'));	
	$forteendaySubmissions['count'] = $compoundHandler->getCount($criteria);
	
	$userSubmissions['url']  = '<a href="'.XOOPS_URL.'/modules/compounds/lists.php?op=users">'.$userSubmissions['count'].'</a>';
	
	$molecularSubmissions['url']  = '<a href="'.XOOPS_URL.'/modules/compounds/lists.php?op=molecular">'.$molecularSubmissions['count'].'</a>';
	
	$sevendaySubmissions['url']  = '<a href="'.XOOPS_URL.'/modules/compounds/lists.php?op=sevenday">'.$sevendaySubmissions['count'].'</a>';
	
	$forteendaySubmissions['url']  = '<a href="'.XOOPS_URL.'/modules/compounds/lists.php?op=forteenday">'.$forteendaySubmissions['count'].'</a>';
	
	$op = !empty($_REQUEST['op'])?strtolower($_REQUEST['op']):'default';
	$id = !empty($_REQUEST['id']) ?(int)($_REQUEST['id']):0;
	$itmppg = !empty($_REQUEST['itmppg']) ?(int)($_REQUEST['itmppg']):30;
	$start = !empty($_REQUEST['start']) ?(int)($_REQUEST['start']):0;
	
	switch ($_REQUEST['fct']) {
	default:
	case 'molecular':
		$pgnav = new XoopsPageNav($molecularSubmissions['count'], $itmppg, $start);
		$criteria = new Criteria('id', '0', '<>');
		break;
	case 'sevenday':
		$pgnav = new XoopsPageNav($sevendaySubmissions['count'], $itmppg, $start);
		$criteria = new Criteria('created', time() - (((60*60)*24)*7), '>');
		break;
	case 'forteenday':	
		$pgnav = new XoopsPageNav($forteendaySubmissions['count'], $itmppg, $start);
		$criteria = new CriteriaCompo(new Criteria('created', time() - (((60*60)*24)*7), '<'));
		$criteria->add(new Criteria('created', time() - (((60*60)*24)*14), '>'));
		break;

	}
	$criteria->setOrder('created');
	$criteria->setStart($start);
	$criteria->setLimit($itmppg);
	
	$xoopsOption['template_main'] = "compounds_list.html";
	include XOOPS_ROOT_PATH . '/header.php';
	
	$xoopsTpl->assign('pagnav', $pgnav->renderNav());
	
	$xoopsTpl->assign('userSubmissions', $userSubmissions);
	$xoopsTpl->assign('molecularSubmissions', $molecularSubmissions);
	$xoopsTpl->assign('sevendaySubmissions', $sevendaySubmissions);
	$xoopsTpl->assign('forteendaySubmissions', $forteendaySubmissions);
	$xoopsTpl->assign('donations', $donations);
	
	foreach($compoundHandler->getObjects($criteria, true) as $key => $object)
	{
		$compounds[$key] = array_unique(array_merge($object->toArray(), $object->language->toArray()));
		$compounds[$key]['rendersymbol'] = $compoundHandler->renderSymbolisation($object->getVar('symbol'));
		$user = $userHandler->get($object->getVar('uid'));
		$compounds[$key]['user'] = '<a href="' . XOOPS_URL . '/userinfo.php?uid=' . $user->getVar('uid') . '">' . $user->getVar('uname') . '</a>';
		$compounds[$key]['made'] = date(_DATESTRING, $object->getVar('created'));
		$xoopsTpl->append('compounds', $compounds[$key]);	
	}	
	include XOOPS_ROOT_PATH . '/footer.php';
?>
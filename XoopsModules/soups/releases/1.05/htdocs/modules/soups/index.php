<?php

	include ( '../../mainfile.php' );
	
	$op = !empty($_REQUEST['op']) ? strtolower($_REQUEST['op']) : 'new';
	$id = !empty($_REQUEST['id']) ? (int)($_REQUEST['id']) : 0;
	
	include_once 'include/form.compound.php';
	include_once 'include/functions.php';

	$module_handler =& xoops_gethandler('module');
	$xoModule = $module_handler->getByDirname('compounds');
	$config_handler =& xoops_gethandler('config');
	$xoConfigs = $config_handler->getConfigList($xoModule->getVar('mid'));		

	switch ( $op )
	{		
		case 'save':
			
			if ($_REQUEST['hyposise_editor_current'] != $_REQUEST['hyposise_editor'] || $_REQUEST['process_editor_current'] != $_REQUEST['process_editor'] || $_REQUEST['synopsise_editor_current'] != $_REQUEST['synopsise_editor'] ) {
				$forms['modeller'] = formCompound($id);
				
				$xoopsOption['template_main'] = "compounds_index.html";
				include XOOPS_ROOT_PATH . '/header.php';
				$xoopsTpl->assign('xoconfig', $xoConfigs);
				$xoopsTpl->assign('form', $forms);
				
				include XOOPS_ROOT_PATH . '/footer.php';
				exit(0);
			}
			
			switch ($_REQUEST['fct']) {
			case "edit":
				saveEditCompound(intval($_REQUEST['compound_id']));
				break;
			case "new":
			default:
				saveNewCompound();
			break;
			}
		default:
		case 'edit':

			$uidLinkHandler =& xoops_getmodulehandler('uid_link', 'compounds');
			if (is_object($GLOBALS['xoopsUser'])) {
				$uidlink = $uidLinkHandler->get($GLOBALS['xoopsUser']->getVar('uid'));
				if (!is_object($uidlink))
					$uidlink = $uidLinkHandler->create();
					
				if ($uidlink->getVar('score')>$xoConfigs['score'] && $xoConfigs['collectcash'])
				{
					$forms['donations'] = formDonation($id);
					$donations = $uidlink->getVar('donations');
					$donations['number'] = empty($donations)?'0':(string)$donations;
					$amount = $uidlink->getVar('amount');
					$donations['amount'] = empty($amount)?'0.0000':(string)$amount;
					$xoopsOption['template_main'] = "compounds_matrix.html";
					include XOOPS_ROOT_PATH . '/header.php';
						
					$xoopsTpl->assign('form', $forms);
					$xoopsTpl->assign('donations', $donations);
					
					include XOOPS_ROOT_PATH . '/footer.php';		
					exit(0);		
				}
			}
						
			$forms['modeller'] = formCompound($id);
			
			$xoopsOption['template_main'] = "compounds_index.html";
			include XOOPS_ROOT_PATH . '/header.php';
				
			$xoopsTpl->assign('form', $forms);
			
			include XOOPS_ROOT_PATH . '/footer.php';

		case 'new':
	
			$uidLinkHandler =& xoops_getmodulehandler('uid_link', 'compounds');
			if (is_object($GLOBALS['xoopsUser'])) {
				$uidlink = $uidLinkHandler->get($GLOBALS['xoopsUser']->getVar('uid'));
				if (!is_object($uidlink))
					$uidlink = $uidLinkHandler->create();
					
				if ($uidlink->getVar('score')>$xoConfigs['score'] && $xoConfigs['collectcash'])
				{
					$forms['donations'] = formDonation($id);
					$donations = $uidlink->getVar('donations');
					$donations['number'] = empty($donations)?'0':(string)$donations;
					$amount = $uidlink->getVar('amount');
					$donations['amount'] = empty($amount)?'0.0000':(string)$amount;
					$xoopsOption['template_main'] = "compounds_matrix.html";
					include XOOPS_ROOT_PATH . '/header.php';
						
					$xoopsTpl->assign('form', $forms);
					$xoopsTpl->assign('donations', $donations);
					
					include XOOPS_ROOT_PATH . '/footer.php';		
					exit(0);		
				}
			}
			
			
			$forms['modeller'] = formCompound($id);
			
			$xoopsOption['template_main'] = "compounds_index.html";
			include XOOPS_ROOT_PATH . '/header.php';
			$xoopsTpl->assign('xoconfig', $xoConfigs);
			$xoopsTpl->assign('form', $forms);
			
			include XOOPS_ROOT_PATH . '/footer.php';
			
	}

?>
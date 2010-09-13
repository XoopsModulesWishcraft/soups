<?php
	
	include 'header.php';
	include_once '../include/form.compound.php';
	include_once '../include/functions.php';
	include_once '../../../class/pagenav.php';
	
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
	$criteria = new CriteriaCompo(new Criteria('created', time() - (((60*60)*24)*7), '>'));
	$criteria->add(new Criteria('created', time() - (((60*60)*24)*14), '<'));
	$forteendaySubmissions['count'] = $compoundHandler->getCount($criteria);
	
	$userSubmissions['url']  = '<a href="'.XOOPS_URL.'/modules/compounds/admin/index.php?op=list&fct=users">'.$userSubmissions['count'].'</a>';
	
	$molecularSubmissions['url']  = '<a href="'.XOOPS_URL.'/modules/compounds/admin/index.php?op=list&fct=molecular">'.$molecularSubmissions['count'].'</a>';
	
	$sevendaySubmissions['url']  = '<a href="'.XOOPS_URL.'/modules/compounds/admin/index.php?op=list&fct=sevenday">'.$sevendaySubmissions['count'].'</a>';
	
	$forteendaySubmissions['url']  = '<a href="'.XOOPS_URL.'/modules/compounds/admin/index.php?op=list&fct=forteenday">'.$forteendaySubmissions['count'].'</a>';
	
	$op = !empty($_REQUEST['op'])?strtolower($_REQUEST['op']):'default';
	$id = !empty($_REQUEST['id']) ?($_REQUEST['id']):0;
	$itmppg = !empty($_REQUEST['itmppg']) ?(int)($_REQUEST['itmppg']):30;
	$start = !empty($_REQUEST['start']) ?(int)($_REQUEST['start']):0;
	
	xoops_cp_header();
	
	switch ($op) {
	case 'delete':

		switch ($_REQUEST['fct']) {
		case "composites":
			$compositeHandler =& xoops_getmodulehandler('composite', 'compounds');
			$composite = $compositeHandler->getObjects(new Criteria('id', $id), false);		
			
			if (!is_object($composite[0])) {
				redirect_header(XOOPS_URL.'/modules/compounds/admin/index.php?op=composite', 4, _SUP_AM_ITEM_DOESNT_EXIST);					
				exit(0);
			}
			
			if (!isset($_POST['confirm'])) {
				xoops_cp_header();
				xoops_confirm(array('confirm'=>true, 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct'],  'id'=>$_REQUEST['id']), $_SERVER['REQUEST_URI'], sprintf(_SUP_FRM_COMPOSITE_DELETE, $composite[0]->getVar('symbol')));
				xoops_cp_footer();
				exit(0);
			}
						
			$sql = array();
			$sql[0] = "DELETE FROM ".$GLOBALS['xoopsDB']->prefix('composite') . ' WHERE id = '.$composite[0]->getVar('id');
			$sql[1] = "DELETE FROM ".$GLOBALS['xoopsDB']->prefix('compounds_language') . ' WHERE composite_id = '.$composite[0]->getVar('id');			
			$GLOBALS['xoopsDB']->queryF($sql[0]);
			$GLOBALS['xoopsDB']->queryF($sql[1]);		

			
			redirect_header(XOOPS_URL.'/modules/compounds/admin/index.php?op=composite', 4, sprintf(_SUP_AM_COMPOSITE_DELETED, $composite[0]->getVar('symbol')));					
			break;
		case "numberof":

			$numberofHandler =& xoops_getmodulehandler('numberof', 'compounds');
			$numberof = $numberofHandler->getObjects(new Criteria('id', $id), false);		
			
			if (!is_object($numberof[0])) {
				redirect_header(XOOPS_URL.'/modules/compounds/admin/index.php?op=numberof', 4, _SUP_AM_ITEM_DOESNT_EXIST);					
				exit(0);
			}
			
			if (!isset($_POST['confirm'])) {
				xoops_cp_header();
				xoops_confirm(array('confirm'=>true, 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct'],  'id'=>$_REQUEST['id']), $_SERVER['REQUEST_URI'], sprintf(_SUP_FRM_NUMBEROF_DELETE, $numberof[0]->getVar('symbol')));
				xoops_cp_footer();
				exit(0);
			}
			
			$sql = array();			
			$sql[0] = "DELETE FROM ".$GLOBALS['xoopsDB']->prefix('numberof') . ' WHERE id = '.$numberof[0]->getVar('id');
			$sql[1] = "DELETE FROM ".$GLOBALS['xoopsDB']->prefix('compounds_language') . ' WHERE numberof_id = '.$numberof[0]->getVar('id');			
			$GLOBALS['xoopsDB']->queryF($sql[0]);
			$GLOBALS['xoopsDB']->queryF($sql[1]);			
			
			redirect_header(XOOPS_URL.'/modules/compounds/admin/index.php?op=numberof', 4, sprintf(_SUP_AM_NUMBEROF_DELETED, $numberof[0]->getVar('symbol')));					
			break;
		case "periodical":
			$periodicalHandler =& xoops_getmodulehandler('periodical', 'compounds');		
			$periodical = $periodicalHandler->getObjects(new Criteria('id', $id), false);		
			
			if (!is_object($periodical[0])) {
				redirect_header(XOOPS_URL.'/modules/compounds/admin/index.php?op=periodical', 4, _SUP_AM_ITEM_DOESNT_EXIST);					
				exit(0);
			}
			
			if (!isset($_POST['confirm'])) {
				xoops_cp_header();
				xoops_confirm(array('confirm'=>true, 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct'],  'id'=>$_REQUEST['id']), $_SERVER['REQUEST_URI'], sprintf(_SUP_FRM_PERIODICAL_DELETE, $periodical[0]->getVar('symbol')));
				xoops_cp_footer();
				exit(0);
			}
			
			$sql = array();			
			$sql[0] = "DELETE FROM ".$GLOBALS['xoopsDB']->prefix('periodical') . ' WHERE id = '.$periodical[0]->getVar('id');
			$sql[1] = "DELETE FROM ".$GLOBALS['xoopsDB']->prefix('compounds_language') . ' WHERE periodic_id = '.$periodical[0]->getVar('id');			
			$GLOBALS['xoopsDB']->queryF($sql[0]);
			$GLOBALS['xoopsDB']->queryF($sql[1]);			
			
			redirect_header(XOOPS_URL.'/modules/compounds/admin/index.php?op=periodical', 4, sprintf(_SUP_AM_PERIODICAL_DELETED, $periodical[0]->getVar('symbol')));					
			break;
		default:
			$compound = $compoundHandler->getObjects(new Criteria('id', $id), false);
			$sql = array();
			$sql[0] = "DELETE FROM ".$GLOBALS['xoopsDB']->prefix('chain_link') . ' WHERE chain_id = '.$compound[0]->getVar('chain_id');
			$sql[1] = "DELETE FROM ".$GLOBALS['xoopsDB']->prefix('chain_components') . ' WHERE chain_id = '.$compound[0]->getVar('chain_id');
			$sql[2] = "DELETE FROM ".$GLOBALS['xoopsDB']->prefix('compound') . ' WHERE id = '.$id;		
			if ($GLOBALS['xoopsDB']->queryF($sql[0]))
				if ($GLOBALS['xoopsDB']->queryF($sql[1]))
					if ($GLOBALS['xoopsDB']->queryF($sql[2])) {
					
						$uidLinkHandler =& xoops_getmodulehandler('uid_link', 'compounds');
						$uidlink = $uidLinkHandler->get($compound[0]->getVar('uid'));
						if (!is_object($uidlink)) {
							$uidlink = $uidLinkHandler->create();
							$uidlink->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
						}
						$submission = intval($uidlink->getVar('submissions'));
						$submission--;
						$uidlink->setVar('submissions', $submission);
						@$uidLinkHandler->insert($uidlink);
	
						redirect_header(XOOPS_URL.'/modules/compounds/admin/index.php?op=list', 4, sprintf(_SUP_AM_COMPOUNDDELETE_SUCCESSFUL, $compoundHandler->renderSymbolisation($compound[0]->getVar('symbol'))));
					} else
						redirect_header(XOOPS_URL.'/modules/compounds/admin/index.php?op=list', 4, sprintf(_SUP_AM_COMPOUNDDELETE_UNSUCCESSFUL, $compoundHandler->renderSymbolisation($compound[0]->getVar('symbol'))));
				else
					redirect_header(XOOPS_URL.'/modules/compounds/admin/index.php?op=list', 4, sprintf(_SUP_AM_COMPOUNDDELETE_UNSUCCESSFUL, $compoundHandler->renderSymbolisation($compound[0]->getVar('symbol'))));
			else
				redirect_header(XOOPS_URL.'/modules/compounds/admin/index.php?op=list', 4, sprintf(_SUP_AM_COMPOUNDDELETE_UNSUCCESSFUL, $compoundHandler->renderSymbolisation($compound[0]->getVar('symbol'))));					
			exit(0);
		}
				
	case 'save':
		
		switch ($_REQUEST['fct']) {
		case "composites":
			if (is_array($id)) {
				saveCompositeList($_POST);			
			} else {
				saveComposite($_POST);
			}
			break;
		case "numberof":
			if (is_array($id)) {
				saveNumberofList($_POST);			
			} else {
				saveNumberof($_POST);
			}
			break;
		case "periodical":
			if (is_array($id)) {
				savePeriodicalList($_POST);			
			} else {
				savePeriodical($_POST);
			}
			break;
		case "edit":	
			if ($_REQUEST['hyposise_editor_current'] != $_REQUEST['hyposise_editor'] || $_REQUEST['process_editor_current'] != $_REQUEST['process_editor'] || $_REQUEST['synopsise_editor_current'] != $_REQUEST['synopsise_editor'] ) {
				echo function_exists("loadModuleAdminMenu") ? loadModuleAdminMenu(2) : "";
				echo '<div style="border:dotted; height: 1.5em; clear:both; margin-bottom:8px; padding-top: 3px; padding-bottom: 3px; padding-right: 4px;">
				<div style="float:left; border-right:dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_USER_SUBMISSIONS.$userSubmissions['url'].'</div>
				<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_MOLECULAR_SUBMISSIONS.$molecularSubmissions['url'].'</div>
				<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_7DAY_SUBMISSIONS.$sevendaySubmissions['url'].'</div>
				<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_DONATIONS_SOFAR.$donations['total_done'].'</div>
				<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_TOTAL_CASH.$donations['total_cash'].'</div>
			</div>';
				echo formCompound($id);
				echo chronolabs_inline(false);
				xoops_cp_footer();
				exit(0);
			}
			saveEditCompound(intval($_REQUEST['compound_id']));
			break;
		case "new":
		default:
			if ($_REQUEST['hyposise_editor_current'] != $_REQUEST['hyposise_editor'] || $_REQUEST['process_editor_current'] != $_REQUEST['process_editor'] || $_REQUEST['synopsise_editor_current'] != $_REQUEST['synopsise_editor'] ) {
				echo function_exists("loadModuleAdminMenu") ? loadModuleAdminMenu(2) : "";
				echo '<div style="border:dotted; height: 1.5em; clear:both; margin-bottom:8px; padding-top: 3px; padding-bottom: 3px; padding-right: 4px;">
				<div style="float:left; border-right:dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_USER_SUBMISSIONS.$userSubmissions['url'].'</div>
				<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_MOLECULAR_SUBMISSIONS.$molecularSubmissions['url'].'</div>
				<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_7DAY_SUBMISSIONS.$sevendaySubmissions['url'].'</div>
				<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_DONATIONS_SOFAR.$donations['total_done'].'</div>
				<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_TOTAL_CASH.$donations['total_cash'].'</div>
			</div>';
				echo formCompound($id);
				echo chronolabs_inline(false);
				xoops_cp_footer();
				exit(0);
			}
			saveNewCompound();
		break;
		}
	case 'list':
		echo function_exists("loadModuleAdminMenu") ? loadModuleAdminMenu(2) : "";
		echo '<div style="border:dotted; height: 1.5em; clear:both; margin-bottom:8px; padding-top: 3px; padding-bottom: 3px; padding-right: 4px;">
		<div style="float:left; border-right:dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_USER_SUBMISSIONS.$userSubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_MOLECULAR_SUBMISSIONS.$molecularSubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_7DAY_SUBMISSIONS.$sevendaySubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">14 Day Submissions: '.$forteendaySubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_DONATIONS_SOFAR.$donations['total_done'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_TOTAL_CASH.$donations['total_cash'].'</div>	
	</div>';

		switch ($_REQUEST['fct']) {
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
			$criteria = new CriteriaCompo(new Criteria('created', time() - (((60*60)*24)*7), '>'));
			$criteria->add(new Criteria('created', time() - (((60*60)*24)*14), '<'));
			break;
		default:
		case 'users':
			$pgnav = new XoopsPageNav($userSubmissions['count'], $itmppg, $start);
			$criteria = new Criteria('uid', '0', '>');
			break;
		}
		$criteria->setOrder('created');
		$criteria->setStart($start);
		$criteria->setLimit($itmppg);
		
		echo '<div style="clear:both; float:right;">' . $pgnav->renderNav() . '</div>';
		
		echo formList($compoundHandler->getObjects($criteria, true), $compoundHandler);
		break;
		
	default:
	case 'edit':
		echo function_exists("loadModuleAdminMenu") ? loadModuleAdminMenu(1) : "";
		echo '<div style="border:dotted; height: 1.5em; clear:both; margin-bottom:8px; padding-top: 3px; padding-bottom: 3px; padding-right: 4px;">
		<div style="float:left; border-right:dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_USER_SUBMISSIONS.$userSubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_MOLECULAR_SUBMISSIONS.$molecularSubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_7DAY_SUBMISSIONS.$sevendaySubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">14 Day Submissions: '.$forteendaySubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_DONATIONS_SOFAR.$donations['total_done'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_TOTAL_CASH.$donations['total_cash'].'</div>	
	</div>';

		switch ($_REQUEST['fct']) {
		case "composites":
			echo formNewComposite($id);
			break;
		case "numberof":
			echo formNewNumberof($id);
			break;
		case "periodical":
			echo formNewPeriodical($id);
			break;
		default:
		case "edit":
			echo formCompound($id);
			break;
		}
		break;

	case 'new':
		echo function_exists("loadModuleAdminMenu") ? loadModuleAdminMenu(2) : "";
		echo '<div style="border:dotted; height: 1.5em; clear:both; margin-bottom:8px; padding-top: 3px; padding-bottom: 3px; padding-right: 4px;">
		<div style="float:left; border-right:dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_USER_SUBMISSIONS.$userSubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_MOLECULAR_SUBMISSIONS.$molecularSubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_7DAY_SUBMISSIONS.$sevendaySubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_DONATIONS_SOFAR.$donations['total_done'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_TOTAL_CASH.$donations['total_cash'].'</div>
	</div>';
		echo formCompound($id);
		break;
	
	case 'periodical':
		echo function_exists("loadModuleAdminMenu") ? loadModuleAdminMenu(3) : "";
		echo '<div style="border:dotted; height: 1.5em; clear:both; margin-bottom:8px; padding-top: 3px; padding-bottom: 3px; padding-right: 4px;">
		<div style="float:left; border-right:dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_USER_SUBMISSIONS.$userSubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_MOLECULAR_SUBMISSIONS.$molecularSubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_7DAY_SUBMISSIONS.$sevendaySubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_DONATIONS_SOFAR.$donations['total_done'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_TOTAL_CASH.$donations['total_cash'].'</div>
	</div>';
		echo formNewPeriodical();
		echo formPeriodical();
		break;

	case 'numberof':
		echo function_exists("loadModuleAdminMenu") ? loadModuleAdminMenu(4) : "";
		echo '<div style="border:dotted; height: 1.5em; clear:both; margin-bottom:8px; padding-top: 3px; padding-bottom: 3px; padding-right: 4px;">
		<div style="float:left; border-right:dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_USER_SUBMISSIONS.$userSubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_MOLECULAR_SUBMISSIONS.$molecularSubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_7DAY_SUBMISSIONS.$sevendaySubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_DONATIONS_SOFAR.$donations['total_done'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_TOTAL_CASH.$donations['total_cash'].'</div>
	</div>';
		echo formNewNumberof();
		echo formNumberof();
		break;
		
	case 'composites':
		echo function_exists("loadModuleAdminMenu") ? loadModuleAdminMenu(5) : "";
		echo '<div style="border:dotted; height: 1.5em; clear:both; margin-bottom:8px; padding-top: 3px; padding-bottom: 3px; padding-right: 4px;">
		<div style="float:left; border-right:dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_USER_SUBMISSIONS.$userSubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_MOLECULAR_SUBMISSIONS.$molecularSubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_7DAY_SUBMISSIONS.$sevendaySubmissions['url'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_DONATIONS_SOFAR.$donations['total_done'].'</div>
		<div style="float:left; border-right: dotted; padding-left:10px; padding-right:10px;">'._SUP_AM_HEADER_TOTAL_CASH.$donations['total_cash'].'</div>
	</div>';
		echo formNewComposite();
		echo formComposite();
		break;		

	}
	
	echo chronolabs_inline(false);
	xoops_cp_footer();
?>


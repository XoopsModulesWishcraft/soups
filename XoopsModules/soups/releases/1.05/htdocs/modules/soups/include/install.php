<?php

function xoops_module_pre_install_soups($module)
{
	$module_handler =& xoops_gethandler('module');
	$xoModule = $module_handler->getByDirname('compounds');
	if (!is_object($xoModule)) {
		xoops_error(_SUP_ERROR_COMPOUND_MODULE);
		return false;
	} else {
		if ($xoModule->getVar('version')<218) {
			xoops_error(_SUP_ERROR_COMPOUND_MODULE);
			return false;		
		}
	}
	return true;
}

?>
<?php
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

global $adminmenu;

$adminmenu = array();

$adminmenu[]= array("link"    	=> "admin/index.php",
                    "title"    	=> _SUP_AM_SOUPINDEX,
					"icon"		=> "images/soupindex.png");
$adminmenu[]= array("link"    	=> "admin/index.php?op=list",
                    "title"    	=> _SUP_AM_SOUPLIST,
					"icon"		=> "images/souplist.png");
$adminmenu[]= array("link"    	=> "admin/index.php?op=new",
                    "title"    	=> _SUP_AM_SOUPNEW,
					"icon"		=> "images/soupnew.png");
$adminmenu[]= array("link"    	=> "admin/index.php?op=compounds",
                    "title"    	=> _SUP_AM_COMPOUNDS,
					"icon"		=> "images/compounds.png");					

?>
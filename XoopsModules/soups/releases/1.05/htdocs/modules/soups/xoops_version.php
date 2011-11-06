<?php
/**
 * Private message module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code 
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         pm
 * @since           2.3.0
 * @author          Jan Pedersen
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id$
 */
 
/**
 * This is a temporary solution for merging XOOPS 2.0 and 2.2 series
 * A thorough solution will be available in XOOPS 3.0
 *
 */

$modversion = array();
$modversion['name'] = _SUP_MI_NAME;
$modversion['version'] = 1.05;
$modversion['description'] = _SUP_MI_DESC;
$modversion['author'] = "Simon Roberts (simon@chronolabs.coop)";
$modversion['credits'] = "My wife Niki";
$modversion['license'] = "GPL 2.0 - See docs/LICENCE.TXT";
$modversion['image'] = "images/soups_slogo.png";
$modversion['dirname'] = "soups";

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/admin.php";
$modversion['adminmenu'] = "admin/menu.php";

// Mysql file
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Table
$modversion['tables'][1] = "soups";
$modversion['tables'][2] = "soups_chain_link";
$modversion['tables'][3] = "soups_chain_components";
$modversion['tables'][4] = "soups_uid_link";
$modversion['tables'][5] = "soups_votedata";

// Scripts to run upon installation or update
$modversion['onInstall'] = "include/install.php";
//$modversion['onUpdate'] = "include/update.php";

// Menus
$modversion['sub'][1]['name'] = _SUP_MI_LISTALL;
$modversion['sub'][1]['url'] = "lists.php?op=soups";
$modversion['sub'][2]['name'] = _SUP_MI_7DAY;
$modversion['sub'][2]['url'] = "lists.php?op=sevenday";
$modversion['sub'][3]['name'] = _SUP_MI_14DAY;
$modversion['sub'][3]['url'] = "lists.php?op=forteenday";

// Templates
$modversion['templates'] = array();
$modversion['templates'][1]['file'] = 'soups_index.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = 'soups_info.html';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file'] = 'soups_vote.html';
$modversion['templates'][3]['description'] = '';
$modversion['templates'][4]['file'] = 'soups_list.html';
$modversion['templates'][4]['description'] = '';
$modversion['templates'][5]['file'] = 'soups_new.html';
$modversion['templates'][5]['description'] = '';
$modversion['templates'][6]['file'] = 'soups_admin_index.html';
$modversion['templates'][6]['description'] = '';
$modversion['templates'][7]['file'] = 'soups_admin_info.html';
$modversion['templates'][7]['description'] = '';
$modversion['templates'][8]['file'] = 'soups_admin_list.html';
$modversion['templates'][8]['description'] = '';
$modversion['templates'][9]['file'] = 'soups_admin_new.html';
$modversion['templates'][9]['description'] = '';

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'id';
$modversion['comments']['pageName'] = 'info.php';

// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment_functions.php';
$modversion['comments']['callback']['approve'] = 'soups_com_approve';
$modversion['comments']['callback']['update'] = 'soups_com_update';

// Menu
$modversion['hasMain'] = 1;

$modversion['config'][]=array(
	'name' => 'components',
	'title' => '_SUP_MI_COMPONENTS',
	'description' => '_SUP_MI_COMPONENTS_DESC',
	'formtype' => 'select',
	'valuetype' => 'text',
	'options' => array(2 => 2, 4 => 4, 6 => 6, 10 => 10, 12 => 12, 15 => 15, 17 => 17, 20 => 20, 30 => 30, 35 => 35, 40 => 40, 60 => 60, 80 => 80, 100 => 100),
	'default' => 10);
	
?>
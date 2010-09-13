<?php

function soups_com_update($item_id, $total_num)
{
	$soupHandler =& xoops_getmodulehandler('soups', 'soups');
	$uidLinkHandler =& xoops_getmodulehandler('uid_link', 'soups');
	$soup = $soupHandler->get($item_id);
	$uidLink = $uidLinkHandler->get($soup->getVar('uid'));
	$soup->setVar('comments', $total_num)
	$ucomments = $uidLink->getVar('comments');
	$ucomments++;
	$uidLink->setVar('comments', $ucomments);
	@$soupHandler->insert($soup);
	@$uidLinkHandler->insert($uidLink);
} 

function soup_com_approve(&$comment)
{ 
    // notification mail here
} 


?>
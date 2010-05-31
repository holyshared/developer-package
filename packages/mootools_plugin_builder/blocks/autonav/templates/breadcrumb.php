<?php  
	defined('C5_EXECUTE') or die(_("Access Denied."));
	$aBlocks = $controller->generateNav();
	$c = Page::getCurrentPage();
	$nh = Loader::helper('navigation');
	$i = 0;
	foreach($aBlocks as $ni) {
		$_c = $ni->getCollectionObject();
		if (!$_c->getCollectionAttributeValue('exclude_nav')) {	

			$pageLink = false;
			
			if ($_c->getCollectionAttributeValue('replace_link_with_first_in_nav')) {
				$subPage = $_c->getFirstChild();
				if ($subPage instanceof Page) {
					$pageLink = $nh->getLinkToCollection($subPage);
				}
			}
			
			if (!$pageLink) {
				$pageLink = $ni->getURL();
			}

			if ($i > 0) {
				print ' <span class="ccm-autonav-breadcrumb-sep">&gt;</span> ';
			}
			if ($c->getCollectionID() == $_c->getCollectionID()) { 
				echo($ni->getName());
			} else {
				echo('<a href="' . $pageLink . '">' . $ni->getName() . '</a>');
			}	
			$lastLevel = $thisLevel;
			$i++;
		}
	}
	
	$thisLevel = 0;
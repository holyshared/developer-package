<?php 
	defined('C5_EXECUTE') or die(_("Access Denied."));
	$aBlocks = $controller->generateNav();
	$c = Page::getCurrentPage();
	$containsPages = false;
	
	$nh = Loader::helper('navigation');
	
	//this will create an array of parent cIDs 
	$inspectC = $c;
	$selectedPathCIDs = array( $inspectC->getCollectionID() );
	$parentCIDnotZero = true;	
	while ($parentCIDnotZero) {
		$cParentID = $inspectC->cParentID;
		if(!intval($cParentID)) {
			$parentCIDnotZero = false;
		}else{
			$selectedPathCIDs[] = $cParentID;
			$inspectC = Page::getById($cParentID);
		}
	}

	$pageTitle = "";
	$parentID = $c->getCollectionParentID();
	if ($displayPagesCID > 0) {	
		$page = Page::getById($displayPagesCID);
		$pageTitle = $page->getCollectionName();
	} else if ($parentID > 1) {
		$page = Page::getById($parentID);
		$pageTitle = $page->getCollectionName();
	} else {
		$pageTitle = $c->getCollectionName();
	}
?>
<div class="mod corner aside">
	<div class="inner">
		<div class="hd local">
			<h3 class="h4"><?php echo $pageTitle ?></h3>
		</div>
		<div class="bd">
<?php

	foreach($aBlocks as $ni) {
		$_c = $ni->getCollectionObject();
		if (!$_c->getCollectionAttributeValue('exclude_nav')) {
			if (!$containsPages) {
				// this is the first time we've entered the loop so we print out the UL tag
				echo("<ul class=\"nav-local\">");
			}
			
			$containsPages = true;
			
			$thisLevel = $ni->getLevel();
			if ($thisLevel > $lastLevel) {
				echo("<ul>");
			} else if ($thisLevel < $lastLevel) {
				for ($j = $thisLevel; $j < $lastLevel; $j++) {
					if ($lastLevel - $j > 1) {
						echo("</li></ul>");
					} else {
						echo("</li></ul></li>");
					}
				}
			} else if ($i > 0) {
				echo("</li>");
			}

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

			if ($c->getCollectionID() == $_c->getCollectionID()) { 
				echo('<li class="nav-selected nav-path-selected"><a class="nav-selected nav-path-selected" href="' . $pageLink . '">' . $ni->getName() . '</a>');
			} elseif ( in_array($_c->getCollectionID(),$selectedPathCIDs) ) { 
				echo('<li class="nav-path-selected"><a class="nav-path-selected" href="' . $pageLink . '">' . $ni->getName() . '</a>');
			} else {
				echo('<li><a href="' . $pageLink . '">' . $ni->getName() . '</a>');
			}	
			$lastLevel = $thisLevel;
			$i++;
			
			
		}
	}
	
	$thisLevel = 0;
	if ($containsPages) {
		for ($i = $thisLevel; $i <= $lastLevel; $i++) {
			echo("</li></ul>");
		}
	}

?>

		</div>
	</div>
</div>
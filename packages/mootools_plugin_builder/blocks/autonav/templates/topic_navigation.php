<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
$aBlocks = $controller->generateNav();
$c = Page::getCurrentPage();
$nh = Loader::helper('navigation');
$i = 0;

echo '<ul class="nav-topic">';
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

$link = "";
if ($i > 0) {
$link .= "&gt; ";
}
if ($c->getCollectionID() == $_c->getCollectionID()) {
$link = '<li>'.$link.$ni->getName().'</li>';
} else {
$link = '<li>'.$link.'<a href="' . $pageLink . '">' . $ni->getName() . '</a></li>';
}
echo $link;

$lastLevel = $thisLevel;
$i++;
}
}
echo '</ul>';
$thisLevel = 0;
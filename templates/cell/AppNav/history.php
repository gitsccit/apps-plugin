<?php
$history = [];
if (isset($links) && sizeof($links)) {
    foreach ($links as $link) {
        $history[] = ['content' => $this->Html->link($link, $link),'children' => false];
    }
}

?>
<?= $this->element('Apps.ul_recursive', ['id' => "app-submenu-" . $sequence,'display' => ($sequence == 1),'links' => $history]);

<?php
$apps = [];
foreach($links as $link)
    $apps[] = ['content' => $this->Html->link($link->name,$link->route),'children' => false];
?>
<?= $this->element('Apps.ul_recursive',['id' => "app-submenu-".$sequence,'display' => ($sequence == 1),'links' => $apps]) ?>

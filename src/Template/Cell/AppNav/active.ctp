<div>
    <h4 id="app-submenu-title"><?= $title ?></h4>
    <a href="javascript:void(0)" onclick="app_nav_toggle()"><span class="icon-left-open"></span></a>
</div>
<?= $this->element('ul-recursive',['id' => "app-submenu-".$sequence,'display' => ($sequence == 1),'links' => $links,'handler' => 'active']) ?>

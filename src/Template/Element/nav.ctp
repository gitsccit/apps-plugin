<?php
$session = $this->getRequest()->getSession();
$history = $session->read('BrowsingHistory');

//TODO naming convention for our variables e.g under_score and method based camel case
?>
<div id="apps-navcolumn">
    <div id="apps-navcolumn-1">
        <ul>
            <li><a id="hamburger" href="javascript:void(0)" onclick="app_nav_toggle()"><span class="icon-menu"></span></a></li>
            <li class="active"><a href="javascript:void(0)" id="nav-current" onclick="app_nav_select(this,1,'Admin')" title="Admin"><span class="icon-applicationicon"></span></a></li>
            <li><a href="javascript:void(0)" id="nav-history" onclick="app_nav_select(this,2,'Recently Viewed')" title="History"><span class="icon-clock"></span></a></li>
            <li><a href="javascript:void(0)" id="nav-apps" onclick="app_nav_select(this,3,'Apps')" title="Apps"><span class="icon-th"></span></a></li>
        </ul>
    </div>
    <div id="apps-navcolumn-2">
        <div class="appnav">
            <?= $this->cell('AppNav::active',[1]) ?>
            <?= $this->cell('AppNav::history',[2,$history]) ?>
            <?= $this->cell('AppNav::apps',[3]) ?>
        </div>
    </div>
</div>

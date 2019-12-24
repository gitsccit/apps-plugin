<?php
$userldapid = $this->request->getSession()->read('Auth.User.ldapid');
$username = $this->request->getSession()->read('Auth.User.display_name');
?>
<header>
    <div id="global-search-container"><div id="global-search-results"></div><a href="javascript:void(0)" onclick="app_global_search_finish(false)"><span class="icon-sort-up"></span></a></div>
    <form id="global-search" action="<?= $this->Url->build(['controller' => 'Search','action' => 'query','plugin' => 'Apps']) ?>" method="GET" onsubmit="return app_global_search_handler(event)">
        <input id="global-search-input" type="text" size="30" placeholder="Search" onkeyup="app_global_search_keyup(this)">
        <input type="submit" value="Search">
        <span class="icon-search"></span>
    </form>
    <nav>
        <ul id="header-actions" class="navmenu">
            <li><a href="javascript:void(0)" title="SCC Intranet"><span class="icon-home"></span></a></li>
            <li><a href="javascript:void(0)" title="Support"><span class="icon-help-circled"></span></a></li>
            <li><a href="<?= $this->Url->build('/apps/users/view') ?>"><span id="user-profile" style="background-image:url(<?= $this->Url->build(['controller' => 'users','action' => 'profileImage','plugin' => 'Apps',$userldapid]) ?>)"></span></a>
                <?php if ($userldapid) : ?>
                <ul>
                    <li><?= $this->Html->link("Profile " . $username, ['controller' => 'users','action' => 'view','plugin' => 'Apps']) ?></li>
                    <li><?= $this->Html->link("Employee Directory", ['controller' => 'users','plugin' => 'Apps']) ?></li>
                    <li><hr></li>
                    <li><?= $this->Html->link("<span class='icon-logout'></span>Logout", ['controller' => 'session','action' => 'end','plugin' => 'Apps'], ['escape' => false]) ?></li>
                </ul>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
</header>
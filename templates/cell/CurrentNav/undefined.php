<div>
    <h4 id="app-submenu-title">Admin<!-- CMS --></h4>
    <a href="javascript:void(0)" onclick="app_nav_toggle()"><span class="icon-left-open"></span></a>
</div>


<ul id="app-submenu-1">
    <li><?= $this->Html->link("Application Links", ['controller' => 'AppLinks','action' => 'index']) ?></li>
    <li><?= $this->Html->link("Users", ['controller' => 'users']) ?></li>
    <li><?= $this->Html->link("Roles", ['controller' => 'roles']) ?></li>
    <li><?= $this->Html->link("Permissions", ['controller' => 'permissions']) ?></li>
    <li><?= $this->Html->link("Options", ['controller' => 'options']) ?></li>
    <li><?= $this->Html->link("Files", ['controller' => 'files']) ?></li>
    <li><?= $this->Html->link("Stores", ['controller' => 'stores']) ?></li>
    <li><?= $this->Html->link("Environments", ['controller' => 'environments']) ?></li>
    <!--
    <li><a href="javascript:void(0)">Pages</a></li>
    <li><a href="javascript:void(0)">Posts</a></li>
    <li><a href="javascript:void(0)">Files</a></li>
    <li><a href="javascript:void(0)">Navigation</a></li>
    <li><a href="javascript:void(0)">Elements</a></li>
    <li><a href="javascript:void(0)">Javascript</a></li>
    -->
</ul>

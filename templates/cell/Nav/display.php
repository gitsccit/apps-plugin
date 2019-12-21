<?php
/**
 *
 * @var \Apps\Model\Entity\App[]|\Cake\Collection\CollectionInterface $apps
 */
?>
<ul id="app-submenu-3" style="display:none">
    <?php foreach ($apps as $app): ?>
        <li>
            <!--<a href=""><?php /*echo '' . h($app->name); */?></a>  vf -->
            <!--TODO use of sessions or pass variable to a cell directly -->
            <!--TODO CHEN can i have this done using an event in the appController ? -->
            <!--TODO note this nasty trick down for plugin=> false-->
            <?php // $this->Html->link( h($app->name),['plugin' => false,'controller' => 'Session','action'=>'CurrentApplication',$app->id, $app->route]) ?>
            <?= $this->Html->link( h($app->name),$app->route) ?>
        </li>
    <?php endforeach; ?>
</ul>
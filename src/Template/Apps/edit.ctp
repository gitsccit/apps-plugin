<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\App $app
 */

$this->Html->script('navmenuedit',['block' => true]);

$this->Breadcrumbs->add('Admin');
$this->Breadcrumbs->add('Apps',['action' => 'index']);
$this->Breadcrumbs->add($app->name,['action' => 'view',$app->id]);
$this->Breadcrumbs->add('Edit');
?>
<h1><span class="icon-plus green"></span> Edit App #<?= $app->id ?></h1>

<section class="form-basic">
    <?= $this->Form->create($app) ?>
    <fieldset>
        <legend><?= __('Edit App') ?></legend>
        <?php
        echo $this->Form->control('name');
        echo $this->Form->control('cake_plugin');
        echo $this->Form->control('route');
        ?>
    </fieldset>

    <hr>

    <?= $this->element('navmenu-edit',['title' => 'Nav Menu','description' => 'Use the up and down arrow keys to sort, left and right arrow keys to set parent/child relationships.','applinks' => $app->app_links,'margin' => 40]) ?>

    <div class="margin-50">
        <?= $this->Form->button(__('Update'),['class' => 'button']) ?>
        <?= $this->Html->link(__('Cancel'),['action' => 'index'],['class' => 'button black']) ?>
        <?= $this->Form->end() ?>
    </div>
</section>

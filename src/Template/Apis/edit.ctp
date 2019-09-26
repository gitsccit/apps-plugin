<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\Api $api
 */

$this->Breadcrumbs->add('Admin');
$this->Breadcrumbs->add('API Access',['action' => 'index']);
$this->Breadcrumbs->add($api->name,['action' => 'view',$api->id]);
$this->Breadcrumbs->add('Edit');
?>
<h1><span class="icon-plus green"></span> Edit API Access #<?= $api->id ?></h1>

<section class="form-basic">
    <?= $this->Form->create($api) ?>
    <fieldset>
        <legend><?= __('Edit API Access') ?></legend>
        <?php
        echo $this->Form->control('name');
        echo $this->Form->control('ip_address');
        echo $this->Form->control('token',['type' => 'textarea','required' => false,'readOnly' => 'true','placeholder' => 'Click update to generate a new token']);
        ?>
        <a href="javascript:void(0)" onclick="this.previousElementSibling.value=''" class="button black small">Re-generate new token</a>
    </fieldset>
    <div class="margin-50">
        <?= $this->Form->button(__('Update'),['class' => 'button']) ?>
        <?= $this->Html->link(__('Cancel'),['action' => 'index'],['class' => 'button black']) ?>
        <?= $this->Form->end() ?>
    </div>
</section>

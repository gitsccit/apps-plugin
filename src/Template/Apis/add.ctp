<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\Api $api
 */

$this->Breadcrumbs->add('Admin');
$this->Breadcrumbs->add('API Access',['action' => 'index']);
$this->Breadcrumbs->add('Add');
?>
<h1><span class="icon-plus green"></span> Add API Access</h1>

<section class="form-basic">
    <?= $this->Form->create($api) ?>
    <fieldset>
        <legend><?= __('Add API Access') ?></legend>
        <?php
        echo $this->Form->control('name');
        echo $this->Form->control('ip_address');
        echo $this->Form->control('token',['type' => 'textarea','value' => $token,'readOnly' => "true"]);
        ?>
    </fieldset>
    <div class="margin-50">
        <?= $this->Form->button(__('Save'),['class' => 'button']) ?>
        <?= $this->Html->link(__('Cancel'),['action' => 'index'],['class' => 'button black']) ?>
        <?= $this->Form->end() ?>
    </div>
</section>

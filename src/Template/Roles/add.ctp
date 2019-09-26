<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\Role $role
 */
$this->Breadcrumbs->add('Admin');
$this->Breadcrumbs->add('Roles', ['action' => 'index']);
$this->Breadcrumbs->add('Add');
?>
<h1><span class="icon-plus green"></span> Add Role</h1>
<section class="form-basic">
    <?= $this->Form->create($role) ?>
    <fieldset>
        <legend><?= __('Add Role') ?></legend>
        <?php
        echo $this->Form->control('name', ['class' => 'edit-name-input', 'maxlength' => '30']);
        ?>
    </fieldset>
    <div class="margin-50 ">
        <?= $this->Form->button(__('Save'), ['class' => 'button']) ?>
        <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'button black']) ?>
        <?= $this->Form->end() ?>
    </div>
</section>

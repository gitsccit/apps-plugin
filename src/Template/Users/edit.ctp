<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\User $user
 */
$this->Breadcrumbs->add('Admin');
$this->Breadcrumbs->add('Users', ['action' => 'index']);
$this->Breadcrumbs->add($user->name, ['action' => 'view', $user->id]);
$this->Breadcrumbs->add('Edit');
?>

<h1><span class="icon-plus green"></span> Edit User <?= $user->display_name ?></h1>
<p>Profile data comes from the company's active directory. You may manually adjust your time zone here, however other
    changes must be made in the directory. Note that changse to location in the directory can modify your time zone.</p>

<section class="form-basic">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?= $this->Form->control('time_zone_id', ['options' => $timezones]) ?>
    </fieldset>
    <?= $this->Form->button(__('Update'), ['class' => 'button']) ?>
    <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'button black']) ?>
    <?= $this->Form->end() ?>
</section>

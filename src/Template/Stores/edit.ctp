<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\Store $store
 */
$this->Breadcrumbs->add('Admin');
$this->Breadcrumbs->add('Stores', ['action' => 'index']);
$this->Breadcrumbs->add($store->name, ['action' => 'view', $store->id]);
$this->Breadcrumbs->add('Edit');
?>


<section class="form-basic">
    <?= $this->Form->create($store) ?>
    <fieldset>
        <legend><?= __('Edit Store') ?></legend>
        <?php
        echo $this->Form->control('name');
        echo $this->Form->control('active', ['options' => ['yes','no'], 'empty' => false]);
        echo $this->Form->control('parent_id', ['options' => $parentStores, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Update'), ['class' => 'button']) ?>
    <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'button black']) ?>
    <?= $this->Form->end() ?>
</section>

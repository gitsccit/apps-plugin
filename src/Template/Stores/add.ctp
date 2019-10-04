<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\Store $store
 */
?>
<h1><span class="icon-plus green"></span> Add Stores</h1>
<section class="form-basic">
    <?= $this->Form->create($store) ?>
    <fieldset>
        <legend><?= __('Add Store') ?></legend>
        <?php
        echo $this->Form->control('name');
        //TODO use the app controller to initiate the two option files across all views (try using a helper)
        echo $this->Form->control('active', ['options' => ['yes','no'], 'empty' => false]);
        echo $this->Form->control('parent_id', ['options' => $parentStores, 'empty' => true]);
        ?>
    </fieldset>
    <div class="margin-50 ">
        <?= $this->Form->button(__('Save'), ['class' => 'button']) ?>
        <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'button black']) ?>
        <?= $this->Form->end() ?>
    </div>
</section>

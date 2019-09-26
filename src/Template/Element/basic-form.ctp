<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Cake\ORM\Entity $entity
 * @var string $accessibleField
 */
?>

<section class="form-basic">
    <?= $this->Form->create($entity) ?>
    <fieldset>
        <?php foreach ($accessibleFields as $accessibleField): ?>
            <?= $this->Form->control($accessibleField); ?>
        <?php endforeach; ?>
    </fieldset>
    <?= $this->Form->button(__('Save'), ['class' => 'button']) ?>
    <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'button black']) ?>
    <?= $this->Form->end() ?>
</section>

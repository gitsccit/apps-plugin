<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\Option $option
 */

$this->Html->script('Apps.options', ['block' => true]);
?>
<h1><span class="icon-plus green"></span> Add Option</h1>

<section class="form-basic">
<?= $this->Form->create($option) ?>
<fieldset>
    <legend><?= __('Add Option') ?></legend>
    <?php
    echo $this->Form->control('name');
    echo $this->Form->control('type', ['options' => $typeOptions,'label' => 'Type']);
    echo $this->Form->control('value');
    echo "<div id=\"option-value-file\" style=\"display:none\">" . $this->element('Apps.fileupload', ['target' => 'value', 'multi' => false, 'clear' => true]) . "</div>";
    ?>
</fieldset>
<div class="margin-50">
<?= $this->Form->button(__('Save'), ['class' => 'button']) ?>
<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'button black']) ?>
<?= $this->Form->end() ?>
</div>
</section>


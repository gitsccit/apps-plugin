<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\MimeType $mimeType
 */
$this->Breadcrumbs->add('Admin');
$this->Breadcrumbs->add('Mime Types', ['action' => 'index']);
$this->Breadcrumbs->add('Add');
?>
<h1><span class="icon-plus green"></span> Add Mime Type</h1>

<section class="form-basic">
    <?= $this->Form->create($mimeType) ?>
    <fieldset>
        <legend><?= __('Add Mime Type') ?></legend>
        <?= $this->Form->control('name') ?>
        <div class="form-row">
            <div><?= $this->Form->control('image', ['options' => $imageOptions, 'default' => 'no']) ?></div>
            <div><?= $this->Form->control('resize', ['options' => $resizeOptions, 'default' => 'no']) ?></div>
            <div><?= $this->Form->control('handler', ['options' => $handlerOptions, 'empty' => true]) ?></div>
        </div>
        <?= $this->Form->control('file_id', ['type' => 'text', 'label' => "Thumbnail Image"]) ?>
        <div id="mimetype-value-file">
            <?= $this->element('Apps.fileupload', ['target' => 'file_id', 'multi' => false, 'clear' => true]) ?>
        </div>
    </fieldset>
    <div class="margin-50">
        <?= $this->Form->button(__('Save'), ['class' => 'button']) ?>
        <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'button black']) ?>
        <?= $this->Form->end() ?>
    </div>
</section>

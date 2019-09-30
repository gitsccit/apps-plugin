<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\Option $option
 */

$this->Html->script('options',['block' => true]);

$this->Breadcrumbs->add('Admin');
$this->Breadcrumbs->add('Options',['action' => 'index']);
$this->Breadcrumbs->add($option->name,['action' => 'view',$option->id]);
$this->Breadcrumbs->add('Edit');
?>
<h1><span class="icon-plus green"></span> Edit Option #<?= $option->id ?></h1>

<section class="form-basic">
    <?= $this->Form->create($option) ?>
    <fieldset>
        <legend><?= __('Add Option') ?></legend>
        <?= $this->Form->control('name') ?>
        <?= $this->Form->control('type',['options' => $typeOptions,'label' => 'Type']) ?>
        <?= $this->Form->control('value') ?>
        <div style="display:none"><?= $this->element('Apps.fileupload', ['target' => 'value', 'multi' => false, 'clear' => true,'readonly' => false]) ?></div>
    </fieldset>

    <?php
    $tiles = [];
    foreach($stores as $store) {
        foreach($environments as $environment) {

            // get the current value
            $id = "os0_s".$store->id."_e".$environment->id;
            $value = "";
            foreach($option->option_stores as $os) {
                if ($os->store_id == $store->id && $os->environment_id == $environment->id) {
                    $id = "os".$os->id;
                    $value = $os->value;
                }
            }

            $tiles[] = $this->element('Apps.form-tile',[
                    'title' => $store->name,
                    'inputs' => $this->Form->control($id,['label' => $environment->name,'value' => $value]).
                        '<div style="display:none">'.$this->element('Apps.fileupload', ['target' => $id, 'multi' => false, 'clear' => true,'readonly' => false]).'</div>'
            ]);

        }
    }
    ?>
    <?= $this->element('Apps.form-tiles',['tiles' => $tiles]) ?>

    <div class="margin-50">
        <?= $this->Form->button(__('Update'),['class' => 'button']) ?>
        <?= $this->Html->link(__('Cancel'),['action' => 'index'],['class' => 'button black']) ?>
        <?= $this->Form->end() ?>
    </div>
</section>
<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\Option[]|\Cake\Collection\CollectionInterface $options
 */

$options->each(function ($option) {
    $option->value = $this->element('Apps.option_value', ['type' => $option->type, 'value' => $option->value]);
});

$this->extend('/Admin/index');

<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Cake\ORM\Entity $entity
 */

use Cake\Utility\Inflector;

$this->Html->script('options', ['block' => true]);
$this->Breadcrumbs->add($this->getPlugin() ?? Inflector::humanize(basename(ROOT)));
$this->Breadcrumbs->add($title, ['action' => 'index']);
$this->Breadcrumbs->add($entity->$displayField, ['action' => 'view', $entity->id]);
$this->Breadcrumbs->add('Edit');

$title = Inflector::classify($title);
echo "<h1><span class=\"icon-plus green\"></span> Edit $title</h1><hr>";
echo $form = $this->fetch('form') ? $form :
    $this->element('Apps.basic-form', compact('entity', 'accessibleFields'));

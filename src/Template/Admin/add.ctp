<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Cake\ORM\Entity $entity
 */

use Cake\Utility\Inflector;

$this->Breadcrumbs->add('Admin');
$this->Breadcrumbs->add($title, ['action' => 'index']);
$this->Breadcrumbs->add('Add');

$title = Inflector::classify($title);
echo "<h1><span class=\"icon-plus green\"></span> Add $title</h1><hr>";
echo $form = $this->fetch('form') ? $form :
    $this->element('basic-form', compact('entity', 'accessibleFields'));

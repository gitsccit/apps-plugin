<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Cake\ORM\Entity $entity
 */

use Cake\Utility\Inflector;

$title = humanize($this->getTemplate()) . ' ' . Inflector::singularize($title);
if ($entity->has('id')) {
    $title .= " #$entity->id";
}
echo "<h1><span class=\"icon-plus green\"></span> $title</h1><hr>";
echo ($form = $this->fetch('form')) ? $form :
    $this->element('Apps.basic_form', compact('entity', 'accessibleFields'));

<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Cake\ORM\Entity $entity
 */

use Cake\Utility\Inflector;

$title = Inflector::classify($title);
echo "<h1><span class=\"icon-plus green\"></span> Add $title</h1><hr>";
echo $form = $this->fetch('form') ? $form :
    $this->element('Apps.basic-form', compact('entity', 'accessibleFields'));

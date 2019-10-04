<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Cake\ORM\Entity $entity
 */

$crumbs = [
    ['title' => humanize($this->getPlugin() ?? basename(ROOT))],
    ['title' => humanize($this->getName()), 'url' => ['action' => 'index']]
];

// $entity and $displayField are set in CrudComponent - `beforeRender()`
if (isset($entity)) {
    $crumbs[] = ['title' => $entity->$displayField, 'url' => ['action' => 'view', $entity->id]];
}
$crumbs[] = ['title' => humanize($this->getTemplate())];
$this->Breadcrumbs->prepend($crumbs);

echo $this->Breadcrumbs->render(['class' => 'breadcrumbs-trail'], ['separator' => '<span class="icon-right-open"></span>']);



<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\File $file
 */

$this->Breadcrumbs->add('Admin');
$this->Breadcrumbs->add('Files', ['action' => 'index']);
$this->Breadcrumbs->add('Add');
?>
<h1><span class="icon-plus green"></span> Files</h1>
<p>Drag &amp; drop to insert files.</p>

<div id="option-value-file"><?= $this->element('Apps.fileupload', ['target' => false, 'multi' => true, 'browse' => false]) ?></div>

<p><?= $this->Html->link("Back", ['action' => 'index'], ['class' => 'button black']) ?></p>

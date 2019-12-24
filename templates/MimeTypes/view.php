<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\MimeType $mimeType
 */

$this->extend('/Admin/view');

$id = $mimeType->thumbnail->id ?? null;
$image = $this->Url->build(['controller' => 'files', 'action' => 'resize', $id, 500, 500]);
$this->set(compact('image'));

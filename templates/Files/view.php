<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\File $file
 */
$this->extend('/Admin/view');

$file->size = $this->Number->toReadableSize($file->size);
$image = $this->Url->build(['action' => 'resize', $file->id, 500, 500]);
$links = [$this->Form->postLink(
    __('Delete'),
    ['action' => 'delete', $file->id],
    ['class' => 'button black', 'confirm' => __('Are you sure you want to delete # {0}?', $file->id)]
)];
$this->set(compact('image', 'links'));

<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 * @var bool $canSynchronizeLDAP
 */

$this->extend('Apps.Admin/index');

if ($canSynchronizeLDAP) {
    $links[] = $this->Html->link('Synchronize Active Directory', ['action' => 'synchronizeLdap'], ['class' => 'button']);
    $this->set(compact('links'));
}

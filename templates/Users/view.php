<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\User $user
 * @var bool $canEditRoles
 * @var bool $canSynchronizeLDAP
 * @var bool $canLoginAs
 */

$this->extend('/Admin/view');

$user->user_contacts = $associations['userContacts']->toArray();
$image = $this->Url->build(['action' => 'profileImage', $user->ldapid]);
$subtitle = [$user->title, $user->department];

$links = [];
if ($canSynchronizeLDAP) {
    $links[] = $this->Html->link('Refresh AD Data', ['action' => 'synchronizeLdap', $user->id], ['class' => 'button']);
}
if ($canLoginAs) {
    if ($this->request->getSession()->read('Auth.User.id') != $user->id) {
        $links[] = $this->Html->link('Log In As User', ['controller' => 'Session', 'action' => 'loginAs', $user->id], ['class' => 'button']);
    }
}
if ($canEditRoles) {
    $links[] = $this->Html->link('Edit Roles', ['action' => 'roles', $user->id], ['class' => 'button']);
}
$links = array_merge($links, [
    $this->Html->link('Kill Session', ['controller' => 'Session', 'action' => 'kill', $user->id], ['class' => 'button']),
    $this->Html->link('Edit Time Zone', ['action' => 'edit', $user->id], ['class' => 'button']),
]);

$this->set(compact('image', 'subtitle', 'links'));

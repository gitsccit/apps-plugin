<!doctype html>
<html lang="en" dir="ltr">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#000000">
    <title><?= $this->fetch('title') ?></title>
    <?= $this->Html->meta('icon') ?>

    <?php $stylesheets = [
        'Apps.fontello-embedded',
        'Apps.scc-base.min',
        'Apps.scc-app',
        'Apps.table',
        'Apps.tabset',
        'Apps.message',
        'Apps.form',
        'Apps.style'
    ]; ?>
    <link rel="stylesheet"
          href="<?= $this->Url->build(array_merge(['controller' => 'files', 'action' => 'css', 'plugin' => 'Apps'],
              $stylesheets)) ?>">
    <?= $this->Html->script('Apps.script'); ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

</head>
<body <?= $collapsed ? 'class="collapsed"' : '' ?>>

<a id="hamburger-hidden" href="javascript:void(0)" onclick="app_nav_toggle()"><span class="icon-menu"></span></a>
<div id="apps-layout">
    <?= $this->element('Apps.nav'); ?>
    <div id="apps-maincolumn">
        <!--todo header element containing the nav bar cell -->
        <?= $this->element('Apps.header') ?>
        <?= $this->element('Apps.breadcrumb') ?>
        <?= $this->Flash->render() ?>
        <div id="main-content">
            <?= $this->fetch('content') ?>
        </div>
        <?= $this->element('Apps.footer'); ?>
    </div>
</div>
</body>
</html>




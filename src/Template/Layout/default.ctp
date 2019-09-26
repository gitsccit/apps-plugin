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
        'fontello-embedded',
        'scc-base.min',
        'scc-app',
        'table',
        'tabset',
        'message',
        'form',
        'style'
    ]; ?>
    <link rel="stylesheet"
          href="<?= $this->Url->build(array_merge(['controller' => 'files', 'action' => 'css', 'plugin' => null],
              $stylesheets)) ?>">
    <?= $this->Html->script(['script']); ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

</head>
<body <?= $collapsed ? 'class="collapsed"' : '' ?>>

<a id="hamburger-hidden" href="javascript:void(0)" onclick="app_nav_toggle()"><span class="icon-menu"></span></a>
<div id="apps-layout">
    <?= $this->element('nav'); ?>
    <div id="apps-maincolumn">
        <!--todo header element containing the nav bar cell -->
        <?= $this->element('header') ?>
        <?= $this->Breadcrumbs->render(['class' => 'breadcrumbs-trail'],
            ['separator' => '<span class="icon-right-open"></span>']) ?>
        <?= $this->Flash->render() ?>
        <div id="main-content">
            <?= $this->fetch('content') ?>
        </div>
        <?= $this->element('footer'); ?>
    </div>
</div>
</body>
</html>




<?php
$class = $type == 'parent' ? 'navigation-page-ul' : 'child-navigation-page-ul';
$id = $id == 'parent-list' ? 'parent-list' : 'child-list';
?>
<!--Draggable plugin   https://shopify.github.io/draggable/examples/simple-list.html-->
<ul class="<?php echo $class; ?>" id="<?php echo $id; ?>">
    <?php foreach ($menus as $k => $v) : ?>
        <li>
        <strong class="strong-li"><?= $k ?></strong>

        <?php
        if (count($v['children']) > 0) { ?>
            <?php foreach ($v['children'] as $link) : ?>
                <li class="node">
                    <span><strong class="strong-child-li"><?= $link['title'] ?></strong>
                    <?=
                    $this->Html->link(__('Edit'), ['action' => 'edit', $link['id']]);
                    ?></span>
                    <?php if (is_array($link['children']) && count($link['children']) > 0) : ?>
                        <div>
                            <?php echo $this->element('Apps.nav_ul', ['menus' => $link['children'], 'type' => 'child', 'id' => 'child-list']); ?>
                        </div>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        <?php } ?>
    <?php endforeach; ?>
</ul>
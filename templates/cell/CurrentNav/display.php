<div>
    <h4 id="app-submenu-title"><?= $title = (!empty($title)) ? $title : 'ADMIN'; ?></h4>
    <a href="javascript:void(0)" onclick="app_nav_toggle()"><span class="icon-left-open"></span></a>
</div>

<ul id="app-submenu-1">
    <!--TODO destination to the links be a full url @DOUGLAS-->
    <?php if (!empty($links)): ?>
        <?php foreach ($links as $link):
            if (empty($link->destination))
                $link->destination = "javascript:void(0)";
            $destination = false;
            if (substr($link->destination, 0, 1) == "{") {
                $destination = json_decode($link->destination, true);
                $destination['plugin'] = $plugin;
            }
            if ($destination === false) $destination = $link->destination;
            $attr = [];
            if (!empty($link['htmlid'])) $attr['id'] = $link['htmlid'];
            echo "<li>";
            echo $this->Html->link($link->title, $destination, $attr);
            echo "</li>";
        endforeach;
    else: ?>
        <li>
            <a href="javascript:void(0)">NO LINKS DEFINED</a>
        </li>
    <?php endif; ?>

</ul>

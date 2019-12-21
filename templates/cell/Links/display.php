<nav>
    <!--<div>
        <? /*= $this->element('Apps.link-ul', ['links' => $links, 'class' => 'navmenu']); */ ?>
    </div>-->
    <?= $this->element('Apps.link-ul', ['links' => $links, 'class' => 'navmenu']); ?>
  <!--  <?php /*foreach ($links as $link):  */?>

        <ul>
            <li>
                <a href="javascript:void(0)"><?php /*echo '->' . h($link->title); */?></a>
            </li>

        </ul>
    --><?php /*endforeach; */?>

</nav>
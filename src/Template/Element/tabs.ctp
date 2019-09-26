<?php
/**
 * Organizes a collection of html into tabs
 *
 * $tabs an associative array where the key is the tab name and the value is its html content
 */
?>
<section>
    <div class="tab-list">
        <?php foreach($tabs as $tab => $content): ?>
        <div class="tab-link" onclick="tabListSelect(this)" data-content="tab-content-<?= $tab ?>">
            <div><?= $tab ?></div>
            <div class="tab-underline"></div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php foreach($tabs as $tab => $content): ?>
    <div class="tab-content" id="tab-content-<?= $tab ?>">
        <?= $content ?>
    </div>
    <?php endforeach; ?>
</section>
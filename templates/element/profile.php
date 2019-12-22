<?php
/**
 * Displays a left image with a cloud of data to the right
 *
 * $image the url of the image to show
 * $title displays above the data
 * $subtitle scalar or array; displays below the title
 * $data 2d array organizing data into columns
 */

if (!empty($subtitle) && is_array($subtitle)) {
    foreach ($subtitle as $key => $value) {
        if (empty($value)) {
            unset($subtitle[$key]);
        }
    }
    $subtitle = implode("</span><span>", $subtitle);
}
?>
<section>
    <div class="width-">
        <div class="flex-row profile">
            <?php if (!empty($image)) : ?>
            <div>
                <div class="image" style="background-image:url(<?= $image ?>)"></div>
            </div>
            <?php endif; ?>
            <div>
                <h2><?= h(empty($title) ? "User Profile" : $title) ?></h2>
                <?php if (!empty($subtitle)) : ?>
                <div class="profile-contact"><span><?= $subtitle ?></span></div>
                <?php endif; ?>
                <div class="width-">
                    <div class="flex-row">
                        <?php foreach ($data as $table) { ?>
                            <div>
                                <table class="table-data">
                                    <?= $this->Html->tableCells($table) ?>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
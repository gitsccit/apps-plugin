<?php
/**
 * Displays a tile with an h5 followed by a list of divs
 *
 * $title displays above in the h5
 * $inputs; array of html to display
 */
if (is_scalar($inputs)) {
    $inputs = [$inputs];
}
?>
<div>
    <h5><?= $title ?></h5>
    <?php foreach ($inputs as $input) : ?>
    <div><?= $input ?></div>
    <?php endforeach; ?>
</div>
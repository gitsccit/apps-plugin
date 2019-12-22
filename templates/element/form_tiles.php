<?php
/**
 * Displays a grid of form tiles
 *
 * $tiles an array of elements (intended as form-tile elements)
 */
if (is_scalar($tiles)) {
    $tiles = [$tiles];
}
?>
<div class="form-tiles">
    <?php foreach ($tiles as $tile) : ?>
        <div><?= $tile ?></div>
    <?php endforeach; ?>
</div>
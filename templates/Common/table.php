<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\News[]|\Cake\Collection\CollectionInterface $news
 */

use Apps\Model\Entity\News;
use Apps\View\AppView;
use Cake\Collection\CollectionInterface;

?>
<section>
    <div class="width-1200">
        <?php if ($this->fetch('links')) : ?>
            <div class="margin-50">
                <?= $this->fetch('links') ?>
            </div>
        <?php endif ?>
        <?php if ($this->fetch('tabs')) : ?>
            <?= $this->fetch('tabs') ?>
        <?php endif ?>
        <?php if ($this->fetch('datatable')) : ?>
            <table>
                <?= $this->fetch('datatable') ?>
            </table>
            <?php if ($this->fetch('showPaginator')) : ?>
                <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->first('<< ' . __('first')) ?>
                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >') ?>
                        <?= $this->Paginator->last(__('last') . ' >>') ?>
                    </ul>
                    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
                </div>
            <?php endif ?>
        <?php endif ?>
    </div>
</section>




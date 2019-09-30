<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\Apps[]|\Cake\Collection\CollectionInterface $apps
 */
?>
<div class="flex-column">
    <div>
        <h3>Navigation Maintenance</h3>
        <p>Paragraph</p>
        <form style="padding: 15px;">
            <div class="shade">
                <?php echo $this->element('Apps.nav-ul', ['menus' => $links, 'type' => 'parent', 'id' => 'parent-list']); ?>
            </div>
            <div>
                <?php
                //echo '<pre>';
                // var_dump($links);
                ?>
            </div>
        </form>
    </div>
</div>
<!---source : http://jsfiddle.net/RubaXa/zLq5J/-->
<script>

    function sortable(rootEl, onUpdate) {
        var dragEl;
        [].slice.call(rootEl.children).forEach(function (itemEl) {
            itemEl.draggable = true;
        });

        function _onDragOver(evt) {
            evt.preventDefault();
            evt.dataTransfer.dropEffect = 'move';

            var target = evt.target;
            if (target && target !== dragEl && target.nodeName == 'LI') {
                // Сортируем
                rootEl.insertBefore(dragEl, target.nextSibling || target);
            }
        }

        function _onDragEnd(evt) {
            evt.preventDefault();

            dragEl.classList.remove('ghost');
            rootEl.removeEventListener('dragover', _onDragOver, false);
            rootEl.removeEventListener('dragend', _onDragEnd, false);
            onUpdate(dragEl);
        }

        rootEl.addEventListener('dragstart', function (evt) {
            dragEl = evt.target;
            evt.dataTransfer.effectAllowed = 'move';
            evt.dataTransfer.setData('Text', dragEl.textContent);
            rootEl.addEventListener('dragover', _onDragOver, false);
            rootEl.addEventListener('dragend', _onDragEnd, false);

            setTimeout(function () {
                dragEl.classList.add('ghost');
            }, 0)
        }, false);
    }

    sortable(document.getElementById('parent-list'), function (item) {
        console.log(item);
    });
    sortable(document.getElementById('child-list'), function (item) {
        console.log(item);
    });

</script>

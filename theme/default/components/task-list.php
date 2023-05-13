<section class="s_task-list">

  <h2>Список задач</h2>

  <? if( $arResult['task-list']['SHOW'] ): ?>
    <? include(_TEMPLATE_PATH_ . '/components/sort.php') ?>
  
    <ul class="task-list">
  
      <? foreach ($arResult['task-list']['ITEMS'] as $item): ?>
        <?
        $itemState = $item['state'] == 0 ? '--await' : '--done';
        ?>
  
        <li class="task <?= $itemState ?>">
          <p class="task--title-panel">
            <span class="task__username">
              <?= $item['user'] ?>
            </span>
            <span class="task__email">
              <?= $item['email'] ?>
            </span>
          </p>
          <p class="task--description-panel">
            <span class="task__description">
              <?= $item['description'] ?>
            </span>
          </p>
        </li>
      <? endforeach; ?>
  
    </ul>
  
    <? include(_TEMPLATE_PATH_ . '/components/pagination.php') ?>

  <? else: ?>
    <div class="task-list --empty">
      <p>Список пуст...</p>
    </div>
  <? endif; ?>


</section>
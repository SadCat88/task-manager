<? $RESULT = $arResult['pagination']; ?>
<? if ($RESULT['SHOW']): ?>
  <ul class="pagination">

    <? $item = $RESULT['ITEMS']['FIRST']; ?>
    <li class="pagination-item --first <?= (!$item['SHOW']) ? '--disabled' : '' ?>">
      <? if( $item['SHOW'] ): ?>
        <a class="pagination__btn" href="<?=$item["LINK"]?>">first</a>
      <? else: ?>
        <span class="pagination__btn">first</span>
      <? endif; ?>
    </li>

    <? $item = $RESULT['ITEMS']['PREV']; ?>
    <li class="pagination-item --prev <?= (!$item['SHOW']) ? '--disabled' : '' ?>">
      <? if( $item['SHOW'] ): ?>
        <a class="pagination__btn" href="<?=$item["LINK"]?>">prev</a>
      <? else: ?>
        <span class="pagination__btn">prev</span>
      <? endif; ?>
    </li>

    <? $item = $RESULT['ITEMS']['CURRENT']; ?>
    <li class="pagination-item --page <?= (!$item['SHOW']) ? '--disabled' : '' ?>">
      <span class="pagination__btn">
        <?= $item['VALUE'] ?>
      </span>
    </li>

    <? $item = $RESULT['ITEMS']['NEXT']; ?>
    <li class="pagination-item --next <?= (!$item['SHOW']) ? '--disabled' : '' ?>">
      <? if( $item['SHOW'] ): ?>
        <a class="pagination__btn" href="<?=$item["LINK"]?>">next</a>
      <? else: ?>
        <span class="pagination__btn">next</span>
      <? endif; ?>
    </li>

    <? $item = $RESULT['ITEMS']['LAST']; ?>
    <li class="pagination-item --first <?= (!$item['SHOW']) ? '--disabled' : '' ?>">
      <? if( $item['SHOW'] ): ?>
        <a class="pagination__btn" href="<?=$item["LINK"]?>">last</a>
      <? else: ?>
        <span class="pagination__btn">last</span>
      <? endif; ?>
    </li>

  </ul>
<? endif; ?>
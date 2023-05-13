<? if ($arResult['sort']['SHOW']): ?>
  <ul class="sort">

    <? $item = $arResult['sort']['ITEMS']['ORDER_ID']; ?>
    <li class="sort__item" date-sort="<?= $item['VALUE'] ?>">
      <a href="<?= $item['LINK'] ?>">Order</a>
    </li>

    <? $item = $arResult['sort']['ITEMS']['ORDER_USER']; ?>
    <li class="sort__item" date-sort="<?= $item['VALUE'] ?>">
      <a href="<?= $item['LINK'] ?>">Username</a>
    </li>

    <? $item = $arResult['sort']['ITEMS']['ORDER_EMAIL']; ?>
    <li class="sort__item" date-sort="<?= $item['VALUE'] ?>">
      <a href="<?= $item['LINK'] ?>">Email</a>
    </li>

    <? $item = $arResult['sort']['ITEMS']['ORDER_STATE']; ?>
    <li class="sort__item" date-sort="<?= $item['VALUE'] ?>">
      <a href="<?= $item['LINK'] ?>">State</a>
    </li>

  </ul>
<? endif; ?>
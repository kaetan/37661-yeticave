<ul class="lots__list">
    <!--заполните этот список из массива с товарами-->
    <?php foreach ($lots as $lot): ?>
        <li class="lots__item lot">
            <div class="lot__image">
                <img src="<?=$lot['picture']; ?>" width="350" height="260" alt="<?=strip_tags($lot['title']); ?>">
            </div>
            <div class="lot__info">
                <span class="lot__category"><?=$lot['category']; ?></span>
                <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$lot['id']; ?>"><?=strip_tags($lot['title']); ?></a></h3>
                <div class="lot__state">
                    <div class="lot__rate">
                        <span class="lot__amount">Стартовая цена</span>
                        <span class="lot__cost">
                                  <?php print(format_cost(strip_tags($lot['starting_price']))); ?>
                              </span>
                    </div>
                    <div class="lot__timer timer">
                        <?php print lot_timer($lot['datetime_finish'])?>
                    </div>
                </div>
            </div>
        </li>
    <? endforeach ?>
</ul>
<ul class="lots__list">
    <!--заполните этот список из массива с товарами-->
    <?php foreach ($lots as $lot): ?>
        <li class="lots__item lot">
            <div class="lot__image">
                <img src="<?=$lot['picture']; ?>" width="350" height="260" alt="<?=htmlspecialchars($lot['title']); ?>">
            </div>
            <div class="lot__info">
                <span class="lot__category"><?=$lot['category']; ?></span>
                <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$lot['id']; ?>"><?=htmlspecialchars($lot['title']); ?></a></h3>
                <div class="lot__state">
                    <div class="lot__rate">
                        <?php
                        $b_q = $lot['bets_quantity'];
                        $price_text = $b_q === '0' ? "Стартовая цена" : $b_q .' '. plural($b_q, ['ставка','ставки','ставок']);
                        ?>
                        <span class="lot__amount"><?=$price_text;?></span>
                        <span class="lot__cost"><?php print(format_cost(htmlspecialchars($lot['current_price']), 1)); ?></span>
                    </div>
                    <?php $classname = (strtotime($lot['datetime_finish']) - strtotime('now')) < 3600 ? "timer--finishing" : ""; ?>
                    <div class="lot__timer timer <?=$classname;?>">
                        <?php print lot_timer($lot['datetime_finish'])?>
                    </div>
                </div>
            </div>
        </li>
    <? endforeach ?>
</ul>
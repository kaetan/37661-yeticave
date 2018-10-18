<main>
    <nav class="nav">
        <ul class="nav__list container">
            <? foreach ($categories as $val): ?>
                <li class="nav__item">
                    <a href="all_lots.php?cat=<?=$val['id']; ?>"><?=$val['title']?></a>
                </li>
            <? endforeach ?>
        </ul>
    </nav>
    <div class="container">
        <section class="lots">
            <h2>
                Все лоты
                <?php if ($category_title) { ?>
                в категории <span>«<?=$category_title;?>»</span>
                <?php ;} ?>
            </h2>
            <ul class="lots__list">
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
        </section>
        <ul class="pagination-list">
            <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
            <li class="pagination-item pagination-item-active"><a>1</a></li>
            <li class="pagination-item"><a href="#">2</a></li>
            <li class="pagination-item"><a href="#">3</a></li>
            <li class="pagination-item"><a href="#">4</a></li>
            <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
        </ul>
    </div>
</main>
<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $val): ?>
            <li class="nav__item">
                <a href="all-lots.html"><?=$val['title']?></a>
            </li>
            <? endforeach ?>
        </ul>
    </nav>
    <section class="lot-item container">

        <!-- Название лота -->
        <h2><?=strip_tags($lot_info['title'])?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <!-- Фотография лота -->
                <div class="lot-item__image">
                    <img src="<?=$lot_info['picture']?>" width="730" height="548" alt="<?=strip_tags($lot_info['title'])?>">
                </div>
                <!-- Категория -->
                <p class="lot-item__category">Категория: <span><?=$lot_info['category']?></span></p>
                <!-- Описание лота -->
                <p class="lot-item__description"><?=strip_tags($lot_info['description'])?></p>
            </div>
            <div class="lot-item__right">
                <?php if ($is_auth) { ?>
                <div class="lot-item__state">
                    <!-- Время до завершения торгов -->
                    <div class="lot-item__timer timer">
                        <?php print lot_timer($lot_info['datetime_finish'])?>
                    </div>
                    <div class="lot-item__cost-state">
                        <!-- Текущая цена -->
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?=format_cost($lot_info['current_price'], 0)?></span>
                        </div>
                        <!-- Минимальная ставка -->
                        <div class="lot-item__min-cost">
                            Мин. ставка <span>
                                <?=format_cost($lot_info['min_bet'], 0);?> р
                            </span>
                        </div>
                    </div>
                    <!-- Добавить ставку -->
                    <form class="lot-item__form" action="lot.php?id=<?=$lot_info['id'];?>" method="post">
                        <?php $classname = $bet_errors !== '' ? "form__item--invalid" : ""; ?>
                        <p class="lot-item__form-item <?=$classname;?>">
                            <input type="hidden" name = "lot_id" value="<?=$lot_info['id'];?>">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="number" name="cost" placeholder="<?=format_cost($lot_info['min_bet'], 0);?>">
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                    <?php if (isset($bet_errors)) { ?>
                        <div class = "form-item form__item--invalid">
                            <span class="form__error"><?=$bet_errors; ?></span>
                        </div>
                    <?php } ?>
                </div>
                <?php } ?>
                <div class="history">
                    <h3>История ставок (<span><?php print(count($bets));?></span>)</h3>
                    <table class="history__list">
                        <?php foreach($bets as $key) : ?>
                        <tr class="history__item">
                            <td class="history__name"><?=(strip_tags($key['username']));?></td>
                            <td class="history__price"><?php print(format_cost(strip_tags($key['bet']), 0)); ?> р</td>
                            <td class="history__time"><?=human_date($key['datetime']);?></td>
                        </tr>
                        <? endforeach ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
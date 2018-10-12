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
                            <span class="lot-item__cost"><?=format_cost_no_ruble($lot_info['current_price'])?></span>
                        </div>
                        <!-- Минимальная ставка -->
                        <div class="lot-item__min-cost">
                            Мин. ставка <span>
                                <?=format_cost_no_ruble($lot_info['min_bet']);?> р
                            </span>
                        </div>
                    </div>
                    <!-- Добавить ставку -->
                    <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
                        <p class="lot-item__form-item">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="number" name="cost" placeholder="<?=format_cost_no_ruble($lot_info['min_bet']);?>">
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                </div>
                <?php } ?>
                <div class="history">
                    <h3>История ставок (<span>10</span>)</h3>
                    <table class="history__list">
                        <tr class="history__item">
                            <td class="history__name">Иван</td>
                            <td class="history__price">10 999 р</td>
                            <td class="history__time">5 минут назад</td>
                        </tr>
                        <tr class="history__item">
                            <td class="history__name">Константин</td>
                            <td class="history__price">10 999 р</td>
                            <td class="history__time">20 минут назад</td>
                        </tr>
                        <tr class="history__item">
                            <td class="history__name">Евгений</td>
                            <td class="history__price">10 999 р</td>
                            <td class="history__time">Час назад</td>
                        </tr>
                        <tr class="history__item">
                            <td class="history__name">Игорь</td>
                            <td class="history__price">10 999 р</td>
                            <td class="history__time">19.03.17 в 08:21</td>
                        </tr>
                        <tr class="history__item">
                            <td class="history__name">Енакентий</td>
                            <td class="history__price">10 999 р</td>
                            <td class="history__time">19.03.17 в 13:20</td>
                        </tr>
                        <tr class="history__item">
                            <td class="history__name">Семён</td>
                            <td class="history__price">10 999 р</td>
                            <td class="history__time">19.03.17 в 12:20</td>
                        </tr>
                        <tr class="history__item">
                            <td class="history__name">Илья</td>
                            <td class="history__price">10 999 р</td>
                            <td class="history__time">19.03.17 в 10:20</td>
                        </tr>
                        <tr class="history__item">
                            <td class="history__name">Енакентий</td>
                            <td class="history__price">10 999 р</td>
                            <td class="history__time">19.03.17 в 13:20</td>
                        </tr>
                        <tr class="history__item">
                            <td class="history__name">Семён</td>
                            <td class="history__price">10 999 р</td>
                            <td class="history__time">19.03.17 в 12:20</td>
                        </tr>
                        <tr class="history__item">
                            <td class="history__name">Илья</td>
                            <td class="history__price">10 999 р</td>
                            <td class="history__time">19.03.17 в 10:20</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
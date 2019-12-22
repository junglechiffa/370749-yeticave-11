<main>
    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach ($categorys as $value): ?>
        <li class="nav__item">
          <a href="all-lots.html"><?= htmlspecialchars($value['name']); ?></a>
        </li>
        <?php endforeach ;?>
      </ul>
    </nav>
    <div class="container">
      <section class="lots">
        <h2>Результаты поиска по запросу «<span><?php if(isset($search) and !empty($search)){echo $search;}?></span>»</h2>
        <ul class="lots__list">

<?php foreach ($lot as $k => $v): ?>

          <li class="lots__item lot">
            <div class="lot__image">
              <img src="<?= htmlspecialchars($lot[$k]['picture']); ?>" width="350" height="260" alt="Сноуборд">
            </div>
            <div class="lot__info">
              <span class="lot__category"><?= htmlspecialchars($lot[$k]['c_name']); ?></span>
              <h3 class="lot__title"><a class="text-link" href="lot.html"><?= htmlspecialchars($lot[$k]['name']); ?></a></h3>
              <div class="lot__state">
                <div class="lot__rate">
                  <span class="lot__amount"><?= htmlspecialchars($lot[$k]['price_status']); ?></span>
                  <span class="lot__cost"><?= htmlspecialchars($lot[$k]['m_price']); ?><b class="rub">р</b></span>
                </div>
                <div 
                  <?php                  
                    $a = lifetime($lot[$k]['data_end']);
                    if ($a[0] == "00") {
                        echo 'class="lot-item__timer timer timer--finishing"';
                    }elseif ($a[0] !=="00") {
                        echo 'class="lot-item__timer timer"';
                    }                
                  ?>
                >
                  <?php echo $a[0] . ":" . $a[1]; ?>
                </div>
              </div>
            </div>
          </li>

<?php endforeach ;?>


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
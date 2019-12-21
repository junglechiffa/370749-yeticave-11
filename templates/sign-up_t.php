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
    <form class="form container form--invalid" action="sign-up.php" method="post" autocomplete="off"> <!-- form
    --invalid -->
      <h2>Регистрация нового аккаунта</h2>
      <div class="form__item <?php if(isset($error['email'])){echo "form__item--invalid";} ?>"> <!-- form__item--invalid --> 
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?php echo $s_up['email']; ?>">
        <span class="form__error"><?php if(isset($error['email'])){echo $error['email'];}?></span>
      </div>
      <div class="form__item <?php if(isset($error['password'])){echo "form__item--invalid";} ?>"> <!-- form__item--invalid -->
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?php echo $s_up['password']; ?>">
        <span class="form__error"><?php if(isset($error['password'])){echo $error['password'];}?></span>
      </div>
      <div class="form__item <?php if(isset($error['name'])){echo "form__item--invalid";} ?>"> <!-- form__item--invalid -->
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя" value="<?php echo $s_up['name']; ?>">
        <span class="form__error"><?php if(isset($error['name'])){echo $error['name'];}?></span>
      </div>
      <div class="form__item <?php if(isset($error['message'])){echo "form__item--invalid";} ?>"> <!-- form__item--invalid -->
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?php echo $s_up['message']; ?></textarea>
        <span class="form__error"><?php if(isset($error['message'])){echo $error['message'];}?></span>
      </div>
       <span class="form__error form__error--bottom"><?php if(isset($error) and count($error) !== 0){echo 'Пожалуйста, исправьте ошибки в форме.';} ?>
      <button type="submit" class="button">Зарегистрироваться</button>
      <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
  </main>
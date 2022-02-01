<?php $hform = new Single('Горизонтальная форма', 10, 1); ?>

<section class="horizontalform">
    <div class="container">
        <div class="formblock">
        <span class="h2">Узнайте как купить диван со скидкой</span>
        <span class="text">Оставьте свои данные и наши операторы перезвонят вам, чтобы согласовать скидку для Вас</span>
        <form action="" method="post" id="horform">
            <input type="text" placeholder="Ваше имя" name="title">
            <input type="text" placeholder="Ваш номер телефона" name="tel">
            <input type="hidden" value="<?=$_SERVER['REQUEST_URI']?>" name="link">
            <input type="submit" class="btn" value="Отправить">
        </form>
        </div>
    </div>
</section>
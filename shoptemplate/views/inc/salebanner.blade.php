<?php $salebanner = new Single('Баннер со скидкой', 10, 1); ?>
<?php
$imgpc = $salebanner->field('Акция', 'Картинка', 'photo', true, '/images/sale.png');
$imgmob = $salebanner->field('Акция', 'Картинка моб', 'photo', true, '/images/sale.png');
if(Agent::isMobile())
    $img = $imgmob; else $img = $imgpc;

?>
<div class="salebanner">
    <div class="image">
        <img src="{{$img}}" alt="">
        <a href="{{Lang::link($salebanner->field('Акция', 'Ссылка', 'text', true, '/products'))}}" class="btn">{{ $salebanner->field('Акция', 'Кнопка', 'text', true, 'Подробнее') }}</a>
    </div>
</div>

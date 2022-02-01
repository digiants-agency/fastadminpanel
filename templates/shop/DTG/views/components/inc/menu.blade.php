<ul class="menu">

    <li class="menu-item menu-item-wrapper menu-item-wrapper-parent">
        <a href="{{ route('catalog', ['', ''], false) }}" class="menu-item menu-item-parent">
            {{ $fields['catalog_title'] }}
            <svg class="menu-item-parent-svg" width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.84578 4.82123L2.79852 8.86714C2.62093 9.04429 2.33321 9.04429 2.15517 8.86714C1.97757 8.69 1.97757 8.40227 2.15517 8.22513L5.8814 4.50024L2.15561 0.775352C1.97802 0.598208 1.97802 0.310483 2.15561 0.132892C2.33321 -0.0442505 2.62138 -0.0442505 2.79897 0.132892L6.84623 4.17881C7.02113 4.35412 7.02113 4.64637 6.84578 4.82123Z" fill="#059F97"/>
            </svg>
        </a>
        <ul class="submenu">
            @foreach ($fields['catalog'] as $catalog_item)
                <li class="menu-item @if(sizeof($catalog_item->child)) submenu-item-parent menu-item-wrapper-parent @endif">

                    <a href="{{ route('catalog', [$catalog_item->slug, ''], false) }}" class="menu-item submenu-item @if(sizeof($catalog_item->child)) menu-item-parent @endif">
                        {{ $catalog_item->title }}
                        @if(sizeof($catalog_item->child))
                            <svg class="menu-item-parent-svg" width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.84578 4.82123L2.79852 8.86714C2.62093 9.04429 2.33321 9.04429 2.15517 8.86714C1.97757 8.69 1.97757 8.40227 2.15517 8.22513L5.8814 4.50024L2.15561 0.775352C1.97802 0.598208 1.97802 0.310483 2.15561 0.132892C2.33321 -0.0442505 2.62138 -0.0442505 2.79897 0.132892L6.84623 4.17881C7.02113 4.35412 7.02113 4.64637 6.84578 4.82123Z" fill="#059F97"/>
                            </svg>
                        @endif
                    </a>
                    
                    @if(sizeof($catalog_item->child))
                        <ul class="submenu">
                            @foreach ($catalog_item->child as $catalog_item_children)
                                <li class="">
                                    <a href="{{ route('catalog', [$catalog_item_children->slug, ''], false) }}" class="menu-item submenu-item">{{ $catalog_item_children->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                </li>
            @endforeach
        </ul>
    </li>

    @foreach ($fields['categories'] as $item)
        <li class="menu-item-wrapper">
            <a href="{{ route('catalog', [$item->slug, ''], false) }}" class="menu-item">{{ $item->title }}</a>
        </li>    
    @endforeach

    @foreach ($fields['menu'] as $menu_item)    
        <li class="menu-item-wrapper">
            <a href="{{ Lang::link($menu_item[1]) }}" class="menu-item">{{ $menu_item[0] }}</a>
        </li>
    @endforeach

</ul>



@desktopcss

<style>

    .menu {
        display: flex;
        align-items: center;
        list-style: none;
    }

    .menu-item {
        font-style: normal;
        font-weight: normal;
        font-size: 18px;
        line-height: 28px;
        color: var(--color-text);
        display: flex;
        align-items: center;
        transition: .3s;
    }

    .menu-item-parent::after {
        display: block;
        content: "";
        border: 1px solid var(--color-text);
        width: 6px;
        height: 6px;
        border-left: none;
        border-bottom: none;
        transform: rotate(135deg);
        margin-left: 6px;
        transition: .3s
    }

    .menu-item-parent-svg {
        display: none;
    }
    
    .menu-item-wrapper {
        position: relative;
        margin-right: 55px;
        display: block;
        padding: 11px 0;
    }

    .menu-item:hover {
        color: var(--color-second);
    }

    .menu-item-parent:hover::after {
        border-color: var(--color-second);
        transform: rotate(315deg);
        margin-top: 6px;
    }

    .menu-item-wrapper:last-child {
        margin-right: 0;
    }

    .submenu {
        position: absolute;
        top: 100%;
        left: 0;
        background: #FFFFFF;
        box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.05);
        padding: 15px 0;
        min-width: 250px;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: .3s;
        list-style: none;
    }

    .menu-item-wrapper-parent:hover>.submenu {
        opacity: 1;
        visibility: visible;
        pointer-events: all;    
    }

    .submenu-item.menu-item-parent {
        justify-content: space-between;
        width: 100%;
    }
    .submenu-item.menu-item-parent::after {
        transform: rotate(45deg) !important;
        margin: 0 !important;
    }

    .submenu-item {
        padding: 0 20px;
    }

    .submenu .submenu {
        position: absolute;
        top: -15px;
        left: 100%;
    }


</style>

@mobilecss

<style>

    .menu {
        display: flex;
        align-items: flex-start;
        flex-direction: column;
        list-style: none;
        margin-bottom: 20px;
        width: 100%; 
    }

    a.menu-item {
        font-style: normal;
        font-weight: normal;
        font-size: 18px;
        line-height: 28px;
        color: var(--color-text);
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        transition: .3s;
    }

    /* .menu-item-parent::after {
        display: block;
        content: "";
        border: 1px solid var(--color-text);
        width: 6px;
        height: 6px;
        border-left: none;
        border-bottom: none;
        transform: rotate(45deg);
        margin-left: 6px;
        transition: .3s
    } */

    .menu-item-parent.back{
        color: var(--color-grey);
        flex-direction: row-reverse;
        justify-content: flex-end !important;
    }

    .menu-item-parent.back svg{
        transform: rotate(180deg);
        margin-right: 10px;
    }

    .menu-item-parent.back svg path {
        fill: var(--color-grey);
    }

    .menu-item-parent-svg{
        width: 9px;
        height: 9px;
    }
    
    .menu-item-wrapper {
        position: relative;
        display: block;
        width: 100%;
        padding: 5px 0;
    }

    .menu-item-wrapper:last-child {
        margin-right: 0;
    }

    .submenu {
        display: none;
        list-style: none;
    }

    .submenu.active {
        display: block;
    }

    .submenu-item.menu-item-parent {
        justify-content: space-between;
        width: 100%;
    }
    .submenu-item.menu-item-parent::after {
        transform: rotate(45deg) !important;
        margin: 0 !important;
    }

    header.with-submenu .langs,
    header.with-submenu .header-phones,
    header.with-submenu .btn {
        display: none;
    }
    


</style>

@endcss


@js
<script>
    if (is_mobile){

        $('.menu-item-wrapper-parent').on('click', function(e){

            if (e.target == $(this).child().el[0] && (e.target.classList.contains('back'))){

                e.preventDefault()

                that = $(this).child().el[0]

                submenu = $(that).parent().el[0].querySelector('.submenu')

                $(that).removeClass('back')
                $(submenu).removeClass('active')
                if (that.closest('ul').classList.contains('menu')){
                    $('header').removeClass('with-submenu')
                    $('.header-menu-langs-and-user').css('display', 'flex')
                }

                let items = that.closest('ul').children

                if (that.closest('ul').closest('li'))
                    $(that.closest('ul').closest('li')).child('.menu-item.back').css('display', 'flex')

                for (var i = 0; i < items.length; i++){

                    if(!items[i].classList.contains('menu-item-wrapper-parent'))
                        $(items[i]).css('display', 'flex');
                    else {
                        $(items[i]).css('display', 'block');
                    }
                    
                }
            }
        })

        $('.menu-item-parent-svg').on('click', function (e) {
            e.preventDefault()
            submenu = $(this).parent().parent().el[0].querySelector('.submenu')
            this_li = $(this).parent().parent()
            
            if (!$(this).parent().el[0].classList.contains('back')){

                $(submenu).addClass('active')
                $(this).parent().addClass('back')
                $('header').addClass('with-submenu')
                $('.header-menu-langs-and-user').css('display', 'none')

                let items = this.closest('ul').children

                if (this.closest('ul').closest('li'))
                    $(this.closest('ul').closest('li')).child('.menu-item.back').css('display', 'none')


                for (var i = 0; i < items.length; i++){
                    if (items[i] != this_li.el[0]) {
                        $(items[i]).css('display', 'none');
                    }
                }

            } else {

                $(this).parent().removeClass('back')
                $(submenu).removeClass('active')
                if (this.closest('ul').classList.contains('menu')){
                    $('header').removeClass('with-submenu')
                    $('.header-menu-langs-and-user').css('display', 'flex')
                }

                let items = this.closest('ul').children

                if (this.closest('ul').closest('li'))
                    $(this.closest('ul').closest('li')).child('.menu-item.back').css('display', 'flex')

                for (var i = 0; i < items.length; i++){

                    if(!items[i].classList.contains('menu-item-wrapper-parent'))
                        $(items[i]).css('display', 'flex');
                    else {
                        $(items[i]).css('display', 'block');
                    }
                }

            }

        });


    }
</script>
@endjs
<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;
use Single;

class Error extends Component
{

    public $fields;

    public function __construct()
    {
        
        $s = new Single('Модальное окно', 10, 2);

        $this->fields = [
            'title'     => $s->field('Ошибка регистрации', 'Заголовок', 'text', true, 'Ошибка!'),
            'text'      => $s->field('Ошибка регистрации', 'Текст', 'text', true, 'Сначала <span class="color-second login-modal-recall">авторизуйтесь</span> или <span class="color-second register-modal-recall">зарегистрируйтесь</span>!'),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.modals.error');
    }
}

<?php

namespace App\View\Components\Projects;

use Illuminate\View\Component;
use Single;

class Projects extends Component
{
    public $button;

    public $fields = [];
    public $projects;

    public function __construct($projects = [], $button = "0"){

        $this->button = $button;

        $this->projects = $projects;

        $s = new Single('Проекты', 10, 1);
        $this->fields = [
            'title'          => $s->field('Проекты', 'Заголовок', 'text', true, 'Наши последние проекты'),
            'button_text'    => $s->field('Проекты', 'Кнопка (текст)', 'text', true, 'Все проекты'),
            'button_link'    => $s->field('Проекты', 'Кнопка (ссылка)', 'text', false, '/projects'),
        ];
    }

    public function render(){
        return view('components.projects.projects', [
            'projects'  => $this->projects,
            'button'    => $this->button,
            'fields'    => $this->fields,
        ])->render();
    }
}

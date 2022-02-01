<?php

namespace App\View\Components\Projects;

use Illuminate\View\Component;
use Single;

class ProjectCard extends Component
{
    public $fields = [];
    public $project = [];

    public function __construct($project = []){

        $this->project = $project;

        $s = new Single('Проекты', 10, 1);
        $this->fields = [
            'button_text'    => $s->field('Карточка проекта', 'Кнопка (текст)', 'text', true, 'Читать полностью'),
        ];
    }

    public function render(){
        return view('components.projects.project-card');
    }
}

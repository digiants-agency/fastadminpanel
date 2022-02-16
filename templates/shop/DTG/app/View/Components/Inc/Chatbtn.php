<?php

namespace App\View\Components\Inc;

use Illuminate\View\Component;
use Single;

class Chatbtn extends Component
{
    public $fields;

    public function __construct(){

        $sc = new Single('Контактная информация', 10, 2);
        
        $social = $sc->field('Контактная информация', 'Социальные сети', 'repeat', true);
        $social_items = [];
        foreach ($social as $elm){
            $social_items [] = [
                $elm->field('Ссылка', 'text', ''), 
                $elm->field('Иконка (закрашеная) {32x32}', 'photo', ''), 
                $elm->field('Иконка (маленькая) {15x15}', 'photo', ''), 
                $elm->field('Иконка (разноцветная) {32x32}', 'photo', ''), 
                $elm->field('Название', 'text', ''), 
            ];
            $elm->end();
        }
                
        $this->fields = [
            'social'   => $social_items,
        ];
    }

    public function render(){
        return view('components.inc.chatbtn');
    }
}

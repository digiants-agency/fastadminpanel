<?php

namespace App\View\Components\Inc;

use Illuminate\View\Component;
use Single;

class Footer extends Component
{
    // public $fields;

    public function __construct(){

        // $s = new Single('Футер', 10, 2);
                
        // $this->fields = [
        //     'copyright'         => $s->field('Copyright', 'Copyright', 'textarea', false, '© 2018-2022 SCOWTH. All Rights Reserved.'),
        // ];
    }

    public function render(){
        return view('components.inc.footer');
    }
}

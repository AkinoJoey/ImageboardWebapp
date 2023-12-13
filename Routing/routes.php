<?php

use Response\Render\HTMLRenderer;

return [
    '' => function () : HTMLRenderer {
        return new HTMLRenderer('component/top');
    },
    'submit' => function () : HTMLRenderer {
        return new HTMLRenderer('component/submit');
    }
];
<?php

use Response\Render\HTMLRenderer;

return [
    '' => function () : HTMLRenderer {
        return new HTMLRenderer('component/top');
    }
];
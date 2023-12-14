<?php

use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;

return [
    '' => function () : HTMLRenderer {
        return new HTMLRenderer('component/top');
    },
    'submit' => function () : HTMLRenderer {
        return new HTMLRenderer('component/submit');
    },
    'form/thread' => function () : JSONRenderer {
        // validation
        $title = $_POST['title'];
        $body = $_POST['body'];

        return new JSONRenderer(['success'=>true, 'message'=>$title]);
    }
];
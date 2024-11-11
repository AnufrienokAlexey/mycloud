<?php

class View
{
    function generate($content_view, $template_view, $data = null) : void
    {
        include 'app/views/' . $template_view;
    }
}
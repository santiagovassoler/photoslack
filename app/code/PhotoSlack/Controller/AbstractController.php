<?php

namespace PhotoSlack\Controller;

abstract class AbstractController
{
    /**
     * @param string $file file to be rendered
     * @param array $variables data that will be available through view
     */
    public function render($file, $variables = []) : void
    {
        $controllerName = substr(strrchr(get_class($this), "\\"), 1);
        $templateName = ucfirst(str_replace('Controller', '', $controllerName));

        extract($variables);

        ob_start();
        include( $_SERVER['DOCUMENT_ROOT'] . "/app/code/PhotoSlack/View/". $templateName . '/' . $file . '.php');

        echo ob_get_clean();
    }
}

<?php

class View {
    //bedanya yang ini ga pake cek credentials dulu
    public static function createView ($view, $param)
    {
        foreach ($param as $key => $value)
        {
            $$key = $value;
        }

        ob_start();
        include 'view/'.$view;
        $content = ob_get_contents();
        ob_end_clean();

        ob_start();
        include 'view/layout/layout.php';
        $include = ob_get_contents();
        ob_end_clean();
        return $include;
    }
}
?>
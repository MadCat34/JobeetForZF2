<?php
    class Jobeet
    {
        static public function slugify($text)
        {
            $text = preg_replace('/\W+/', '-', $text);
            $text = strtolower(trim($text, '-'));
            return $text;
        }
    }
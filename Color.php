<?php
    class Color{
    //le pone estilo a la consola: bold, color
            
    public static  function getHEADER(){
        return "\033[95m";
    }

        
    public static function getOKBLUE(){
        return "\033[94m";
    }

   
    public static function getOKCYAN(){
        return "\033[96m";
    }

    public static function getOKGREEN(){
        return "\033[92m";
    }

    public static function getWARNING(){
        return"\033[93m";
    }
    
    public static  function getFAIL(){
        return "\033[91m";
    }

    
    public static function getENDC(){
        return "\033[0m";
    }

    
    public static function getBOLD(){
        return  "\033[1m";
    }

    
    public static function getUNDERLINE(){
        return "\033[4m";
    }
}
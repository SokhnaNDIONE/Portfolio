<?php
namespace App\controllers;



class ErrorController {
    
   public function error(){
       
        require "src/views/pageError.phtml";
    }
}
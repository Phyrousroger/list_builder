<?php

function home(){
    view("home",["myName"=>"Phyo Thu Kha","myAge"=>19]);
}
function about(){
    view("about");
}

function ss(){
    dd($_SESSION);
}



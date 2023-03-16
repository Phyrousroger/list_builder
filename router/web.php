<?php
$uri=$_SERVER["REQUEST_URI"];
$uriArr=parse_url($uri);
$path=$uriArr["path"];

const Routes=[
    "/"=>"page@home",
    "/ss"=>"page@ss",

    "/about-us"=>"page@about",
    "/list"=>"list@index",
    "/list-create"=>"list@create",
    "/list-store"=>["post","list@store"],
    "/list-edit"=>["put","list@edit"],
    "/list-update"=>"list@update",
    "/list-delete"=>["delete","list@delete"],

    "/inventory"=>"inventory@index",
    "/inventory-create"=>"inventory@create",
    "/inventory-store"=>["post","inventory@store"],
    "/inventory-edit"=>["put","inventory@edit"],
    "/inventory-update"=>"inventory@update",
    "/inventory-delete"=>["delete","inventory@delete"]


];
if(array_key_exists($path,Routes) && is_array(Routes[$path]) && checkRequestMethod(Routes[$path][0]))
{
    controller(Routes[$path][1]);
}
elseif(array_key_exists($path,Routes) && !is_array(Routes[$path]))
{
    controller(Routes[$path]);
}
else {
    view("not-found");
}

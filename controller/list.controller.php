<?php

function index(){
    $sql="SELECT * FROM my";

    if(isset($_GET["q"])){
        $q=$_GET["q"];
        $sql.=" WHERE name LIKE '%$q%'";
    }

//    dd($lists);

    //total?
    //limit= 10(rows per pages)
    //currentPage=1;
    //offset=(currentPage-1)*limit;


    //SELECT * FROM my LIMIT 0,10 -page=>1;
    //SELECT * FROM my LIMIT 10,20 -page=>2;
    //SELECT * FROM my LIMIT 20,30 -page=>3;
    //SELECT * FROM my LIMIT 30,40 -page=>4;
    //SELECT * FROM my LIMIT 0,10 -page=>1;



    return view("list/index",["lists" =>paginate($sql)]);
}

function create()
{
     view("list/create");
}
function store(){
    $name=$_POST["name"];
    $money=$_POST["money"];
    $sql="INSERT INTO my (name,money) VALUES ('$name',$money)";
    run($sql);
    redirect(route("list"),"List create successfully");
}
function delete(){
    $id=$_POST["id"];
    $sql="DELETE FROM my WHERE id=$id";
    run($sql);
       redirect($_SERVER["HTTP_REFERER"],"List delete successfully");
//    dd($_GET);
}

function update(){
    $id=$_GET["id"];
    $sql="SELECT * FROM my WHERE id=$id";

//    dd($list);


    return view("list/update",["list"=>first($sql)]);

}
function edit(){
    $id=$_POST["id"];
    $name=$_POST["name"];
    $money=$_POST["money"];
    $sql="UPDATE my SET name='$name',money=$money WHERE id=$id";
    $query=run($sql);

    redirect($_SERVER["HTTP_REFERER"],"List update successfully");
}
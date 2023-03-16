<?php

function index(){
    $sql="SELECT * FROM inventories";

    if(isset($_GET["q"])){
        $q=$_GET["q"];
        $sql.=" WHERE name LIKE '%$q%'";
    }

//    dd($lists);

    //total?
    //limit= 10(rows per pages)
    //currentPage=1;
    //offset=(currentPage-1)*limit;


    //SELECT * FROM inventories LIMIT 0,10 -page=>1;
    //SELECT * FROM inventories LIMIT 10,20 -page=>2;
    //SELECT * FROM inventories LIMIT 20,30 -page=>3;
    //SELECT * FROM inventories LIMIT 30,40 -page=>4;
    //SELECT * FROM inventories LIMIT 0,10 -page=>1;



    return view("inventory/index",["lists" =>paginate($sql)]);
}

function create()
{
     view("inventory/create");
}
function store(){
//    dd($_POST);
    $name=$_POST["name"];
    $price=$_POST["price"];
    $stock=$_POST["stock"];
    $sql="INSERT INTO inventories (name,price,stock) VALUES ('$name',$price,$stock)";
    run($sql);
   return redirect(route("inventory"),"List create successfully");
}
//
function delete(){
    $id=$_POST["id"];
    $sql="DELETE FROM inventories WHERE id=$id";
    run($sql);
       redirect($_SERVER["HTTP_REFERER"],"List delete successfully");
//    dd($_GET);
}

function update(){
    $id=$_GET["id"];
    $sql="SELECT * FROM inventories WHERE id=$id";

//    dd($list);


    return view("inventory/update",["list"=>first($sql)]);

}
function edit(){
//    dd($_POST);
    $id=$_POST["id"];
    $name=$_POST["name"];
    $price=$_POST["price"];
    $stock=$_POST["stock"];
    $sql="UPDATE inventories SET name='$name',price=$price,stock=$stock WHERE id=$id";
   run($sql);

//    redirect($_SERVER["HTTP_REFERER"],"Item update successfully");
   return redirect(route("inventory"),"Item update successfully");
}
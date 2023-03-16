<?php


function dd($data, $showType = false): void
{
echo "<pre style='background-color: #1d1d1d;color: #cdcdcd; padding: 20px; margin: 10px; border-radius: 10px; line-height: 1.2rem;'>";
    if ($showType) {
        var_dump($data);
    } else {
        print_r($data);
    }
    echo  "</pre>";
die();
}

function url(string $path = null): string
{
$url = isset($_SERVER["HTTPS"]) ? "https" : "http";
$url .= "://";
$url .= $_SERVER["HTTP_HOST"];
if (isset($path)) {
$url .= "/";
$url .= $path;
}
return $url;
}

function view(string $viewName,array $data=null):void {

    //array to variable
    if(!is_null($data)){
        foreach ($data as $key=>$value){
            ${"$key"}= $value;
        }

    }

    $shareData=$data;
    require_once ViewDir."/$viewName.view.php";
}
function controller(string $controllerName):void {
    //string to array is expolode function
    //"list@index"=>["list/index"];
    $controllerNameArray=explode("@",$controllerName);
    require_once ControllerDir."/$controllerNameArray[0].controller.php";

    call_user_func($controllerNameArray[1]);

}
function route(string $path,array $queries=null):string
{
    $url=url($path);
    if(!is_null($queries)){
        $url .="?".http_build_query($queries);
    }
    return $url;
}
function redirect(string $url,string $massage=null):void{
    if(!is_null($massage)){
        setSession($massage);
    }
    header("LOCATION:".$url);
}
function checkRequestMethod(string $methodName):bool
{
    $serverRequestMethod=$_SERVER["REQUEST_METHOD"];
    $methodName=strtoupper($methodName);
   if($methodName==="POST" && $serverRequestMethod==="POST"){
       return true;
   }elseif ($methodName==="PUT" && $serverRequestMethod==="POST" && !empty($_POST["_method"]) && strtoupper($_POST["_method"])==="PUT"){
       return true;
   }
   elseif ($methodName==="DELETE" && $serverRequestMethod==="POST" && !empty($_POST["_method"]) && strtoupper($_POST["_method"])==="DELETE"){
       return true;
   }
   return false;

}

function logger(string $message, int $colorCode = 32): void
{
    echo " \e[39m[LOG]" . " \e[{$colorCode}m" . $message . " \n";
}

function alert(string $message,string $color="success"): string
{
    return "<div class=' alert alert-$color'>$message</div>";
}
function paginator($lists){
    $links="";
    foreach ($lists["links"] as $link){
        $links.="<li class='page-item'><a class='page-link ". $link['is_active']." 'href='"  .$link['url']. "'>". $link['page_number']."</a></li>";

    }
    ;
    return "<div class='d-flex justify-content-between'>
    <p class=' mb-0'>Total:".$lists['total']."</p>
    <nav>
        <ul class='pagination'>".$links. "</ul>
    </nav>
</div>";

}


function filter($str) {
//    $str=strip_tags($str);
    $str=htmlentities($str,ENT_QUOTES);
//    $str=stripcslashes($str);
    return $str;
}
//session function start
function setSession(string $massage,string $key="massage"):void
{
//    $_SESSION['key']=value;
    $_SESSION[$key]=$massage;
}
function hasSession (string $key="massage"):bool {
    if(!empty($_SESSION[$key])) return true;
    return false;
}
function showSession(string $key="massage"):string {
    $massage=$_SESSION[$key];
    unset($_SESSION[$key]);
    return $massage;
}

//session function end


//database function start
function run(string $sql ,bool $connectionClose=false) :bool|object
{
    try {

        $query= mysqli_query($GLOBALS["conn"],$sql);

        if($connectionClose) mysqli_close($GLOBALS['conn']);
        return $query;
    }catch (Exception $e){
        dd($e) ;
    }

}

function all(string $sql):array {
    $lists=[];
    $query=run($sql);
    while ($row = mysqli_fetch_assoc($query)){
//        array_push($lists,$row);
        $lists[]=$row;
    }
    return $lists;
}
function first (string $sql):array {
    $query=run($sql);
    $list=mysqli_fetch_assoc($query);
    return $list;
}

//database function end
function paginate($sql,$limit=10){
    $total=first(str_replace("*","COUNT(id) AS total",$sql))["total"];

    $totalPages=ceil($total/$limit);
    $currentPage=isset($_GET["pages"]) ? $_GET["pages"]:1;
    $offset=($currentPage-1)*$limit;
    $links=[];
    for($i=1;$i<=$totalPages;$i++){
        $queries=$_GET;
        $queries['pages']=$i;

        $url=url().$GLOBALS["path"]."?".http_build_query($queries);
        $links[]=[
            "url"=>$url,
            "is_active"=> $i==$currentPage?"active":"",
            "page_number"=>$i
        ];
    }

    $sql.=" LIMIT $offset,$limit ";
    $lists=[
        "total"=>$total,
        "limit"=>$limit,
        "total_page"=>$totalPages,
        "current_page"=>$currentPage,
        "data"=>all($sql),
        "links"=>$links
    ];
    return $lists;
}

function createTable(string $tableName,...$columns):void {

    $sql="DROP TABLE IF EXISTS $tableName";
    run($sql);
    logger($tableName." table delete successfully",93);

    $sql="CREATE TABLE $tableName (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  ".join(",",$columns).",
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
";

    run($sql);
    logger($tableName." table create successfully");
}
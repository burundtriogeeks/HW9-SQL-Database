<?php

    define("_NUM_OF_TEST",10000);
    define("_NUM_OF_INSERTS",10000);
    define("_NUM_OF_RANGE_TEST",10);

    require_once "names_list.php";
    require_once "surnames_list.php";

    global $names_list,$surnames_list;


    $db = mysqli_connect("mariadb", "root", "root_password", "test");

    if (isset($_GET["insert"])) {
        mysqli_query($db, "SET GLOBAL `innodb_flush_log_at_trx_commit` = ".$_GET["insert"]);
        $time_script = microtime(true);
        for($i = 1; $i <= _NUM_OF_INSERTS; $i++) {
            $name = $names_list[array_rand($names_list)]." ".$surnames_list[array_rand($surnames_list)];
            $date = date("Y/m/d",rand(315532800,1672531200));

            $values = "('$name','$date','$date')";

            mysqli_query($db,"INSERT INTO users (name,date_no_index,date_index) VALUES ".$values);

        }
        $result = (microtime(true) - $time_script) / _NUM_OF_INSERTS;

        echo "avg insert time ".$result."<br>";
        exit;
    }

    if (isset($_GET["hash"])) {
        mysqli_query($db, "SET GLOBAL `innodb_adaptive_hash_index` = ".$_GET["hash"]);
        exit;
    }

    $time_script = microtime(true);

    for ($i = 0; $i < (isset($_GET["range"]) || isset($_GET["noindex"])? _NUM_OF_RANGE_TEST : _NUM_OF_TEST); $i++) {

        $time = rand(1420070400, 1451606400);
        $date = date("Y/m/d",$time);
        $date2 = date("Y/m/d",$time+30*24*60*60);

        mysqli_query($db, "SELECT `id` FROM `users` FORCE INDEX (date_index)  ".
                                " WHERE ".(isset($_GET["noindex"])?"`date_no_index`":"`date_index`").
                                (isset($_GET["range"])? " BETWEEN '$date' AND '$date2'" : " = '$date'"));

    }

    $result = (microtime(true) - $time_script) / (isset($_GET["range"]) || isset($_GET["noindex"])? _NUM_OF_RANGE_TEST : _NUM_OF_TEST);

    echo "avg request time ".$result."<br>";



    $res = mysqli_query($db, "SHOW VARIABLES LIKE 'innodb_adaptive_hash_index'");
    $row = mysqli_fetch_assoc($res);

    echo "Adaptive hash index: ".$row["Value"]."<br>";

    if ($row["Value"] == "ON") {
        $res = mysqli_query($db, "SHOW ENGINE INNODB STATUS");
        $status = mysqli_fetch_assoc($res)["Status"];
        $res = preg_replace("/^.*(ADAPTIVE HASH INDEX.*searches.s).*$/si","$1",$status);
        echo str_replace("\n","<br>",$res);
    }

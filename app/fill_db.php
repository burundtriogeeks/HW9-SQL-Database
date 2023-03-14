<?php

    define("_INSERT_COUNT", 40000000);
    define("_INSERT_PER_QUERY", 100000);

    require_once "names_list.php";
    require_once "surnames_list.php";

    global $names_list,$surnames_list;

    echo "Filling db with 40M records\n";

    do {
        sleep(1);
        echo "Connecting to db...\n";
        $db = mysqli_connect("mariadb", "dev_user", "dev_password", "test");
    } while ($db === false);

    $res = mysqli_query($db, "SELECT count(*) as total_records FROM users");

    $rows_count = mysqli_fetch_assoc($res)["total_records"];

    echo $rows_count." already inserted to DB\n";

    $i = $rows_count+1;

    $j = 0;
    $values = "";
    for  (; $i <= _INSERT_COUNT; $i++) {
        $name = $names_list[array_rand($names_list)]." ".$surnames_list[array_rand($surnames_list)];
        $date = date("Y/m/d",rand(315532800,1672531200));

        $values .= "('$name','$date','$date')";

        if (++$j < _INSERT_PER_QUERY && $i != _INSERT_COUNT) {
            $values .= ",";
        } else {
            mysqli_query($db,"INSERT INTO users (name,date_no_index,date_index) VALUES ".$values);
            $j = 0;
            $values = "";
            echo $i." records inserted\n";
        }

    }




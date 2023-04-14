<?php

$input = json_decode(file_get_contents("php://input"), true);

$result["state"] = true;

if ($input["action"] == NULL) {
    $result["state"] = false;
    $result["error"]["message"][] = "'action' is missing";
}
if ($input["datetime"] == NULL) {
    $result["state"] = false;
    $result["error"]["message"][] = "'datetime' is missing";
}
if ($result["state"] == false) {
    echo json_encode($result);
    exit;
}

if ($input["action"] == "formating") {
    if ($input["format"] == NULL) {
        $result["state"] = false;
        $result["error"]["message"][] = "'format' is missing";
        echo json_encode($result);
        exit;
    }
    $result["formating"] = date($input["format"], strtotime($input["datetime"]));
} else if ($input["action"] == "compare") {
    $time1 = strtotime($input["datetime"]);
    if ($input["datetime2"] == NULL) {
        $time2 = time();
    } else {
        $time2 = strtotime($input["datetime2"]);
    }
    if ($time1 > $time2) {
        $result["future"] = true;
    } else {
        $result["future"] = false;
    }
    $result["diff"] = [
        "absolute" => [
            "year" => abs(round(($time1 - $time2) / 31536000)),
            "month" => abs(round(($time1 - $time2) / 2592000)),
            "week" => abs(round(($time1 - $time2) / 604800)),
            "days" => abs(round(($time1 - $time2) / 86400)),
            "hour" => abs(round(($time1 - $time2) / 3600)),
            "minute" => abs(round(($time1 - $time2) / 60)),
            "second" => abs($time1 - $time2),
        ],
        "real" => [
            "year" => round(($time1 - $time2) / 31536000),
            "month" => round(($time1 - $time2) / 2592000),
            "week" => round(($time1 - $time2) / 604800),
            "days" => round(($time1 - $time2) / 86400),
            "hour" => round(($time1 - $time2) / 3600),
            "minute" => round(($time1 - $time2) / 60),
            "second" => $time1 - $time2,
        ]
    ];
} else {
    $result["state"] = false;
    $result["error"]["message"][] = "'action' is not supported";
}


echo json_encode($result, JSON_UNESCAPED_UNICODE);
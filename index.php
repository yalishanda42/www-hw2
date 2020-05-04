<?php

require_once "config/config.php";

define("FIRSTNAME_FIELDNAME", "firstname");
define("FAMILYNAME_FIELDNAME", "familyname");
define("MAJOR_FIELDNAME", "major");
define("ACADEMIC_YEAR_FIELDNAME", "academic_year");
define("FN_FIELDNAME", "faculty_number");
define("MAJORGROUP_FIELDNAME", "major_group");
define("BIRTHDATE_FIELDNAME", "birth_date");
define("LINK_FIELDNAME", "hyperlink");
define("MOTIVATION_FIELDNAME", "motivation");
define("ZODIAC_FIELDNAME", "zodiac"); // WARNING: should never be input by user
define("PHOTO_FIELDNAME", "photo");

$errors = [];

$field_values = [
    FIRSTNAME_FIELDNAME => "",
    FAMILYNAME_FIELDNAME => "",
    MAJOR_FIELDNAME => "",
    ACADEMIC_YEAR_FIELDNAME => "",
    FN_FIELDNAME => "",
    MAJORGROUP_FIELDNAME => "",
    BIRTHDATE_FIELDNAME => "",
    LINK_FIELDNAME => "",
    MOTIVATION_FIELDNAME => "",
    PHOTO_FIELDNAME => "",
];

$ZODIAC_TRANSLATIONS = [
    "AQUARIUS" => "Водолей",
    "PISCES" => "Риби",
    "ARIES" => "Овен",
    "TAURUS" => "Телец",
    "GEMINI" => "Близнаци",
    "CANCER" => "Рак",
    "LEO" => "Лъв",
    "VIRGO" => "Дева",
    "LIBRA" => "Везни",
    "SCORPIO" => "Скорпион",
    "SAGITTARIUS" => "Стрелец",
    "CAPRICORN" => "Козирог",
];

function empty_field_error_message($field) {
    switch ($field) {
        case FIRSTNAME_FIELDNAME:
            return "Моля попълнете името си!";
        case FAMILYNAME_FIELDNAME:
            return "Моля попълнете фамилното си име!";
        case MAJOR_FIELDNAME:
            return "Моля попълнете специалността си!";
        case ACADEMIC_YEAR_FIELDNAME:
            return "Моля попълнете в кой курс сте (1, 2, 3, ...)!";
        case FN_FIELDNAME:
            return "Моля попълнете факултетния си номер!";
        case MAJORGROUP_FIELDNAME:
            return "Моля попълнете номера на групата, в която сте!";
        case BIRTHDATE_FIELDNAME:
            return "Моля попълнете датата си на раждане!";
        case LINK_FIELDNAME:
            return "Моля оставете ваш линк към личен уебсайт, блог или профил в социална мрежа!";
        case MOTIVATION_FIELDNAME:
            return "Моля напишете своята мотивация за кандидатстването!";
        case PHOTO_FIELDNAME:
            return "Моля прикачете своя снимка!";
    }
}

function zodiacForDate($datestr) {
    $ymd = explode("-", $datestr);  // assuming YYYY-MM-DD format
    $m = (int)$ymd[1];
    $d = (int)$ymd[2];

    if ($m == 1 && ($d >= 20 && $d <= 31) || $m == 2 && ($d >= 1 && $d <= 18)) {
        return "AQUARIUS";
    } else if ($m == 2 && ($d >= 19 && $d <= 29) || $m == 3 && ($d >= 1 && $d <= 20)) {
        return "PISCES";
    } else if ($m == 3 && ($d >= 21 && $d <= 31) || $m == 4 && ($d >= 1 && $d <= 19)) {
        return "ARIES";
    } else if ($m == 4 && ($d >= 20 && $d <= 30) || $m == 5 && ($d >= 1 && $d <= 20)) {
        return "TAURUS";
    } else if ($m == 5 && ($d >= 21 && $d <= 31) || $m == 6 && ($d >= 1 && $d <= 21)) {
        return "GEMINI";
    } else if ($m == 6 && ($d >= 22 && $d <= 30) || $m == 7 && ($d >= 1 && $d <= 22)) {
        return "CANCER";
    } else if ($m == 7 && ($d >= 23 && $d <= 31) || $m == 8 && ($d >= 1 && $d <= 22)) {
        return "LEO";
    } else if ($m == 8 && ($d >= 23 && $d <= 31) || $m == 9 && ($d >= 1 && $d <= 22)) {
        return "VIRGO";
    } else if ($m == 9 && ($d >= 23 && $d <= 30) || $m == 10 && ($d >= 1 && $d <= 22)) {
        return "LIBRA";
    } else if ($m == 10 && ($d >= 23 && $d <= 31) || $m == 11 && ($d >= 1 && $d <= 21)) {
        return "SCORPIO";
    } else if ($m == 11 && ($d >= 22 && $d <= 30) || $m == 12 && ($d >= 1 && $d <= 21)) {
        return "SAGITTARIUS";
    } else if ($m == 12 && ($d >= 22 && $d <= 31) || $m == 1 && ($d >= 1 && $d <= 19)) {
        return "CAPRICORN";
    } else {
        return false;
    }
}

if (isset($_POST["submit"])) {

    foreach ($field_values as $field_name => $field_default_value) {
        $value = $_POST[$field_name] ?? $field_default_value;

        if (empty($value)) {
            $errors[] = empty_field_error_message($field_name);
        } else {
            $field_values[$field_name] = $value;
        }

        switch ($field_name) {
            case BIRTHDATE_FIELDNAME:
                if (!preg_match("/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/", $value)) {
                    $errors[] = "Моля въведете правилна дата във формат ГГГГ-ММ-ДД!";
                } else {
                    $field_values[ZODIAC_FIELDNAME] = zodiacForDate($value);

                    if (!$field_values[ZODIAC_FIELDNAME]) {
                        $errors[] = "Моля въведете валидна дата!";
                    }
                }
                break;
            case ACADEMIC_YEAR_FIELDNAME:
                $yearInt = (int)$value;
                if (!$yearInt) {
                    $errors[] = "Моля въведете цифра, съответстваща на академичната ви година!";
                } else {
                    $field_values[ACADEMIC_YEAR_FIELDNAME] = $yearInt;
                }
                break;
            case MAJORGROUP_FIELDNAME:
                $groupInt = (int)$value;
                if (!$groupInt) {
                    $errors[] = "Моля въведете цифра, съответстваща на вашата група!";
                } else {
                    $field_values[MAJORGROUP_FIELDNAME] = $groupInt;
                }
                break;
            case PHOTO_FIELDNAME:
                // TODO
                break;
        }
    }

    $db = null;

    if (empty($errors)) {
        $db_host = SETTINGS["DATABASE_HOST"];
        $db_user = SETTINGS["DATABASE_USER"];
        $db_pass = SETTINGS["DATABASE_PASSWORD"];
        $db_name = SETTINGS["DATABASE_NAME"];

        try {
            $db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
        } catch (PDOException $exception) {
            error_log("[!!] FATAL: Database connection unsucessful: " . $exception->getMessage());
            $errors[] = "Изникна ни проблем. Пробвайте пак по-късно.";
        }
    }

    if (empty($errors) && isset($db)) {
        $qry = "INSERT INTO users (
                    first_name,
                    family_name,
                    academic_year,
                    major,
                    fn,
                    major_group,
                    birth,
                    zodiac_sign,
                    hyperlink,
                    photo_filepath,
                    motivation
                ) VALUES (
                    :firstname,
                    :familyname,
                    :year,
                    :major,
                    :fn,
                    :majorgroup,
                    :birth,
                    :zodiac,
                    :hyperlink,
                    :photo,
                    :motivation
                )";

        $stmt = $db->prepare($qry);

        $stmt->bindParam(":firstname", $field_values[FIRSTNAME_FIELDNAME]);
        $stmt->bindParam(":familyname", $field_values[FAMILYNAME_FIELDNAME]);
        $stmt->bindParam(":year", $field_values[ACADEMIC_YEAR_FIELDNAME]);
        $stmt->bindParam(":major", $field_values[MAJOR_FIELDNAME]);
        $stmt->bindParam(":fn", $field_values[FN_FIELDNAME]);
        $stmt->bindParam(":majorgroup", $field_values[MAJORGROUP_FIELDNAME]);
        $stmt->bindParam(":birth", $field_values[BIRTHDATE_FIELDNAME]);
        $stmt->bindParam(":zodiac", $field_values[ZODIAC_FIELDNAME]);
        $stmt->bindParam(":hyperlink", $field_values[LINK_FIELDNAME]);
        $photo = "test.png"; // TODO
        $stmt->bindParam(":photo", $photo);
        $stmt->bindParam(":motivation", $field_values[MOTIVATION_FIELDNAME]);

        if (!$stmt->execute()) {
            error_log("[!!] CRITICAL: Database query unsucessful: " . $stmt->errorInfo()[2]);
            $errors[] = "Изникна ни проблем със заявката. Пробвайте пак по-късно.";
        }
    }

    if (empty($errors)) {
        header("Location: success.php");
    }
}

if (isset($field_values[ZODIAC_FIELDNAME])) {
    $field_values[ZODIAC_FIELDNAME] = $ZODIAC_TRANSLATIONS[$field_values[ZODIAC_FIELDNAME]];
}

$error_html = implode("<br />", $errors);

$template_dir = SETTINGS["TEMPLATES_DIR"] . "/" . SETTINGS["TEMPLATE_NAME"];
include "$template_dir/index.html";

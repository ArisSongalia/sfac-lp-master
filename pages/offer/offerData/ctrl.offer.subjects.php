<?php
include '../../../includes/conn.php';
session_start();

//  submit button
if (isset($_POST['add'])) {

    $subj_code = $db->real_escape_string($_POST['subj_code']);
    $subj_id = $db->real_escape_string($_POST['subj_id']);
    $day  = $db->real_escape_string($_POST['day']);
    $time = $db->real_escape_string($_POST['time']);
    $room = $db->real_escape_string($_POST['room']);
    $section = $db->real_escape_string($_POST['section']);
    $special_tut = $_POST['special_tut'];
    $instructor = $db->real_escape_string($_COOKIE['instructor']);
    $acad_year = $db->real_escape_string($_COOKIE['ay']);
    $semester = $db->real_escape_string($_COOKIE['sem']);

    // required fields
    if (!empty($_POST['day']) and !empty($_POST['time']) and !empty($_POST['room'])) {
        // Invalid same content
        $check = $db->query("SELECT * FROM tbl_schedules WHERE class_code = '$subj_code' AND subj_id = '$subj_id' AND faculty_id = '$instructor' AND day = '$day' AND time = '$time' AND room = '$room' AND section = '$section' AND acad_year = '$acad_year' AND semester = '$semester' AND special_tut = '$special_tut'") or die($db->error);
        $count = $check->num_rows;
        if ($count == 0) {
            // insert Data
            $query = $db->query("INSERT INTO tbl_schedules (class_code, subj_id, faculty_id, day, time, room, section, acad_year, semester, special_tut, room_status) VALUES ('$subj_code', '$subj_id', '$instructor', '$day' , '$time', '$room', '$section', '$acad_year', '$semester', '$special_tut[0]', 0)") or die($db->error);
            $_SESSION['SASched'] = true;
            unset($_COOKIE['ay']);
            unset($_COOKIE['sem']);
            unset($_COOKIE['instructor']);
            header("location: ../offer.subjects.php?eay=" . $_SESSION['back_eay'] . "&CID=" . $_SESSION['back_CID']. "&semester=" . $_SESSION['back_semester']);
        } else {
            $_SESSION['exist_schedule'] = true;
            unset($_COOKIE['ay']);
            unset($_COOKIE['sem']);
            unset($_COOKIE['instructor']);
            header("location: ../offer.subjects.php?eay=" . $_SESSION['back_eay'] . "&CID=" . $_SESSION['back_CID']. "&semester=" . $_SESSION['back_semester']);
        }
    } else {
        $_SESSION['AFill'] = true;
        unset($_COOKIE['ay']);
        unset($_COOKIE['sem']);
        unset($_COOKIE['instructor']);
        header("location: ../offer.subjects.php?eay=" . $_SESSION['back_eay'] . "&CID=" . $_SESSION['back_CID']. "&semester=" . $_SESSION['back_semester']);
    }
}
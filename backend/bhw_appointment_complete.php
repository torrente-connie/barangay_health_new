<?php

require("dbconn.php");

//fetch data for subject using update,delete and view
if(isset($_POST['ongoingID'])){
  getAllDataForOngoingAppointment();
}


function getAllDataForOngoingAppointment(){
    $conn = dbConn();
    $id = $_POST['ongoingID'];
    $sql = "SELECT 
    		d.user_id as doctor_id,
            d.user_account_id as doctor_account,
            d.user_firstname  as doc_fname, 
            d.user_middlename as doc_mname, 
            d.user_lastname   as doc_lname,
            p.user_id as patient_id,
            p.user_firstname  as patient_fname,
            p.user_middlename as patient_mname,
            p.user_lastname   as patient_lname,
            p.user_account_id as patient_account,
            a.appointment_id as appointment_id,
            a.appointment_patient_fname as appoint_pfname,
            a.appointment_patient_mname as appoint_pmname,
            a.appointment_patient_lname as appoint_plname,
            a.appointment_patient_email as appoint_pemail,
            a.appointment_patient_pnum as appoint_ppnum,
            a.appointment_selected_date as appoint_date,
            a.appointment_selected_time as appoint_dst_id, 
            dst.schedule_start_time as appoint_start_time,
            dst.schedule_end_time as appoint_end_time,
            a.appointment_selected_service as appoint_service,
            a.appointment_type as appointment_type,
            a.appointment_status as appointment_status,
            a.appointment_reason as appointment_reason
            FROM appointment a
            JOIN user d 
            ON a.appointment_doctor_id = d.user_id 
            LEFT JOIN user p 
            ON a.appointment_patient_id = p.user_id 
            JOIN doctor_schedule_time dst 
            ON a.appointment_selected_time = dst.schedule_time_id
            WHERE a.appointment_id = '$id' ";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);
    echo json_encode($row);
}



//fetch data for subject using update,delete and view
if(isset($_POST['completeID'])){
  getAllDataForCompleteAppointment();
}



function getAllDataForCompleteAppointment(){
    $conn = dbConn();
    $id = $_POST['completeID'];
    $sql = "SELECT 
            d.user_id as doctor_id,
            d.user_account_id as doctor_account,
            d.user_firstname  as doc_fname, 
            d.user_middlename as doc_mname, 
            d.user_lastname   as doc_lname,
            p.user_id as patient_id,
            p.user_firstname  as patient_fname,
            p.user_middlename as patient_mname,
            p.user_lastname   as patient_lname,
            p.user_account_id as patient_account,
            a.appointment_id as appointment_id,
            a.appointment_patient_fname as appoint_pfname,
            a.appointment_patient_mname as appoint_pmname,
            a.appointment_patient_lname as appoint_plname,
            a.appointment_patient_email as appoint_pemail,
            a.appointment_patient_pnum as appoint_ppnum,
            a.appointment_selected_date as appoint_date,
            a.appointment_selected_time as appoint_dst_id, 
            dst.schedule_start_time as appoint_start_time,
            dst.schedule_end_time as appoint_end_time,
            a.appointment_selected_service as appoint_service,
            a.appointment_type as appointment_type,
            a.appointment_status as appointment_status,
            a.appointment_reason as appointment_reason
            FROM appointment a
            JOIN user d 
            ON a.appointment_doctor_id = d.user_id 
            LEFT JOIN user p 
            ON a.appointment_patient_id = p.user_id 
            JOIN doctor_schedule_time dst 
            ON a.appointment_selected_time = dst.schedule_time_id
            WHERE a.appointment_id = '$id' ";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);
    echo json_encode($row);
}

?>
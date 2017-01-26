<?php
require_once 'include/rb.php';
require_once 'include/Input.php';

header('Content-type: application/json');

R::setup('mysql:host; dbname=hackteach','root','');

if(isset($_POST['course'])){
	$course = R::dispense('course');

	$course->course_code = Input::get('course_code');
	$course->course_name = Input::get('course_name');
	$course->course_description = Input::get('course_description');
	$course->course_duration = Input::get('course_duration');
	$course->total_cost = Input::get('total_cost');
	$course->course_poster = Input::get('course_poster');

	R::store($course);
}

if(isset($_POST['payments'])){
	$payment = R::dispense('payment');

	$payment->idnumber = Input::get(); // Who paid the fee (Foreign Key)
	$payment->course_code = Input::get(); // For what course (Foreign Key)
	$payment->reg_fee = Input::get();
	$payment->month_one = Input::get();
	$payment->month_two = Input::get();
	$payment->month_three = Input::get();
	$payment->month_four = Input::get();

	R::store($payment);
}

if(isset($_POST['user'])){
	$user = R::dispense('users');

	$user->name = Input::get('name');
	$user->email = Input::get('email');
	$user->idnumber = Input::get('idnumber');
	$user->phone = Input::get('phone');

	R::store($user);
}

// Select user(s) from the database 
if(isset($_GET[''])){
	if(isset($_GET['id'])){
		$sql = "SELECT * FROM users WHERE id = {$id}";
	}
	else{
		$sql = "SELECT * FROM users";
	}
	$results = R::exec($sql);
	echo json_encode($results);
}


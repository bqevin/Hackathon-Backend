<?php
require_once 'include/rb.php';
require_once 'include/Input.php';

header('Content-type: application/json');

R::setup('mysql:host=localhost; dbname=tusemeza_sandbox','tusemeza_root','Wr4w@M^BLAT0');

if(isset($_POST['course'])){
	$course = R::dispense('course');
	$coursecode = Input::get('course_code');

	if(!$find  = R::findOne( 'course', ' course_code = ? ', [ $coursecode ] )){

		$course->course_code = $coursecode;
		$course->course_name = Input::get('course_name');
		$course->course_description = Input::get('course_description');
		$course->course_duration = Input::get('course_duration');
		$course->total_cost = Input::get('total_cost');
		$course->course_poster = Input::get('course_poster');

		$id = R::store($course);
		$res = R::load('course', $id);
	}
	else{
		$res = 'Error: Course already Exists!';
	}
	echo json_encode($res);
}

if(isset($_POST['question'])){
	$quiz = R::dispense('questions');

	$quiz->course_code = Input::get('course_code'); // For what course (Foreign Key)
	$quiz->quiz = Input::get('question');
	$quiz->ans_a = Input::get('ans_a');
	$quiz->ans_b = Input::get('ans_b');
	$quiz->ans_c = Input::get('ans_c');
	$quiz->ans_d = Input::get('ans_d');
	$quiz->ans_e = Input::get('ans_e');

	$id = R::store($quiz);

	echo json_encode(R::load('questions', $id));
}

if(isset($_POST['user'])){
	$user = R::dispense('users');
	
	$user->name = Input::get('name');
	$user->email = Input::get('email');
	$user->idnumber = Input::get('idnumber');
	$user->phone = Input::get('phone');
	$user->password = Input::get('password');
	$user->hash = Input::get('hash');
	$user->course_code = Input::get('course_code');
	$user->first_attempt = Input::get('first_attempt');
	$user->second_attempt = Input::get('second_attempt');
	$user->third_attempt = Input::get('third_attempt');

	R::store($user);
}


// Update user onformation    

// Select user(s) from the database 
if(isset($_GET['get_user'])){
	if(isset($_GET['id'])){
		$sql = "SELECT * FROM users WHERE id = {$id}";
	}
	else{
		$sql = "SELECT * FROM users";
	}
	$results = R::exec($sql);
	echo json_encode($results);
}

if(isset($_GET['questions'])){
	$sql = "SELECT * FROM questions";
	$res =  R::exec($sql);
	$res = shuffle($res);

	$results = array();
	for ($i=0; $i < 10; $i++) { 
		$arr = array_push($results, $variable);
	}
	echo json_encode($results);
}

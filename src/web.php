<?php
use App\Router;

Router::get("/init", "ActionController@init");

Router::get("/", "ViewController@main");
Router::get("/overview", "ViewController@overview");
Router::get("/admin", "ViewController@admin");

// 사용자 관리
Router::get("/sign-in", "ViewController@signIn");
Router::get("/sign-up", "ViewController@signUp");

Router::get("/sign-out", "ActionController@signOut");
Router::post("/sign-in", "ActionController@signIn");
Router::post("/sign-up", "ActionController@signUp");

// 예약 관리자
Router::get("/reserve-admin", "ViewController@reserveAdmin");
Router::get("/reserve-detail/{id}", "ViewController@reserveDetail");

Router::post("/insert/meeting", "ActionController@insertMeeting");
Router::post("/update/meeting", "ActionController@updateMeeting");
Router::get("/delete/meeting", "ActionController@deleteMeeting");
Router::get("/active/reserves/{id}", "ActionController@activeReserve");

// 예약하기
Router::get("/reserve", "ViewController@reserve", "user");

Router::post("/insert/reserves", "ActionController@insertReserve", "user");

// 예약 확인
Router::get("/reserve-list", "ViewController@reserveList", "user");

Router::post("/update/reserves/{id}", "ActionController@updateReserve", "user");
Router::get("/delete/reserves/{id}", "ActionController@deleteReserve", "user");

// 관리자 예약현황
Router::get("/reserve-graph", "ViewController@reserveGraph");

Router::start();
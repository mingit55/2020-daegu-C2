<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>전주독서대전</title>
    <script src="/js/jquery-3.4.1.slim.min.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <script src="/js/bootstrap.js"></script>
    <link rel="stylesheet" href="/css/font-awesome.css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/common.js"></script>
</head>
<body>
    <!-- 헤더 영역 -->
    <header>
        <div class="container h-100 d-between">
            <a href="/">
                <img src="/images/logo.svg" alt="전주독서대전" height="40">
            </a>
            <div class="nav d-none d-lg-flex">
                <?php if(user()):?>
                    <div class="nav__item">
                        <div class="text-gray"><?=user()->user_name?>님 환영합니다</div>
                    </div>
                <?php endif;?>
                <div class="nav__item">
                    <a href="#">전주독서대전</a>
                    <div class="nav__list">
                        <a href="#">대전소개</a>
                        <?php if(!user()):?>
                            <a href="/sign-in">회원가입/로그인</a>
                        <?php else: ?>
                            <a href="/sign-out">로그아웃</a>
                        <?php endif;?>
                        <a href="/overview">행사개요</a>
                    </div>
                </div>
                <div class="nav__item">
                    <a href="#">온라인 책만들기</a>
                </div>
                <div class="nav__item">
                    <a href="#">독자와의 만남</a>
                    <div class="nav__list">
                        <a href="/reserve">예약하기</a>
                        <a href="/reserve-list">예약확인</a>
                    </div>
                </div>
                <div class="nav__item">
                    <a href="/admin">관리자 페이지</a>
                    <div class="nav__list">
                        <a href="#">행사등록</a>
                        <a href="#">예약관리</a>
                        <a href="/reserve-admin">관리자</a>
                        <a href="/reserve-graph">관리자 예약현황</a>
                    </div>
                </div>
            </div>
            <a href="/overview" class="icon-bars d-lg-none">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>
    </header>
    <!-- /헤더 영역 -->

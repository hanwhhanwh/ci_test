<?php
  include "main_header_only.php";
?>
<nav class="navbar mycolor2 navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/ledger/list">판매관리</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/ledger/list/class/1">매입<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/ledger/list/class/2">매출</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/ledger/search/">기간조회</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">통계</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="/best_product">Best제품</a>
          <a class="dropdown-item" href="#">월별제품별현황</a>
          <a class="dropdown-item" href="#">종류별분포도</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">기초정보</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="/group">구분</a>
          <a class="dropdown-item" href="/product">제품</a>
		  <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="/member">사용자</a>
        </div>
      </li>
    </ul>
	<form class="form-inline my-2 my-lg-0">
		<a class="btn btn-bd-download d-none d-lg-inline-block mb-3 mb-md-0 ml-md-3" href="#">로그인</a>
	</form>
  </div>
</nav>
<?php

include "main_header_only.php";

$is_authorized = $this->session->has_userdata("user_id");
if ( !$is_authorized )
{

?>
<div class="modal fade" id="login_modal" role="dialog" aria-labelledby="login_modal_title" aria-hidden="true">
<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
<div class="modal-content">
	<div class="modal-header mycolor1">
		<h5 class="modal-title" id="login_modal_title">로그인</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
		<form name="form_login" method="post" action="/member/login">
		<div class="form-inline">
			아 이 디 : &nbsp; <input type="text" id="user_id" name="user_id" size="15" value="" calss="form-control form-control-sm" autofocus />
		</div>
		<div style="height:10px"></div>
		<div class="form-inline">
			비밀번호 : &nbsp; <input type="password" name="password" size="15" value="" calss="form-control form-control-sm" />
		</div>
		</form>
	</div>
	<div class="modal-footer alert-secondary">
		<button type="button" class="btn btn-sm btn-primary" onClick="javascript:form_login.submit();">로그인</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">닫기</button>
	</div>
</div></div></div>
<script>
	$('#login_modal').on('shown.bs.modal', function() {
  		$('#user_id').focus();
	})
</script>
<?php

} // end of if ( $is_authorized )

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
				<a class="dropdown-item" href="/product/best">Best제품</a>
				<a class="dropdown-item" href="/ledger/month">월별제품별현황</a>
				<a class="dropdown-item" href="/ledger/donut">종류별분포도</a>
			</div>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">기초정보</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				<a class="dropdown-item" href="/group">구분</a>
				<a class="dropdown-item" href="/product">제품</a>
<?php
if ( $this->session->userdata("rank") == 1 )
{
?>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="/member">사용자</a>
<?php
}
?>
			</div>
		</li>
	</ul>
	<form class="form-inline my-2 my-lg-0">
<?php
if ( $is_authorized )
{
?>
	<a class="btn btn-bd-download d-none d-lg-inline-block mb-3 mb-md-0 ml-md-3" href="/member/logout">로그아웃</a>
<?php
}
else
{
?>
	<a class="btn btn-bd-download d-none d-lg-inline-block mb-3 mb-md-0 ml-md-3" href="#login_modal" data-toggle="modal">로그인</a>
<?php
} // end of if ( $is_authorized )
?>
	</form>
	</div>
</nav>
<div class="alert mycolor1" role="alert">
  사용자
</div>

<script>
<!--
	function find_member() {
    var elmUserName = user_name;
    if (elmUserName.value.trim() == "")
    {
      alert("이름을 입력하여 주십시요.");
      elmUserName.focus();
      return;
    }
		window.location.href = "/member/list/name/" + elmUserName.value.trim();
	}
// -->
</script>
<?php
    $strUri2 = "";
    if (isset($name))
      $strUri2 .= "/name/{$name}";
    if (isset($page))
      $strUri2 .= "/page/{$page}";
?>
<form name="form_find_member" action="" method="GET"></form>
<div class="row">
	<div class="col-3" align="left">
		<div class="input-group input-group-sm mb-3 w-150">
		  <div class="input-group-prepend">
			<span class="input-group-text" id="basic-addon1">이름: </span>
		  </div>
		  <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1"
			onKeydown="if (event.keyCode ===13) { find_member(); }" <?php if (isset($name)) echo "value=\"{$name}\""; ?>>
		  <div class="input-group-append">
			<button class="btn btn-sm btn-outline-secondary" type="button" id="button-addon2" onClick="find_member();" >검색</button>
		  </div>
		</div>
	</div>
	<div class="col-9" align="right">
		<a href="/member/add<?=$strUri2?>" class="btn btn-sm btn-outline-secondary">추가</a>
	</div>
</div>
<table class="table table-sm table-bordered mymargin5">
  <thead>
    <tr class="mycolor2">
      <th scope="col">번호</th>
      <th scope="col">이름</th>
      <th scope="col">아이디</th>
      <th scope="col">암호</th>
      <th scope="col">전화</th>
      <th scope="col">등급</th>
    </tr>
  </thead>
  <tbody>
<?php
	while ($member = $members->unbuffered_row())
	{
		$num = $member->num;
		$tel = $member->tel;
		$rank = ($member->rank == 0) ? "관리자" : "직원";
  
    $strUri = "/num/{$num}" . $strUri2;
  ?>
    <tr>
      <th scope="row"><?php echo $num; ?></th>
      <td><a href="/member/view<?=$strUri?>"><?= $member->user_name ?></a></td>
      <td><?= $member->user_id ?></td>
      <td><?= $member->passwd ?></td>
      <td><?= $member->tel ?></td>
      <td><?= $rank ?></td>
    </tr>
<?php
	}
?>
  </tbody>
</table>
<!--
<nav aria-label="Page navigation example">
  <ul class="pagination pagination-sm justify-content-center">
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Previous">
        <span aria-hidden="false">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>
</nav>
-->
<?=$pagination?>

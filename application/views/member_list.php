<div class="alert mycolor1" role="alert">
  사용자
</div>

<form name="form_find_text" action="" method="GET">
<div class="row">
	<div class="col-3" align="left">
		<div class="input-group input-group-sm mb-3 w-150">
		  <div class="input-group-prepend">
			<span class="input-group-text" id="basic-addon1">이름: </span>
		  </div>
		  <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1"
			onKeydown="if (event.keyCode ===13) { find_text(); }" >
		  <div class="input-group-append">
			<button class="btn btn-sm btn-outline-secondary" type="button" id="button-addon2" onClick="find_text();" >검색</button>
		  </div>
		</div>
	</div>
	<div class="col-9" align="right">
		<a href="/member/add" class="btn btn-sm btn-outline-secondary">추가</a>
	</div>
</div>
</form>
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
?>
    <tr>
      <th scope="row"><?php echo $num; ?></th>
      <td><a href="/member/view/no/<?=$num?>"><?= $member->user_name ?></a></td>
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
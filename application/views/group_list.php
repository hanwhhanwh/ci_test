<div class="alert mycolor1" role="alert">
  구분
</div>

<script>
<!--
	function find_group() {
    var elmUserName = group_name;
    if (elmUserName.value.trim() == "")
    {
      alert("이름을 입력하여 주십시요.");
      elmUserName.focus();
      return;
    }
		window.location.href = "/group/list/name/" + elmUserName.value.trim();
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
<form name="form_find_group" action="" method="GET"></form>
<div class="row">
	<div class="col-3" align="left">
		<div class="input-group input-group-sm mb-3 w-150">
		  <div class="input-group-prepend">
			<span class="input-group-text" id="basic-addon1">이름: </span>
		  </div>
		  <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Group name" aria-label="Group name" aria-describedby="basic-addon1"
			onKeydown="if (event.keyCode ===13) { find_group(); }" <?php if (isset($name)) echo "value=\"{$name}\""; ?>>
		  <div class="input-group-append">
			<button class="btn btn-sm btn-outline-secondary" type="button" id="button-addon2" onClick="find_group();" >검색</button>
		  </div>
		</div>
	</div>
	<div class="col-9" align="right">
		<a href="/group/add<?=$strUri2?>" class="btn btn-sm btn-outline-secondary">추가</a>
	</div>
</div>
<table class="table table-sm table-bordered mymargin5">
  <thead>
    <tr class="mycolor2">
      <th scope="col">번호</th>
      <th scope="col">이름</th>
      <th scope="col">상위번호</th>
      <th scope="col">단계</th>
      <th scope="col">정렬순서</th>
      <th scope="col">수정시각</th>
    </tr>
  </thead>
  <tbody>
<?php
	while ($group = $groups->unbuffered_row())
	{
		$group_no = $group->group_no;
    $strUri = "/group_no/{$group_no}" . $strUri2;
  ?>
    <tr>
      <th scope="row"><?php echo $group_no; ?></th>
      <td><a href="/group/view<?=$strUri?>"><?= $group->group_name ?></a></td>
      <td><?= $group->parent_no ?></td>
      <td><?= $group->level ?></td>
      <td><?= $group->order_no ?></td>
      <td><?= $group->mod_date ?></td>
    </tr>
<?php
	}
?>
  </tbody>
</table>
<?=$pagination?>

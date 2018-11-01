<?php
  $strUri = "";
  if (isset($group_no))
    $strUri .= "/group_no/{$group_no}";
  if (isset($name))
    $strUri .= "/name/{$name}";
  if (isset($page))
    $strUri .= "/page/{$page}";
?>
<div class="alert mycolor1" role="alert">구분 정보</div>
<table class="table table-sm table-bordered mymargin5">
  <tbody>
    <tr>
      <th scope="row" width="40%" style="vertical-align:middle" class="mycolor2">번호</th><td align="left"><?=$group->group_no?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">
		<font color="red">*</font> 이름</th>
	  <td align="left"><?=$group->group_name?></td>
    </tr>
    <tr>
      <th scope="row" width="20%" style="vertical-align:middle" class="mycolor2">
		<font color="red">*</font> 상위번호</th>
	  <td align="left"><?=$group->parent_no?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">
		<font color="red">*</font> 단계</th>
	  <td align="left"><?=$group->level?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">정렬순서</th>
	  <td align="left"><?=$group->order_no?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">최종 수정시각</th>
	  <td align="left"><?=$group->mod_date?></td>
    </tr>
  </tbody>
</table>
<div align="center">
<a class="btn btn-sm btn-outline-secondary" href="/group/edit<?=$strUri?>">수정</a>
<a class="btn btn-sm btn-outline-secondary" href="/group/delete<?=$strUri?>"
		onClick="return confirm('삭제할까요?');">삭제</a>&nbsp;&nbsp;&nbsp;
<button class="btn btn-sm btn-outline-secondary" type="button" id="button-back"
		onClick="history.back();">이전화면으로</button>
</div>

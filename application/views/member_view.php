<div class="alert mycolor1" role="alert">사용자 정보</div>
<table class="table table-sm table-bordered mymargin5">
  <tbody>
    <tr>
      <th scope="row" width="40%" style="vertical-align:middle" class="mycolor2">번호</th><td align="left"><?=$member->num?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">
		<font color="red">*</font> 이름</th>
	  <td align="left"><?=$member->user_name?></td>
    </tr>
    <tr>
      <th scope="row" width="20%" style="vertical-align:middle" class="mycolor2">
		<font color="red">*</font> 아이디</th>
	  <td align="left"><?=$member->user_id?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">
		<font color="red">*</font> 암호</th>
	  <td align="left"><?=$member->passwd?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">전화</th>
	  <td align="left"><?=$member->tel?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">등급</th>
	  <td align="left"><?php echo ($member->rank == 0) ? "관리자" : "직원"; ?></td>
    </tr>
  </tbody>
</table>
<div align="center">
<a class="btn btn-sm btn-outline-secondary" href="/member/edit/no/<?=$member->num?><?php if (isset($name)) echo "/name/{$name}"; ?>">수정</a>
<a class="btn btn-sm btn-outline-secondary" href="/member/delete/no/<?=$member->num?><?php if (isset($name)) echo "/name/{$name}"; ?>"
		onClick="return confirm('삭제할까요?');">삭제</a>&nbsp;&nbsp;&nbsp;
<button class="btn btn-sm btn-outline-secondary" type="button" id="button-back"
		onClick="history.back();">이전화면으로</button>
</div>

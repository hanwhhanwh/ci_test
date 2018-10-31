<?php
  $strAction = "/member/update";
  if (isset($num))
    $strAction .= "/num/{$num}";
  if (isset($name))
    $strAction .= "/name/{$name}";
  if (isset($page))
    $strAction .= "/page/{$page}";
?>
<form id="form_add_member" method="POST" action="<?=$strAction?>">
<div class="alert mycolor1 form-inline" role="alert">사용자 수정</div>
<table class="table table-sm table-bordered mymargin5">
  <tbody>
<?php
	if (isset($member))
	{
		$tel1 =  trim(substr($member->tel, 0, 3));
		$tel2 =  trim(substr($member->tel, 3, 4));
		$tel3 =  trim(substr($member->tel, 7, 4));
		$rank = $member->rank;
?>
    <tr>
      <th scope="row" width="40%" style="vertical-align:middle" class="mycolor2">번호</th><td align="left"><?=$member->num?></td>
    </tr>
<?php
	}
?>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">
  		  <font color="red">*</font> 이름</th>
		  <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="user_name" size="20" maxlength="30" <?php if (isset($member)) echo "value=\"{$member->user_name}\""; ?></div>
        <?php if (form_error("user_name") == true) echo form_error("user_name"); ?></td>
    </tr>
    <tr>
      <th scope="row" width="20%" style="vertical-align:middle" class="mycolor2">
		    <font color="red">*</font> 아이디</th>
		  <td align="left"><input type="text" class="form-control form-control-sm" name="user_id" size="20" maxlength="30" <?php if (isset($member)) echo "value=\"{$member->user_id}\""; ?>>
        <?php if (form_error("user_id") == true) echo form_error("user_id"); ?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">
		    <font color="red">*</font> 암호</th>
		  <td align="left"><div class="form-inline"><input type="password" class="form-control form-control-sm" name="passwd" size="20" maxlength="30"></div>
        <?php if (form_error("passwd") == true) echo form_error("passwd"); ?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">전화</th>
	    <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="tel1" size="3" maxlength="3" <?php if (isset($member)) echo "value=\"{$tel1}\""; ?>>-<input type="text" class="form-control form-control-sm" name="tel2" size="4" maxlength="4" <?php if (isset($member)) echo "value=\"{$tel2}\""; ?>>-<input type="text" class="form-control form-control-sm" name="tel3" size="4" maxlength="4" <?php if (isset($member)) echo "value=\"{$tel3}\""; ?>></div></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">등급</th>
	    <td align="left"><label><input type="radio" name="rank" value="0" <?php if ($rank == 0) echo "checked"; ?>> 관리자</label> <label><input type="radio" name="rank" value="1" <?php if ($rank != 0) echo "checked"; ?>> 사용자</label></td>
    </tr>
  </tbody>
</table>
<div align="center">
<input class="btn btn-sm btn-outline-secondary" type="submit" id="button-edit" value="수정">&nbsp;&nbsp;&nbsp;
<button class="btn btn-sm btn-outline-secondary" type="button" id="button-back"
		onClick="history.back();">이전화면으로</button>
</div>
</form>
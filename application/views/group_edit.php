<?php
  $strAction = "/group/update";
  if (isset($group_no))
    $strAction .= "/group_no/{$group_no}";
  if (isset($name))
    $strAction .= "/name/{$name}";
  if (isset($page))
    $strAction .= "/page/{$page}";
?>
<form id="form_add_group" method="POST" action="<?=$strAction?>">
<div class="alert mycolor1 form-inline" role="alert">사용자 수정</div>
<table class="table table-sm table-bordered mymargin5">
  <tbody>
<?php
	if (isset($group))
	{
?>
    <tr>
      <th scope="row" width="40%" style="vertical-align:middle" class="mycolor2">번호</th><td align="left"><?=$group->group_no?></td>
    </tr>
<?php
	}
?>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2">
  		    <font color="red">*</font> 이름</th>
        <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="group_name" size="20" maxlength="30" <?php 
            if (isset($group)) echo "value=\"{$group->group_name}\""; ?></div><?php
            if (form_error("group_name") == true) echo form_error("group_name"); ?>
        </td>
    </tr>
    <tr>
        <th scope="row" width="20%" style="vertical-align:middle" class="mycolor2">
		    <font color="red">*</font> 상위번호
        </th>
        <td align="left"><input type="text" class="form-control form-control-sm" name="parent_no" size="20" maxlength="30" <?php 
            if (isset($group)) echo "value=\"{$group->parent_no}\""; ?>><?php 
            if (form_error("parent_no") == true) echo form_error("parent_no"); ?>
        </td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2">
		    <font color="red">*</font> 단계
        </th>
        <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="level" size="20" maxlength="30" <?php
            if (isset($group)) echo "value=\"{$group->level}\""; ?>></div><?php 
            if (form_error("level") == true) echo form_error("level"); ?>
        </td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2">순서</th>
        <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="order_no" size="20" maxlength="30" <?php 
            if (isset($group)) echo "value=\"{$group->order_no}\""; ?></div>
        </td>
    </tr>
  </tbody>
</table>
<div align="center">
<input class="btn btn-sm btn-outline-secondary" type="submit" id="button-edit" value="수정">&nbsp;&nbsp;&nbsp;
<button class="btn btn-sm btn-outline-secondary" type="button" id="button-back"
		onClick="history.back();">이전화면으로</button>
</div>
</form>
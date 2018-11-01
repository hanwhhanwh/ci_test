<?php
  $strAction = "/group/insert";
  if (isset($group_no))
    $strAction .= "/group_no/{$group_no}";
  if (isset($name))
    $strAction .= "/name/{$name}";
  if (isset($page))
    $strAction .= "/page/{$page}";
?>
<form id="form_add_group" method="POST" action="<?=$strAction?>">
<div class="alert mycolor1 form-inline" role="alert">구분 추가</div>
<table class="table table-sm table-bordered mymargin5">
  <tbody>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2"><font color="red">*</font> 이름</th>
	    <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="group_name" size="20" maxlength="30" value="<?php echo set_value("group_name"); ?>" / ><?php if (form_error("group_name") == true) echo form_error("group_name"); ?></div></td>
    </tr>
    <tr>
        <th scope="row" width="20%" style="vertical-align:middle" class="mycolor2"><font color="red">*</font> 상위번호</th>
		<td align="left"><input type="text" class="form-control form-control-sm" name="parent_no" size="20" maxlength="30" value="<?=set_value("parent_no"); ?>"><?php if (form_error("parent_no") == true) echo form_error("parent_no"); ?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2"><font color="red">*</font> 단계</th>
		  <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="level" size="20" maxlength="30" value="<?=set_value("level"); ?>"></div><?php if (form_error("level") == true) echo form_error("level"); ?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">정렬순서</th>
	    <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="order_no" size="20" maxlength="30"></div></td>
    </tr>
  </tbody>
</table>
<div align="center">
<input class="btn btn-sm btn-outline-secondary" type="submit" id="button-add" value="추가">&nbsp;&nbsp;&nbsp;
<button class="btn btn-sm btn-outline-secondary" type="button" id="button-back"
		onClick="history.back();">이전화면으로</button>
</div>
</form>
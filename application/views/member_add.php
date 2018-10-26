<form id="form_add_member" method="POST" action="/member/insert">
<div class="alert mycolor1 form-inline" role="alert">사용자 추가</div>
<table class="table table-sm table-bordered mymargin5">
  <tbody>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2"><font color="red">*</font> 이름</th>
		  <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="user_name" size="20" maxlength="30" value="<?php echo set_value("user_name"); ?>" / ><?php if (form_error("user_name") == true) echo form_error("user_name"); ?></div></td>
    </tr>
    <tr>
      <th scope="row" width="20%" style="vertical-align:middle" class="mycolor2"><font color="red">*</font> 아이디</th>
		  <td align="left"><input type="text" class="form-control form-control-sm" name="user_id" size="20" maxlength="30" value="<?=set_value("user_id"); ?>"><?php if (form_error("user_id") == true) echo form_error("user_id"); ?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2"><font color="red">*</font> 암호</th>
		  <td align="left"><div class="form-inline"><input type="password" class="form-control form-control-sm" name="password" size="20" maxlength="30" value="<?=set_value("passwd"); ?>"></div><?php if (form_error("passwd") == true) echo form_error("passwd"); ?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">전화</th>
	    <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="tel1" size="3" maxlength="3">-<input type="text" class="form-control form-control-sm" name="tel2" size="4" maxlength="4">-<input type="text" class="form-control form-control-sm" name="tel3" size="4" maxlength="4"></div></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">등급</th>
	    <td align="left"><label><input type="radio" name="rank" value="0"> 관리자</label> <label><input type="radio" name="rank" value="1" checked> 직원</label></td>
    </tr>
  </tbody>
</table>
<div align="center">
<input class="btn btn-sm btn-outline-secondary" type="submit" id="button-add" value="추가">&nbsp;&nbsp;&nbsp;
<button class="btn btn-sm btn-outline-secondary" type="button" id="button-back"
		onClick="history.back();">이전화면으로</button>
</div>
</form>
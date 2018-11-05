<?php
  $strAction = "/ledger/insert";
  if ( isset($class) && (($class > 0) && ($class <= 2)) )
    $strAction .= "/class/{$class}";
  if (isset($date))
    $strAction .= "/date/{$date}";
  if (isset($page))
    $strAction .= "/page/{$page}";

    $class_name =  ($class == 1) ? "매입" : "매출";
    $class_form_name =  ($class == 1) ? "buy" : "sale";
    $class_color = ($class != 1) ? "red"  : "blue";
?>
<form id="form_add_group" method="POST" enctype="multipart/form-data" action="<?=$strAction?>">
<div class="alert mycolor1 form-inline" role="alert">장부 추가</div>
<table class="table table-sm table-bordered mymargin5">
  <tbody>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">장부종류</th>
      <td align="left"><?=$class_name ?><input type="hidden" name="class" value="<?=$class?>" /></td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2">장부날짜</th>
        <td align="left"><input type="text" name="ledger_date" size="20" max_length="30" value="<?=date("Y-m-d")?>" /></td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2"><font color="red">*</font> 제품명</th>
        <td align="left"><div class="form-inline"><select class="form-control form-control-sm" name="product_no"><option value="">&lt;&lt; 선택하세요. &gt;&gt;</option><?php
            while ($product = $all_products->unbuffered_row())
            {
              echo "<option value=\"{$product->product_no}\"";
              echo ">{$product->product_name}</option>";
            } ?></select></div>
      </td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2"><font color="red">*</font> 단가</th>
      <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="per_price" size="20" maxlength="30" value="<?=set_value("per_price"); ?>"></div><?php if (form_error("per_price") == true) echo form_error("per_price"); ?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2"><?=$class_name?>수량</th>
	    <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="<?=$class_form_name?>_count" size="20" maxlength="30"></div></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2"><?=$class_name?>금액</th>
	    <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="<?=$class_form_name?>_price" size="20" maxlength="30"></div></td>
    </tr>
    <tr>
      <th scope="row" width="20%" style="vertical-align:middle" class="mycolor2">비 고</th>
		  <td align="left"><input type="text" class="form-control form-control-sm" name="note" size="20" maxlength="30" /></td>
    </tr>
  </tbody>
</table>
<div align="center">
<input class="btn btn-sm btn-outline-secondary" type="submit" id="button-add" value="추가">&nbsp;&nbsp;&nbsp;
<button class="btn btn-sm btn-outline-secondary" type="button" id="button-back"
		onClick="history.back();">이전화면으로</button>
</div>
</form>
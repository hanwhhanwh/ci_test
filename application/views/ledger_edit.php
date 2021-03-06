<?php
    $strAction = "/ledger/update";
    if (isset($ledger_no))
        $strAction .= "/ledger_no/{$ledger_no}";
    if (isset($date))
        $strAction .= "/date/{$date}";
    if (isset($page))
        $strAction .= "/page/{$page}";

    $class_name =  ($ledger->class == 1) ? "매입" : "매출";
    $class_form_name =  ($ledger->class == 1) ? "buy" : "sale";
    $class_color = ($ledger->class != 1) ? "red"  : "blue";
?>
<script>
<!--
    function compute_price() {
        form_ledger.<?=$class_form_name?>_price.value = Number(form_ledger.per_price.value) * Number(form_ledger.<?=$class_form_name?>_count.value);
    };

    function find_product() {
        window.open("/product/find/", "find_product", "resizable=yes,scrollbars=yes,width=500,height=600");
    };
//-->
</script>
<form id="form_ledger" method="POST" action="<?=$strAction?>">
<div class="alert mycolor1 form-inline" role="alert">장부 수정</div>
<table class="table table-sm table-bordered mymargin5">
  <tbody>
<?php
	if (isset($ledger))
	{
?>
    <tr>
        <th scope="row" width="40%" style="vertical-align:middle" class="mycolor2">장부번호</th>
        <td align="left"><?=$ledger->ledger_no?></td>
    </tr>
<?php
	}
?>
    <tr>
        <th scope="row" width="20%" style="vertical-align:middle" class="mycolor2">장부종류</th>
        <td align="left"><?=$class_name ?><input type="hidden" name="class" value="<?=$ledger->class?>" /></td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2">장부날짜</th>
        <td align="left"><?=$ledger->ledger_date?><input type="hidden" name="ledger_date" value="<?=$ledger->ledger_date?>" /></td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2"><font color="red">*</font> 제품명</th>
        <td align="left"><input type="hidden" name="product_no" value="<?=$ledger->product_no?>" />
            <div class="form-inline">
                <input type="text" class="form-control form-control-sm" id="product_name" size="20" maxlength="30" value="<?=$ledger->product_name?>" readonly />
                <button class="btn btn-sm btn-outline-secondary" type="button" id="button-addon2" onClick="find_product();" >상품 찾기</button>
            </div>
        </td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2"><font color="red">*</font> 단가</th>
        <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="per_price" size="20" maxlength="30" <?php
            if (isset($ledger)) echo "value=\"{$ledger->per_price}\""; ?>></div><?php 
            if (form_error("per_price") == true) echo form_error("per_price"); ?>
        </td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2"><?=$class_name?>수량</th>
        <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="<?=$class_form_name?>_count" size="20" maxlength="30" onChange="select_product();" <?php 
            if (isset($ledger)) echo ($ledger->class == 1) ? "value=\"{$ledger->buy_count}\"" : "value=\"{$ledger->sale_count}\""; ?></div><?php
            if (form_error("{$class_form_name}_count") == true) echo form_error("{$class_form_name}_count"); ?>
        </td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2"><?=$class_name?>금액</th>
        <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="<?=$class_form_name?>_price" size="20" maxlength="30" readonly <?php 
            if (isset($ledger)) echo ($ledger->class == 1) ? "value=\"{$ledger->buy_price}\"" : "value=\"{$ledger->sale_price}\""; ?></div><?php
            if (form_error("{$class_form_name}_price") == true) echo form_error("{$class_form_name}_price"); ?>
        </td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2">비고</th>
        <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="note" size="20" maxlength="30" <?php 
            if (isset($ledger)) echo "value=\"{$ledger->note}\""; ?></div>
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
<?php
    $strUri = "";
    if (isset($ledger_no))
        $strUri .= "/ledger_no/{$ledger_no}";
    if (isset($class))
        $strUri .= "/class/{$class}";
    if (isset($date))
        $strUri .= "/date/{$date}";
    if (isset($page))
        $strUri .= "/page/{$page}";

    $class_name =  ($ledger->class == 1) ? "매입" : "매출";
    $class_form_name =  ($ledger->class == 1) ? "buy" : "sale";
    $class_color = ($ledger->class != 1) ? "red"  : "blue";
?>
<div class="alert mycolor1" role="alert">장부 정보</div>
<table class="table table-sm table-bordered mymargin5">
  <tbody>
    <tr>
        <th scope="row" width="40%" style="vertical-align:middle" class="mycolor2">장부번호</th>
        <td align="left"><?=$ledger->ledger_no?></td>
    </tr>
    <tr>
        <th scope="row" width="20%" style="vertical-align:middle" class="mycolor2">장부종류</th>
	    <td align="left"><?=$class_name ?></td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2">장부날짜</th>
        <td align="left"><?=$ledger->ledger_date?></td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2">제품명</th>
        <td align="left"><?=$ledger->product_name?></td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2">단가</th>
        <td align="left"><?=number_format($ledger->per_price)?></td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2"><?=$class_name?>수량</th>
        <td align="left"><font color="<?=$class_color?>"><?=($ledger->class == 1) ? number_format($ledger->buy_count) : number_format($ledger->sale_count);?></font></td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2"><?=$class_name?>금액</th>
        <td align="left"><font color="<?=$class_color?>"><?=($ledger->class == 1) ? number_format($ledger->buy_price) : number_format($ledger->sale_price);?></font></td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2">최종 수정시각</th>
	    <td align="left"><?=$ledger->mod_date?></td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2">비 고</th>
	    <td align="left"><?=$ledger->note?></td>
    </tr>
  </tbody>
</table>
<div align="center">
<a class="btn btn-sm btn-outline-secondary" href="/ledger/edit<?=$strUri?>">수정</a>
<a class="btn btn-sm btn-outline-secondary" href="/ledger/delete<?=$strUri?>"
		onClick="return confirm('삭제할까요?');">삭제</a>&nbsp;&nbsp;&nbsp;
<button class="btn btn-sm btn-outline-secondary" type="button" id="button-back"
		onClick="history.back();">이전화면으로</button>
</div>

<div class="alert mycolor1" role="alert">
  Best 상품
</div>

<script>
<!--
	function best_product() {
        var elmUserName = start_date;
        var strURL = "/product/best";
        if (elmUserName.value.trim() == "")
        {
            alert("시작날짜를 입력하여 주십시요.");
            elmUserName.focus();
            return;
        }

        elmUserName = end_date;
        if (elmUserName.value.trim() == "")
        {
            alert("종료날짜를 입력하여 주십시요.");
            elmUserName.focus();
            return;
        }

        strURL += "/start_date/" + start_date.value.trim() + "/end_date/" + end_date.value.trim()
		window.location.href = strURL;
	}
// -->
</script>
<?php
    $strUri2 = "";
    if (isset($start_date))
      $strUri2 .= "/start_date/{$start_date}";
    if (isset($end_date))
      $strUri2 .= "/end_date/{$end_date}";
    if (isset($page))
      $strUri2 .= "/page/{$page}";
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<script>
    $.datepicker.setDefaults({
        dateFormat: 'yy-mm-dd',
        prevText: '이전 달',
        nextText: '다음 달',
        monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        dayNames: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        showMonthAfterYear: true,
        yearSuffix: '년'
    });

    $(function() {
        $("#start_date").datepicker();
        $("#end_date").datepicker();
    });
</script>
<form name="form_ledger" action="" method="GET">
<div class="row">
	<div class="col-6" align="left">
		<div class="input-group input-group-sm mb-3 w-150">
		  <div class="input-group-prepend">
			<span class="input-group-text" id="basic-addon1">기간: </span>
		  </div>
		  <input type="text" class="form-control" id="start_date" name="start_date" maxlength="10" autocomplete="off" placeholder="   시작 날짜   " aria-label="   시작 날짜   " aria-describedby="basic-addon1"
			onKeydown="if (event.keyCode ===13) { best_product(); }" <?php if (isset($start_date)) echo "value=\"{$start_date}\""; ?>>
          ~ <input type="text" class="form-control" id="end_date" name="end_date" maxlength="10" autocomplete="off" placeholder="   종료 날짜   " aria-label="   종료 날짜   " aria-describedby="basic-addon1"
			onKeydown="if (event.keyCode ===13) { best_product(); }" <?php if (isset($end_date)) echo "value=\"{$end_date}\""; ?>>
			&nbsp;&nbsp;<button class="btn btn-sm btn-outline-secondary" type="button" id="button-addon2" onClick="best_product();" >조회</button>
		</div>
	</div>
	<div class="col-6" align="right">
	</div>
</div>
</form>
<table class="table table-sm table-bordered mymargin5">
  <thead>
    <tr class="mycolor2">
      <th scope="col" width="50%">상품명</th>
      <th scope="col" width="15%">총 판매횟수</th>
      <th scope="col" width="15%">총 판매수량</th>
      <th scope="col" width="20%">총 판매금액</th>
    </tr>
  </thead>
  <tbody>
<?php
	while ($product = $products->unbuffered_row())
	{
		$product_no = $product->product_no;
        $strUri = "/product_no/{$product_no}" . $strUri2;
  ?>
    <tr>
      <td align="left"><?= $product->product_name ?></td>
      <td align="right"><?= number_format($product->sales_count)?></td>
      <td align="right"><?= number_format($product->total_sale_count)?></td>
      <td align="right"><?= number_format($product->total_sale_price)?></td>
    </tr>
<?php
	}
?>
  </tbody>
</table>
<?=$pagination?>

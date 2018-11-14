<div class="alert mycolor1" role="alert">
  <?=$page_title?>
</div>

<script>
<!--
	function find_ledger() {
        var elmUserName = start_date;
        var strURL = "/ledger/donut";
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
        if (Number(form_ledger.product_no.value) > 0)
            strURL += "/product_no/" + Number(form_ledger.product_no.value);
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

    function find_product() {
        window.open("/product/find/", "find_product", "resizable=yes,scrollbars=yes,width=500,height=600");
    };
</script>
<form name="form_ledger" action="" method="GET">
<div class="row">
	<div class="col-6" align="left">
		<div class="input-group input-group-sm mb-3 w-150">
			<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">기간: </span></div>
			<input type="text" class="form-control" id="start_date" name="start_date" maxlength="10" autocomplete="off" placeholder="   시작 날짜   " aria-label="   시작 날짜   " aria-describedby="basic-addon1"
				onKeydown="if (event.keyCode ===13) { find_ledger(); }" <?php if (isset($start_date)) echo "value=\"{$start_date}\""; ?>>
			~ <input type="text" class="form-control" id="end_date" name="end_date" maxlength="10" autocomplete="off" placeholder="   종료 날짜   " aria-label="   종료 날짜   " aria-describedby="basic-addon1"
				onKeydown="if (event.keyCode ===13) { find_ledger(); }" <?php if (isset($end_date)) echo "value=\"{$end_date}\""; ?>>
			&nbsp;
			<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">제품명: </span></div>
			&nbsp;&nbsp;<button class="btn btn-sm btn-outline-secondary" type="button" id="button-addon2" onClick="find_ledger();" >조회</button>
		</div>
	</div>
	<div class="col-6" align="right">
	</div>
</div>
</form>

<!-- Load D3 -->
<script src="https://d3js.org/d3.v5.min.js"></script>

<!-- Load billboard.js with base(or theme) style -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/billboard.js/1.6.2/billboard.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/billboard.js/1.6.2/billboard.js"></script>
<div class="row">
	<div class="col-4" align="center">판매 횟수</div>
	<div class="col-4" align="center">판매 수량</div>
	<div class="col-4" align="center">판매 금액 (천원)</div>
</div>
<div class="row">
	<div class="col-4" align="center"><div id="PieChart_total_sale_number"></div></div>
	<div class="col-4" align="center"><div id="PieChart_total_sale_count"></div></div>
	<div class="col-4" align="center"><div id="PieChart_total_sale_price"></div></div>
</div>
<script>
<?php
	$product_count = 0;
	$columns_total_sale_number = "";
	$columns_total_sale_count = "";
	$columns_total_sale_price = "";
	while ( $ledgers && ( $ledger = $ledgers->unbuffered_row() ) )
	{
		if ($product_count > 0)
		{
			$columns_total_sale_number .= ",";
			$columns_total_sale_count  .= ",";
			$columns_total_sale_price  .= ",";
		}
		
		$product_name = $ledger->product_name;
		$columns_total_sale_number .= "[\"{$product_name}\", {$ledger->total_sale_number}]";
		$columns_total_sale_count  .= "[\"{$product_name}\", {$ledger->total_sale_count}]";
		$columns_total_sale_price  .= "[\"{$product_name}\", {$ledger->total_sale_price}]";
		$product_count ++;
	}
?>
<!--
	var chart_total_sale_number = bb.generate( {
		data: {
			columns: [<?=$columns_total_sale_number?>]
			, type: "pie",
		}
		, pie: {
			label: {
				format: function(value, ratio, id) {
					return (value + '번');
				}
			}
		}
  		, bindto: "#PieChart_total_sale_number"
	} );
	var chart_total_sale_count = bb.generate( {
		data: {
			columns: [<?=$columns_total_sale_count?>]
			, type: "pie",
		}
		, pie: {
			label: {
				format: function(value, ratio, id) {
					return (value + '개');
				}
			}
		}
		, bindto: "#PieChart_total_sale_count"
	} );
	var chart_total_sale_price = bb.generate( {
		data: {
			columns: [<?=$columns_total_sale_price?>]
			, type: "pie",
		}
		, pie: {
			label: {
				format: function(value, ratio, id) {
					return (Math.floor(value / 1000));
				}
			}
		}
		, bindto: "#PieChart_total_sale_price"
	} );
//-->
</script>

<div class="alert mycolor1" role="alert">
  판매관리
</div>

<script>
<!--
	function find_ledger() {
    var elmUserName = date;
    if (elmUserName.value.trim() == "")
    {
      alert("이름을 입력하여 주십시요.");
      elmUserName.focus();
      return;
    }
		window.location.href = "/ledger/list/date/" + elmUserName.value.trim();
	}
// -->
</script>
<?php
    $strUri2 = "";
    if ( isset($class) && (($class > 0) && ($class <= 2)) )
    {
      $strUri2 .= "/class/{$class}";
      $class_name =  ($class == 1) ? "매입" : "매출";
      $class_form_name =  ($class == 1) ? "buy" : "sale";
      $class_color = ($class != 1) ? "red"  : "blue";
    }
    if (isset($date))
      $strUri2 .= "/date/{$date}";
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
        $("#date").datepicker();
    });
</script>
<form name="form_find_ledger" action="" method="GET"></form>
<div class="row">
	<div class="col-3" align="left">
		<div class="input-group input-group-sm mb-3 w-150">
		  <div class="input-group-prepend">
			<span class="input-group-text" id="basic-addon1">장부날짜: </span>
		  </div>
		  <input type="text" class="form-control" id="date" name="date" placeholder="장부 날짜" aria-label="장부 날짜" aria-describedby="basic-addon1"
			onKeydown="if (event.keyCode ===13) { find_ledger(); }" <?php if (isset($date)) echo "value=\"{$date}\""; ?>>
		  <div class="input-group-append">
			<button class="btn btn-sm btn-outline-secondary" type="button" id="button-addon2" onClick="find_ledger();" >검색</button>
		  </div>
		</div>
	</div>
	<div class="col-9" align="right">
<?php
    if ( isset($class) && (($class > 0) && ($class <= 2)) )
    {
?>
		<a href="/ledger/add<?=$strUri2?>" class="btn btn-sm btn-outline-secondary"><?=$class_name?>추가</a>
<?php
    }
    else
    {
?>
        <a href="/ledger/add/class/1<?=$strUri2?>" class="btn btn-sm btn-outline-secondary">매입추가</a>
		<a href="/ledger/add/class/2<?=$strUri2?>" class="btn btn-sm btn-outline-secondary">매출추가</a>
<?php
    }
?>
	</div>
</div>
<table class="table table-sm table-bordered mymargin5">
  <thead>
    <tr class="mycolor2">
      <th scope="col">번호</th>
      <th scope="col">구분</th>
      <th scope="col">날짜</th>
      <th scope="col">상품명</th>
      <th scope="col">단가</th>
      <th scope="col">매입수량</th>
      <th scope="col">매입금액</th>
      <th scope="col">매출수량</th>
      <th scope="col">매출금액</th>
      <th scope="col">비고</th>
    </tr>
  </thead>
  <tbody>
<?php
	while ($ledger = $ledgers->unbuffered_row())
	{
		$ledger_no = $ledger->ledger_no;
        $strUri = "/ledger_no/{$ledger_no}" . $strUri2;
        $class_color = ($ledger->class != 1) ? "red" : "blue";
  ?>
    <tr>
      <th scope="row"><a href="/ledger/view<?=$strUri?>"><?php echo $ledger_no; ?></a></th>
      <td><?= ($ledger->class == 1) ? "매입" : "매출"; ?></td>
      <td><?= $ledger->ledger_date ?></td>
      <td><?= $ledger->product_name ?></td>
      <td><?= number_format($ledger->per_price) ?></td>
      <td><font color="<?=$class_color?>"><?= ($ledger->class == 1) ? number_format($ledger->buy_count) :  ""?></font></td>
      <td><font color="<?=$class_color?>"><?= ($ledger->class == 1) ? number_format($ledger->buy_price) :  ""?></font></td>
      <td><font color="<?=$class_color?>"><?= ($ledger->class != 1) ? number_format($ledger->sale_count) : ""?></font></td>
      <td><font color="<?=$class_color?>"><?= ($ledger->class != 1) ? number_format($ledger->sale_price) : ""?></font></td>
      <td><?= $ledger->note ?></td>
    </tr>
<?php
	}
?>
  </tbody>
</table>
<?=$pagination?>

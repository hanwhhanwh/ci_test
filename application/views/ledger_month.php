<div class="alert mycolor1" role="alert">
	<?=$page_title?>
</div>

<script>
<!--
	function find_ledger() {
		var elmUserName = year;
		if (elmUserName.value.trim() == "")
		{
			alert("이름을 입력하여 주십시요.");
			elmUserName.focus();
			return;
    	}
		window.location.href = "/ledger/month/year/" + elmUserName.value.trim();
	}
// -->
</script>
<?php
    $strUri2 = "";
    if (isset($year))
      $strUri2 .= "/year/{$year}";
    if (isset($page))
      $strUri2 .= "/page/{$page}";
?>
<form name="form_find_ledger" action="" method="GET"></form>
<div class="row">
	<div class="col-3" align="left">
		<div class="input-group input-group-sm mb-3 w-150">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1">매출 년도: </span>
			</div>
			<select class="form-control" id="year" name="year" onChange="find_ledger();"><?php
				$year_value = (int)date("Y");
				if ( !( isset($year) && ($year > 1950) ) )
					$year = $year_value;
				$year = (int)$year;
				for ($year_index = 0 ; $year_index < 12 ; $year_index ++)
				{
					echo "<option value=\"{$year_value}\" ";
					if ($year_value === $year) echo "selected";
					echo ">{$year_value} 년도</option>";
					$year_value --;
				}
				?></select>
			<div class="input-group-append">
				<button class="btn btn-sm btn-outline-secondary" type="button" id="button-addon2" onClick="find_ledger();" >조회</button>
			</div>
		</div>
	</div>
</div>
<table class="table table-sm table-bordered mymargin5">
<thead>
	<tr class="mycolor2">
		<th scope="col">상품명</th>
		<th scope="col">1월</th>
		<th scope="col">2월</th>
		<th scope="col">3월</th>
		<th scope="col">4월</th>
		<th scope="col">5월</th>
		<th scope="col">6월</th>
		<th scope="col">7월</th>
		<th scope="col">8월</th>
		<th scope="col">9월</th>
		<th scope="col">10월</th>
		<th scope="col">11월</th>
		<th scope="col">12월</th>
		<th scope="col">합계</th>
	</tr>
</thead>
<tbody>
<?php
	while ( isset($ledgers) && ($ledger = $ledgers->unbuffered_row('array')) ) 
	{
		$product_name = $ledger["product_name"];
  ?>
    <tr>
      <th scope="row" class="align-middle"><?=$product_name?></th><?php
		for ($month = 1 ; $month <= 12 ; $month ++)
		{
			echo "<td align=\"right\">";
			$monthly_total_sale_price = $ledger["m{$month}_total_sale_price"];
			if ( $monthly_total_sale_price > 0 )
			{
				echo number_format($monthly_total_sale_price) . "<br />";
				echo $ledger["m{$month}_sale_number"] . " / " . $ledger["m{$month}_total_sale_count"];
			}
			else
				echo "&nbsp;";
			echo "</td>";
		}
		echo "<td align=\"right\">";
		$total_sale_price = $ledger["total_sale_price"];
		if ( $total_sale_price > 0 )
		{
			echo number_format($total_sale_price) . "<br />";
			echo $ledger["total_sale_number"] . " / " . $ledger["total_sale_count"];
		}
		else
			echo "&nbsp;";
	echo "</td>";
		?>
    </tr>
<?php
	}
?>
</tbody>
</table>
<?=$pagination?>

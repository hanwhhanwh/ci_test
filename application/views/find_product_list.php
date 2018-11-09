<div class="alert mycolor1" role="alert">
  상품 찾기
</div>

<script>
<!--
	function find_product() {
        var elmUserName = product_name;
        if (elmUserName.value.trim() == "")
        {
        alert("이름을 입력하여 주십시요.");
        elmUserName.focus();
        return;
        }
		
        window.location.href = "/product/find/name/" + elmUserName.value.trim();
	}

    function select_product(nProductNo, strProductName, nPerPrice) {
        if ( (opener != null) && (opener.form_ledger != null) ) {
            opener.form_ledger.product_no.value = nProductNo;
            opener.form_ledger.product_name.value = strProductName;
            if (opener.form_ledger.per_price != null)
            {
              opener.form_ledger.per_price.value = nPerPrice;
              opener.compute_price();
            }
            self.close();
        }
    }
// -->
</script>
<?php
    $strUri2 = "";
    if (isset($name))
      $strUri2 .= "/name/{$name}";
    if (isset($page))
      $strUri2 .= "/page/{$page}";
?>
<form name="form_find_product" action="" method="GET"></form>
<div class="row">
	<div class="col-6" align="left">
		<div class="input-group input-group-sm mb-3 w-150">
		  <div class="input-group-prepend">
			<span class="input-group-text" id="basic-addon1">이름: </span>
		  </div>
		  <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product name" aria-label="Product name" aria-describedby="basic-addon1"
			onKeydown="if (event.keyCode ===13) { find_product(); }" <?php if (isset($name)) echo "value=\"{$name}\""; ?>>
		  <div class="input-group-append">
			<button class="btn btn-sm btn-outline-secondary" type="button" id="button-addon2" onClick="find_product();" >검색</button>
		  </div>
		</div>
	</div>
</div>
<table class="table table-sm table-bordered table-hover mymargin5">
  <thead>
    <tr class="mycolor2">
      <th scope="col">번호</th>
      <th scope="col">상품종류</th>
      <th scope="col">상품명</th>
      <th scope="col">단가</th>
      <th scope="col">재고수량</th>
    </tr>
  </thead>
  <tbody>
<?php
	while ($product = $products->unbuffered_row())
	{
		$product_no = $product->product_no;
    $strUri = "/product_no/{$product_no}" . $strUri2;
  ?>
    <tr style="cursor:pointer;" onClick="select_product(<?=$product_no?>, '<?=$product->product_name?>', <?=$product->per_price?>);">
      <th scope="row"><?php echo $product_no; ?></th>
      <td><?= $product->group_name ?></td>
      <td><img width="100" src="/images/products/<?=$product->product_image_path?>" class="rounded" alt="<?= $product->product_name ?>"> <?= $product->product_name ?></td>
      <td><?= $product->per_price ?></td>
      <td><?= $product->stock_count ?></td>
    </tr>
<?php
	}
?>
  </tbody>
</table>
<?=$pagination?>

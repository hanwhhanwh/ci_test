<?php
  $strAction = "/product/update";
  if (isset($product_no))
    $strAction .= "/product_no/{$product_no}";
  if (isset($name))
    $strAction .= "/name/{$name}";
  if (isset($page))
    $strAction .= "/page/{$page}";
?>
<form id="form_add_group" method="POST" action="<?=$strAction?>">
<div class="alert mycolor1 form-inline" role="alert">상품 수정</div>
<table class="table table-sm table-bordered mymargin5">
  <tbody>
<?php
	if (isset($product))
	{
?>
    <tr>
      <th scope="row" width="40%" style="vertical-align:middle" class="mycolor2">번호</th><td align="left"><?=$product->group_no?></td>
    </tr>
<?php
	}
?>
    <tr>
        <th scope="row" width="20%" style="vertical-align:middle" class="mycolor2">
		    <font color="red">*</font> 상품종류
        </th>
        <td align="left"><div class="form-inline"><select class="form-control form-control-sm" name="group_no"><option value="">&lt;&lt; 선택하세요. &gt;&gt;</option><?php
            while ($group = $all_groups->unbuffered_row())
            {
            echo "<option value=\"{$group->group_no}\"";
            if ($product->group_no == $group->group_no)
              echo " selected";
            echo ">{$group->group_name}</option>";
            } ?></select></div>
        </td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2">
  		    <font color="red">*</font> 상품명</th>
        <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="product_name" size="20" maxlength="30" <?php 
            if (isset($product)) echo "value=\"{$product->product_name}\""; ?></div><?php
            if (form_error("product_name") == true) echo form_error("product_name"); ?>
        </td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2">
		    <font color="red">*</font> 단가
        </th>
        <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="per_price" size="20" maxlength="30" <?php
            if (isset($product)) echo "value=\"{$product->per_price}\""; ?>></div><?php 
            if (form_error("per_price") == true) echo form_error("per_price"); ?>
        </td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2">재고수량</th>
        <td align="left"><div class="form-inline"><input type="text" class="form-control form-control-sm" name="stock_count" size="20" maxlength="30" <?php 
            if (isset($product)) echo "value=\"{$product->stock_count}\""; ?></div>
        </td>
    </tr>
    <tr>
      <th colspan="2" scope="row" width="20%" style="vertical-align:middle" class="mycolor2">현재 상품이미지</th>
    </tr>
    <tr>
	    <td colspan="2" align="left"><div align=center><img width="200" src="/images/products/<?=$product->product_image_path?>" class="img-fluid img-thumbnail rounded" alt="<?= $product->product_name ?>"></div></td>
    </tr>
    <tr>
        <th scope="row" style="vertical-align:middle" class="mycolor2">변경 상품이미지</th>
        <td align="left"><div class="form-inline"><input type="file" class="form-control form-control-sm" name="product_image" size="20" maxlength="30" <?php 
            if (isset($product)) echo "value=\"{$product->product_image_path}\""; ?></div>
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
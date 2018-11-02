<?php
  $strUri = "";
  if (isset($product_no))
    $strUri .= "/product_no/{$product_no}";
  if (isset($name))
    $strUri .= "/name/{$name}";
  if (isset($page))
    $strUri .= "/page/{$page}";
?>
<div class="alert mycolor1" role="alert">상품 정보</div>
<table class="table table-sm table-bordered mymargin5">
  <tbody>
    <tr>
      <th scope="row" width="40%" style="vertical-align:middle" class="mycolor2">번호</th><td align="left"><?=$product->product_no?></td>
    </tr>
    <tr>
      <th scope="row" width="20%" style="vertical-align:middle" class="mycolor2">
		<font color="red">*</font> 상품종류</th>
	  <td align="left"><?=$product->group_no?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">
		<font color="red">*</font> 상품명</th>
	  <td align="left"><?=$product->product_name?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">
		<font color="red">*</font> 단가</th>
	  <td align="left"><?=$product->per_price?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">재고수량</th>
	  <td align="left"><?=$product->stock_count?></td>
    </tr>
    <tr>
      <th scope="row" width="20%" style="vertical-align:middle" class="mycolor2">상품이미지</th>
	  <td align="left"><?=$product->product_image_path?></td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align:middle" class="mycolor2">최종 수정시각</th>
	  <td align="left"><?=$product->mod_date?></td>
    </tr>
  </tbody>
</table>
<div align="center">
<a class="btn btn-sm btn-outline-secondary" href="/product/edit<?=$strUri?>">수정</a>
<a class="btn btn-sm btn-outline-secondary" href="/product/delete<?=$strUri?>"
		onClick="return confirm('삭제할까요?');">삭제</a>&nbsp;&nbsp;&nbsp;
<button class="btn btn-sm btn-outline-secondary" type="button" id="button-back"
		onClick="history.back();">이전화면으로</button>
</div>

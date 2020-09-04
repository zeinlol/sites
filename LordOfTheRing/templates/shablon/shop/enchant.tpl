<tr class="shop-producst-enchant-table-string">
    <td>
	    <div class="shop-products-enchant-table-amount-name">{name}</div>
    </td>
    <td class="shop-products-enchant-table-amount-range-collumn">
	    <input class="shop-products-enchant-table-amount-range" type="range" name="{eid}" min="0" max="{max_lvl}" step="1" id="{eid}" oninput="getvalue({eid});" value="0">
 	    <input type="hidden" id="price{eid}" value="{price}">
    </td>
    <td>
 	    <input class="shop-products-enchant-table-amount" type="number" id="value{eid}" value="0" style="border: 0px;" readonly> ур.  (<input class="shop-products-enchant-table-amount" type="number" id="pricevalue{eid}" value="0" readonly> руб.)
    </td>
</tr>


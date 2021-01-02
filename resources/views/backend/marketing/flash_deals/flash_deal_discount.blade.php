@if(count($product_ids) > 0)
<label class="col-sm-3 col-from-label">{{translate('Discounts')}}</label>
<div class="col-sm-9">
  <table class="table table-bordered">
    <thead>
    	<tr>
    		<td width="50%">
            <span>{{translate('Product')}}</span>
    		</td>
        <td width="20%">
            <span>{{translate('Base Price')}}</span>
    		</td>
    		<td width="20%">
            <span>{{translate('Discount')}}</span>
    		</td>
        <td width="10%">
            <span>{{translate('Discount Type')}}</span>
        </td>
    	</tr>
    </thead>
    <tbody>
        @foreach ($product_ids as $key => $id)
        	@php
        		$product = \App\Product::findOrFail($id);
        	@endphp
            <tr>
              <td>
                <div class="from-group row">
                  <div class="col-auto">
                    <img class="size-60px img-fit" src="{{ uploaded_asset($product->thumbnail_img)}}">
                  </div>
                  <div class="col">
                    <span>{{  $product->getTranslation('name')  }}</span>
                  </div>
                </div>
              </td>
              <td>
                  <span>{{ $product->unit_price }}</span>
              </td>
              <td>
                  <input type="number" name="discount_{{ $id }}" value="{{ $product->discount }}" min="0" step="1" class="form-control" required>
              </td>
              <td>
                  <select class="form-control aiz-selectpicker" name="discount_type_{{ $id }}">
                    <option value="amount">{{ translate('Flat') }}</option>
                    <option value="percent">{{ translate('Percent') }}</option>
                  </select>
              </td>
            </tr>
        @endforeach
    </tbody>
  </table>
</div>
@endif

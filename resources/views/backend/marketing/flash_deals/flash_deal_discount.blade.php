@if(count($product_ids) > 0)
<label class="col-sm-3 col-from-label">{{translate('Discounts')}}</label>
<div class="col-sm-9">
  <table class="table table-bordered">
    <thead>
    	<tr>
    		<td class="text-center" width="40%">
            <label class="control-label">{{translate('Product')}}</label>
    		</td>
        <td class="text-center">
            <label class="control-label">{{translate('Base Price')}}</label>
    		</td>
    		<td class="text-center">
            <label class="control-label">{{translate('Discount')}}</label>
    		</td>
        <td class="text-center" width="15%">
            <label class="control-label">{{translate('Discount Type')}}</label>
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
                  <div class="col-sm-5">
                    <img class="w-100px" src="{{ uploaded_asset($product->thumbnail_img)}}" alt="Image">
                  </div>
                  <div class="col-sm-7">
                    <label for="" class="col-from-label">{{  $product->getTranslation('name')  }}</label>
                  </div>
                </div>
              </td>
              <td>
                  <label for="" class="control-label">{{ $product->unit_price }}</label>
              </td>
              <td>
                  <input type="number" name="discount_{{ $id }}" value="{{ $product->discount }}" min="0" step="1" class="form-control" required>
              </td>
              <td>
                  <select class="form-control aiz-selectpicker" name="discount_type_{{ $id }}">
                    <option value="amount">$</option>
                    <option value="percent">%</option>
                  </select>
              </td>
            </tr>
        @endforeach
    </tbody>
  </table>
</div>
@endif

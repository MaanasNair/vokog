@if(count($product_ids) > 0)
<label class="col-sm-3 control-label">{{translate('Discounts')}}</label>
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
              $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id', $flash_deal_id)->where('product_id', $product->id)->first();
            @endphp
            <tr>
                <td>
                  <div class="form-group row">
                      <div class="col-auto">
                          <img src="{{ uploaded_asset($product->thumbnail_img)}}" class="size-60px img-fit" >
                      </div>
                      <div class="col">
                          <span>{{  $product->getTranslation('name')  }}</span>
                      </div>
                  </div>
                </td>
                <td>
                    <span>{{ $product->unit_price }}</span>
                </td>
                @if ($flash_deal_product != null)
                <td>
                    <input type="number" name="discount_{{ $id }}" value="{{ $flash_deal_product->discount }}" min="0" step="1" class="form-control" required>
                </td>
                <td>
                    <select class="aiz-selectpicker" name="discount_type_{{ $id }}">
                        <option value="amount" <?php if($flash_deal_product->discount_type == 'amount') echo "selected";?> >{{ translate('Flat') }}</option>
                        <option value="percent" <?php if($flash_deal_product->discount_type == 'percent') echo "selected";?> >{{ translate('Percent') }}</option>
                    </select>
                </td>
                @else
                <td>
                    <input type="number" name="discount_{{ $id }}" value="{{ $product->discount }}" min="0" step="1" class="form-control" required>
                </td>
                <td>
                    <select class="aiz-selectpicker" name="discount_type_{{ $id }}">
                        <option value="amount" <?php if($product->discount_type == 'amount') echo "selected";?> >{{ translate('Flat') }}</option>
                        <option value="percent" <?php if($product->discount_type == 'percent') echo "selected";?> >{{ translate('Percent') }}</option>
                    </select>
                </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
</div>
@endif

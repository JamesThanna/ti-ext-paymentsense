
<div
    id="paymentsensePaymentForm"
    class="payment-form w-100"
>
    @foreach ($paymentMethod->getHiddenFields() as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}"/>
    @endforeach

    <div id="paymentsense-card-errors"></div>

    <div id="paymentsense-payment"></div>

    <div id="paymentsense-address">

        <div class="form-group mt-2">
          <h6>@lang('miorder.paymentsense::default.label_billing_address')</h6>
          <input type="text" name="address1" required class="form-control" placeholder="@lang('miorder.paymentsense::default.placeholder_address_1')" />
        </div>

        <div class="form-group">
          <input type="text" name="address2" required class="form-control" placeholder="@lang('miorder.paymentsense::default.placeholder_address_2')" />
        </div>

        <div class="form-group">
          <input type="text" name="address3" class="form-control" placeholder="@lang('miorder.paymentsense::default.placeholder_address_3')" />
        </div>

        <div class="form-group">
          <input type="text" name="county" required class="form-control" placeholder="@lang('miorder.paymentsense::default.placeholder_county')" />
        </div>

        <div class="form-group">
          <input type="text" name="city" required class="form-control" placeholder="@lang('miorder.paymentsense::default.placeholder_city')" />
        </div>

        <div class="form-group">
          <input type="text" name="postcode" required class="form-control" placeholder="@lang('miorder.paymentsense::default.placeholder_postcode')" />
        </div>
    </div>

</div>

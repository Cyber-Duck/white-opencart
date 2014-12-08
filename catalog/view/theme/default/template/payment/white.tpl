<form class="form-horizontal">
  <fieldset id="payment">
    <legend><?php echo $text_credit_card; ?></legend>
    <div id="card">
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-cc-number"><?php echo $entry_cc_number; ?></label>
        <div class="col-sm-10">
          <input type="text" name="cc_number" value="" placeholder="<?php echo $entry_cc_number; ?>" id="input-cc-number" class="form-control" />
        </div>
      </div>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-cc-expire-month"><?php echo $entry_cc_expire_date; ?></label>
        <div class="col-sm-3">
          <select name="cc_expire_date_month" id="input-cc-expire-month" class="form-control">
            <?php foreach ($months as $month) { ?>
            <option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-sm-3">
          <select name="cc_expire_date_year" id="input-cc-expire-year" class="form-control">
            <?php foreach ($year_expire as $year) { ?>
            <option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-cc-cvv2"><?php echo $entry_cc_cvv2; ?></label>
        <div class="col-sm-10">
          <input type="text" name="cc_cvv2" value="" placeholder="<?php echo $entry_cc_cvv2; ?>" id="input-cc-cvv2" class="form-control" />
        </div>
      </div>
    </div>
  </fieldset>
</form>
<div class="buttons">
  <div class="pull-right">
    <input type="hidden" name="amount" id="input-amount" value="<?php echo $amount; ?>" />
    <input type="hidden" name="currency" id="input-currency" value="<?php echo $currency; ?>" />
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" />
  </div>
</div>
<script src="https://fast.whitepayments.com/static/white.min.js"></script>
<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {

        $('#white_message_error').remove();

        var data = $('#card :input[type=\'text\']:enabled, #card select:enabled');

        White.createToken({

            key: '<?php echo $white_public_api; ?>',
            card: {
                number: $('#input-cc-number').val(),
                exp_month: $('#input-cc-expire-month').val(),
                exp_year: $('#input-cc-expire-year').val(),
                cvc: $('#input-cc-cvv2').val()
            },
            amount: $('#amount').val(),
            currency: $('#currency').val()

        }, function(status, response) {

            if(response.error) {
            $('#payment').before('<div id="white_message_error" class="alert alert-warning"><i class="fa fa-info-circle"></i> ' + response.error.message + '</div>');
            return false;

        }
            var data = {card: response.id, amount: $('#input-amount').val(), currency: $('#input-currency').val()};
            $.ajax({
                url: 'index.php?route=payment/white/send',
                type: 'post',
                data: data,
                dataType: 'json',
                cache: false,
                beforeSend: function() {
                    $('#button-confirm').button('loading');
                },
                complete: function() {
                    $('#button-confirm').button('reset');
                },
                success: function(json) {

                    if (json['error']) {
                        $('#payment').before('<div id="white_message_error" class="alert alert-warning"><i class="fa fa-info-circle"></i> ' + json['error'] + '</div>');
                    }

                    if (json['redirect']) {
                        location = json['redirect'];
                    }
                    
                }
            });
        });
    });
//--></script>
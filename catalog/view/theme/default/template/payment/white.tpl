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
        <label class="col-sm-2 control-label" for="input-cc-exp-month"><?php echo $entry_cc_expire_date; ?></label>
        <div class="col-sm-3">
          <select name="cc_expire_date_month" id="input-cc-exp-month" class="form-control">
            <?php foreach ($months as $month) { ?>
            <option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-sm-3">
          <select name="cc_expire_date_year" id="input-cc-exp-year" class="form-control">
            <?php foreach ($year_expire as $year) { ?>
            <option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-cc-cvc"><?php echo $entry_cc_cvc; ?></label>
        <div class="col-sm-10">
          <input type="text" name="cc_cvc" value="" placeholder="<?php echo $entry_cc_cvc; ?>" id="input-cc-cvc" class="form-control" />
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
<script src="https://fast.whitepayments.com/whitejs/white.js"></script>
<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {

        $('#white_message_error').remove();

        var data = $('#card :input[type=\'text\']:enabled, #card select:enabled');

        white = new White("<?php echo $white_public_api; ?>");

        white.createToken({

            number: $('#input-cc-number').val(),
            exp_month: $('#input-cc-exp-month').val(),
            exp_year: $('#input-cc-exp-year').val(),
            cvc: $('#input-cc-cvc').val(),

        }, function(status, response) {

            $('.alert, .text-danger').remove();
            $('.form-group div').removeClass('has-error');

            if(response.error) {

                for (var i in response.error.extras) {
                    var element = $('#input-cc-' + i.replace('_', '-'));
                    
                    if ($(element).parent().hasClass('input-group')) {
                        $(element).parent().after('<div class="text-danger">' + response.error.extras[i] + '</div>');
                    } else {
                        $(element).after('<div class="text-danger">' + response.error.extras[i] + '</div>');
                    }
                }

                $('.text-danger').parent().addClass('has-error');

                return false;

            }

            var data = {
                card: response.id, 
                amount: $('#input-amount').val(), 
                currency: $('#input-currency').val()
            };

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
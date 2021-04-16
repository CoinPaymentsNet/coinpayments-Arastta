<?php echo $header; ?>

<?php echo $column_left; ?>

<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" onclick="save('save')" form="form-coinpayments" data-toggle="tooltip" title="<?php echo $button_save; ?>"
                        class="btn btn-success" data-original-title="Save"><i class="fa fa-check"></i></button>
                <button type="submit" form="form-coinpayments" data-toggle="tooltip" title="<?php echo $button_saveclose; ?>" class="btn btn-default"
                        data-original-title="Save & Close"><i class="fa fa-save text-success"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
                   class="btn btn-default"><i class="fa fa-times-circle text-danger"></i></a>
            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-coinpayments"
                      class="form-horizontal">
                    <div class="form-group required">
                        <label class="col-sm-2 control-label"
                               for="entry-client-id"><span data-toggle="tooltip"
                                                           title="<?php echo $help_client_id; ?>"><?php echo $entry_client_id; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="coinpayments_client_id"
                                   value="<?php echo $coinpayments_client_id; ?>"
                                   placeholder="Your CoinPayments Client ID" id="entry-client-id"
                                   class="form-control"/>
                            <?php if ($error_client_id) { ?>
                            <div class="text-danger"><?php echo $error_client_id; ?></div>
                            <?php } ?>
                            <?php if ($error_invalid_credentials) { ?>
                            <div class="text-danger"><?php echo $error_invalid_credentials; ?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="input-webhooks">
                                    <span data-toggle="tooltip"
                                          title="<?php echo $help_webhooks; ?>"><?php echo $entry_webhooks; ?></label>
                        <div class="col-sm-10">
                            <select name="coinpayments_webhooks" id="input-webhooks" class="form-control">
                                <?php if ($coinpayments_webhooks) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group required" id="input-client-secret-wrap" <?php if ($coinpayments_webhooks != true){ ?>style="display: none;"<?php } ?>>
                        <label class="col-sm-2 control-label"
                               for="entry-client-secret"><span data-toggle="tooltip"
                                                               title="<?php echo $help_client_secret; ?>"><?php echo $entry_client_secret; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="coinpayments_client_secret"
                                   value="<?php echo $coinpayments_client_secret; ?>"
                                   placeholder="Your CoinPayments Client Secret" id="entry-client-secret"
                                   class="form-control"/>
                            <?php if ($error_client_secret) { ?>
                            <div class="text-danger"><?php echo $error_client_secret; ?></div>
                            <?php } ?>
                            <?php if ($error_invalid_credentials) { ?>
                            <div class="text-danger"><?php echo $error_invalid_credentials; ?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-total">
                            <span data-toggle="tooltip" title="<?php echo $help_total; ?>">
                                <?php echo $entry_total; ?>
                            </span>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" name="coinpayments_total" value="<?php echo $coinpayments_total; ?>"
                                   placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $entry_cancelled_status; ?></label>
                        <div class="col-sm-10">
                            <select name="coinpayments_cancelled_status" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $coinpayments_cancelled_status) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"
                                        selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $entry_completed_status; ?></label>
                        <div class="col-sm-10">
                            <select name="coinpayments_completed_status" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $coinpayments_completed_status) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"
                                        selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $entry_pending_status; ?></label>
                        <div class="col-sm-10">
                            <select name="coinpayments_pending_status" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $coinpayments_pending_status) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"
                                        selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                        <div class="col-sm-10">
                            <select name="coinpayments_geo_zone_id" id="input-geo-zone" class="form-control">
                                <option value="0"><?php echo $text_all_zones; ?></option>
                                <?php foreach ($geo_zones as $geo_zone) { ?>
                                <?php if ($geo_zone['geo_zone_id'] == $coinpayments_geo_zone_id) { ?>
                                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"
                                        selected="selected"><?php echo $geo_zone['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                        <div class="col-sm-10">
                            <select name="coinpayments_status" id="input-status" class="form-control">
                                <?php if ($coinpayments_status) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="coinpayments_sort_order"
                                   value="<?php echo $coinpayments_sort_order; ?>"
                                   placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order"
                                   class="form-control"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript"><!--
    function save(type) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'button';
        input.value = type;
        form = $("form[id^='form-']").append(input);
        form.submit();
    }

    let webHooksSelector = document.getElementById('input-webhooks');
    let clientSecretWrap = document.getElementById('input-client-secret-wrap');
    if (webHooksSelector && clientSecretWrap) {
        webHooksSelector.onchange = function (e, o) {
            if (parseInt(e.target.value)) {
                clientSecretWrap.style.display = 'block';
            } else {
                clientSecretWrap.style.display = 'none';
            }
        };
    }
    //--></script>

<?php echo $footer; ?> 
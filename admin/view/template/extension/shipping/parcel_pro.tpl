<?php
//==============================================================================
// Parcel Pro Shipping v1.0.1
//
// Company: Parcel Pro
// Contact: info@parcelpro.nl
//==============================================================================
?>
<?php echo $header; ?><?php echo $column_left; ?>
<?php
$options = array();
array_push($options,"3085");// PostNL, Standaard pakket
array_push($options,"3086");// PostNL, Pakket + rembours
array_push($options,"3087");// PostNL, Pakket + verzekerd bedrag
array_push($options,"3089");// PostNL, Pakket + handtekening voor ontvangst
array_push($options,"3091");// PostNL, Rembours + Verhoogd aansprakelijk
array_push($options,"3189");// PostNL, Pakket + handtekening voor ontvangst, ook bij buren
array_push($options,"3385");// PostNL, Alleen Huisadres
array_push($options,"4940");// PostNL, Pakket buitenland
array_push($options,"3533");//PostNL, Pakjegemak
array_push($options,"DFY");//DHL, DFY
array_push($options,"Europlus");//DHL, EUROPLUS
array_push($options,"Europack");//DHL, EUROPACK
array_push($options,"Parcelshop");//DHL, Parcelshop
array_push($options,"101");//DPD, Normaal pakket
array_push($options,"109");//DPD, Rembours
array_push($options,"136");//DPD, Klein pakket
array_push($options,"161");//DPD, Verzekerd, rembours
array_push($options,"179");//DPD, DPD 10:00
array_push($options,"191");//DPD, DPD 10:00, rembours
array_push($options,"225");//DPD, DPD 12:00
array_push($options,"228");//DPD, DPD 12:00, zaterdag
array_push($options,"237");//DPD, DPD 12:00, rembours
array_push($options,"350");//DPD, DPD 8:30
array_push($options,"352");//DPD, 8:30, rembours
array_push($options,"11");//UPS, standaard
array_push($options,"07");//UPS, Express
array_push($options,"54");//UPS, Express Plus
array_push($options,"65");//UPS, Express Saver
array_push($options,"dc");//Fadello
array_push($options,"2928");//PostNL (ex VSP), Brievenbuspakje
?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-weight" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-weight" class="form-horizontal">
                    <div class="row">
                        <div class="col-sm-2">
                            <ul class="nav nav-pills nav-stacked">
                                <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                                <?php for($i=0; $i < count($options); $i++){
                                echo "<li><a href='#tab-type-id-$options[$i]' data-toggle='tab'>${'tab_type_id_'.$options[$i]}</a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="col-sm-10">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-general">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-tax-class"><?php echo $entry_version; ?></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="weight_sort_order" value="<?php echo $text_version; ?>" disabled class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                                        <div class="col-sm-10">
                                            <select name="parcel_pro_status" id="input-status" class="form-control">
                                                <?php if ($parcel_pro_status) { ?>
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
                                        <label class="control-label col-sm-2" for="input-order-status"><?php echo $entry_auto_export_status; ?></label>
                                        <div class="col-sm-10">
                                            <select name="parcel_pro_auto_export_status" id="input-order-status" class="form-control">
                                                <option value="*"></option>
                                                <?php foreach ($order_statuses as $order_status) { ?>
                                                <?php if ($order_status['order_status_id'] == $parcel_pro_auto_export_status) { ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                                <?php } else { ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-shipping-heading"><?php echo $entry_shipping_heading; ?></label>
                                        <div class="col-sm-10">
                                            <?php foreach ($languages as $language) { ?>
                                              <div class="col-sm-1" style="padding:0; line-height:30px;"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png"></div>
                                              <div class="col-sm-11" style="padding:0;">

                                              <input type="text" name="parcel_pro_heading[<?php echo $language['code']; ?>]" value="<?php echo $parcel_pro_heading[$language['code']] ?>" placeholder="<?php echo $parcel_pro_heading[$language['code']] ?>" id="input-sort-order" class="form-control" />
                                              </div>

                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="parcel_pro_sort_order" value="<?php echo $parcel_pro_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <?php for($i=0; $i < count($options); $i++){ ?>
                                <div class="tab-pane" id="tab-type-id-<?php echo $options[$i]; ?>">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                                        <div class="col-sm-10">
                                            <select name="parcel_pro_type_id_<?php echo $options[$i]; ?>_status" id="input-status" class="form-control">
                                                <?php if (${'parcel_pro_type_id_'.$options[$i].'_status'}) { ?>
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
                                        <label class="col-sm-2 control-label" for="input-tax-class"><?php echo $entry_tax_class; ?></label>
                                        <div class="col-sm-10">
                                            <select name="parcel_pro_type_id_<?php echo $options[$i]; ?>_tax_class_id" id="input-tax-class" class="form-control">
                                                <option value="0"><?php echo $text_none; ?></option>
                                                <?php foreach ($tax_classes as $tax_class) { ?>
                                                <?php if ($tax_class['tax_class_id'] == ${'parcel_pro_type_id_'.$options[$i].'_tax_class_id'}) { ?>
                                                <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                                                <?php } else { ?>
                                                <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="parcel_pro_type_id_<?php echo $options[$i]; ?>_sort_order" value="<?php echo ${'parcel_pro_type_id_'.$options[$i].'_sort_order'}; ?>" size="1" class="form-control" />
                                        </div>
                                    </div>
                                    <table id="type-id-<?php echo $options[$i]; ?>" class="list table">
                                        <thead>
                                            <tr>
                                                <td class="center"><?php echo $column_general; ?></td>
                                                <td class="center"><?php echo $column_geo_zone; ?></td>
                                                <td class="center"><?php echo $column_cart_value; ?></td>
                                                <td class="center"><?php echo $column_pricing; ?></td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <?php  echo ${'rows_type_id_'.$options[$i]}; ?>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4"></td>
                                                <?php
                                                    if($options[$i] === 'DFY' || $options[$i] === 'Europlus' || $options[$i] === 'Parcelshop'){
                                                ?>
                                                <td class="left"><a onclick="addRule_2('parcel_pro_type_id_<?php echo $options[$i]; ?>_rule', 'type-id-<?php echo $options[$i]; ?>');" class="btn btn-primary"><?php echo $button_add_rule; ?></a></td>
                                                <?php
                                                    }else{
                                                ?>
                                                <td class="left"><a onclick="addRule_1('parcel_pro_type_id_<?php echo $options[$i]; ?>_rule', 'type-id-<?php echo $options[$i]; ?>');" class="btn btn-primary"><?php echo $button_add_rule; ?></a></td>
                                                <?php
                                                    }
                                                ?>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <?php } ?>

                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <?php echo $text_copyright; ?>
    </div>
</div>


<script type="text/javascript"><!--
    var count_type_id_3085_rule = <?php echo isset($count_type_id_3085) ? $count_type_id_3085 : '0'; ?>;
    var count_type_id_3086_rule = <?php echo isset($count_type_id_3086) ? $count_type_id_3086 : '0'; ?>;
    var count_type_id_3087_rule = <?php echo isset($count_type_id_3087) ? $count_type_id_3087 : '0'; ?>;
    var count_type_id_3089_rule = <?php echo isset($count_type_id_3089) ? $count_type_id_3089 : '0'; ?>;
    var count_type_id_3091_rule = <?php echo isset($count_type_id_3091) ? $count_type_id_3091 : '0'; ?>;
    var count_type_id_3189_rule = <?php echo isset($count_type_id_3189) ? $count_type_id_3189 : '0'; ?>;
    var count_type_id_3385_rule = <?php echo isset($count_type_id_3385) ? $count_type_id_3385 : '0'; ?>;
    var count_type_id_4940_rule = <?php echo isset($count_type_id_4940) ? $count_type_id_4940 : '0'; ?>;
    var count_type_id_3533_rule = <?php echo isset($count_type_id_3533) ? $count_type_id_3533 : '0'; ?>;
    var count_type_id_DFY_rule = <?php echo isset($count_type_id_DFY) ? $count_type_id_DFY : '0'; ?>;
    var count_type_id_Europack_rule = <?php echo isset($count_type_id_Europack) ? $count_type_id_Europack : '0'; ?>;
    var count_type_id_Europlus_rule = <?php echo isset($count_type_id_Europlus) ? $count_type_id_Europlus : '0'; ?>;
    var count_type_id_Parcelshop_rule = <?php echo isset($count_type_id_Parcelshop) ? $count_type_id_Parcelshop : '0'; ?>;
    var count_type_id_101_rule = <?php echo isset($count_type_id_101) ? $count_type_id_101 : '0'; ?>;
    var count_type_id_109_rule = <?php echo isset($count_type_id_109) ? $count_type_id_109 : '0'; ?>;
    var count_type_id_136_rule = <?php echo isset($count_type_id_136) ? $count_type_id_136 : '0'; ?>;
    var count_type_id_161_rule = <?php echo isset($count_type_id_161) ? $count_type_id_161 : '0'; ?>;
    var count_type_id_179_rule = <?php echo isset($count_type_id_179) ? $count_type_id_179 : '0'; ?>;
    var count_type_id_191_rule = <?php echo isset($count_type_id_191) ? $count_type_id_191 : '0'; ?>;
    var count_type_id_225_rule = <?php echo isset($count_type_id_225) ? $count_type_id_225 : '0'; ?>;
    var count_type_id_228_rule = <?php echo isset($count_type_id_228) ? $count_type_id_228 : '0'; ?>;
    var count_type_id_237_rule = <?php echo isset($count_type_id_237) ? $count_type_id_237 : '0'; ?>;
    var count_type_id_350_rule = <?php echo isset($count_type_id_350) ? $count_type_id_350 : '0'; ?>;
    var count_type_id_352_rule = <?php echo isset($count_type_id_352) ? $count_type_id_352 : '0'; ?>;
    var count_type_id_11_rule = <?php echo isset($count_type_id_11) ? $count_type_id_11 : '0'; ?>;
    var count_type_id_07_rule = <?php echo isset($count_type_id_07) ? $count_type_id_07 : '0'; ?>;
    var count_type_id_54_rule = <?php echo isset($count_type_id_54) ? $count_type_id_54 : '0'; ?>;
    var count_type_id_65_rule = <?php echo isset($count_type_id_65) ? $count_type_id_65 : '0'; ?>;
    var count_type_id_dc_rule = <?php echo isset($count_type_id_dc) ? $count_type_id_dc : '0'; ?>;
    var count_type_id_2928_rule = <?php echo isset($count_type_id_2928) ? $count_type_id_2928 : '0'; ?>;


function addRule_1(type_id, table_id) {
    switch (type_id)
    {
        case "parcel_pro_type_id_3085_rule":
            rulercounter = count_type_id_3085_rule;
            count_type_id_3085_rule++;
            break;
        case "parcel_pro_type_id_3086_rule":
            rulercounter = count_type_id_3086_rule;
            count_type_id_3086_rule++;
            break;
        case "parcel_pro_type_id_3087_rule":
            rulercounter = count_type_id_3087_rule;
            count_type_id_3087_rule++;
            break;
        case "parcel_pro_type_id_3089_rule":
            rulercounter = count_type_id_3089_rule;
            count_type_id_3089_rule++;
            break;
        case "parcel_pro_type_id_3091_rule":
            rulercounter = count_type_id_3091_rule;
            count_type_id_3091_rule++;
            break;
        case "parcel_pro_type_id_3189_rule":
            rulercounter = count_type_id_3189_rule;
            count_type_id_3189_rule++;
            break;
        case "parcel_pro_type_id_3385_rule":
            rulercounter = count_type_id_3385_rule;
            count_type_id_3385_rule++;
            break;
        case "parcel_pro_type_id_4940_rule":
            rulercounter = count_type_id_4940_rule;
            count_type_id_4940_rule++;
            break;
        case "parcel_pro_type_id_3533_rule":
            rulercounter = count_type_id_3533_rule;
            count_type_id_3533_rule++;
            break;
        case "parcel_pro_type_id_101_rule":
            rulercounter = count_type_id_101_rule;
            count_type_id_101_rule++;
            break;
        case "parcel_pro_type_id_109_rule":
            rulercounter = count_type_id_109_rule;
            count_type_id_109_rule++;
            break;
        case "parcel_pro_type_id_136_rule":
            rulercounter = count_type_id_136_rule;
            count_type_id_136_rule++;
            break;
        case "parcel_pro_type_id_161_rule":
            rulercounter = count_type_id_161_rule;
            count_type_id_161_rule++;
            break;
        case "parcel_pro_type_id_179_rule":
            rulercounter = count_type_id_179_rule;
            count_type_id_179_rule++;
            break;
        case "parcel_pro_type_id_191_rule":
            rulercounter = count_type_id_191_rule;
            count_type_id_191_rule++;
            break;
        case "parcel_pro_type_id_225_rule":
            rulercounter = count_type_id_225_rule;
            count_type_id_225_rule++;
            break;
        case "parcel_pro_type_id_228_rule":
            rulercounter = count_type_id_228_rule;
            count_type_id_228_rule++;
            break;
        case "parcel_pro_type_id_237_rule":
            rulercounter = count_type_id_237_rule;
            count_type_id_237_rule++;
            break;
        case "parcel_pro_type_id_350_rule":
            rulercounter = count_type_id_350_rule;
            count_type_id_350_rule++;
            break;
        case "parcel_pro_type_id_352_rule":
            rulercounter = count_type_id_352_rule;
            count_type_id_352_rule++;
            break;
        case "parcel_pro_type_id_Europack_rule":
            rulercounter = count_type_id_Europack_rule;
            count_type_id_Europack_rule++;
            break;
        case "parcel_pro_type_id_Europlus_rule":
            rulercounter = count_type_id_Europlus_rule;
            count_type_id_Europlus_rule++;
            break;
        case "parcel_pro_type_id_Parcelshop_rule":
            rulercounter = count_type_id_Europlus_rule;
            count_type_id_Europlus_rule++;
            break;
        case "parcel_pro_type_id_11_rule":
            rulercounter = count_type_id_11_rule;
            count_type_id_11_rule++;
            break;
        case "parcel_pro_type_id_07_rule":
            rulercounter = count_type_id_07_rule;
            count_type_id_07_rule++;
            break;
        case "parcel_pro_type_id_54_rule":
            rulercounter = count_type_id_54_rule;
            count_type_id_54_rule++;
            break;
        case "parcel_pro_type_id_65_rule":
            rulercounter = count_type_id_65_rule;
            count_type_id_65_rule++;
            break;
        case "parcel_pro_type_id_dc_rule":
            rulercounter = count_type_id_dc_rule;
            count_type_id_dc_rule++;
            break;
        case "parcel_pro_type_id_2928_rule":
            rulercounter = count_type_id_2928_rule;
            count_type_id_2928_rule++;
            break;
    }

    html  = '<tbody id="'+ type_id + rulercounter +'">';
	html += '  <tr>';
    html += '    <td class="text-center">';
	html += '      <div><strong><?php echo $text_name; ?></strong></div>';
                   <?php foreach ($languages as $language) { ?>
	html += '      <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <input type="text" name="'+ type_id +'['+ rulercounter +'][name][<?php echo $language['code']; ?>]" value="" size="25" class="form-control" style="width: 25%; padding:5px; display: inline-block; height: 30px;" /><br />';
                   <?php } ?>
	html += '      <div class="spacer_1"><strong><?php echo $text_status; ?></strong></div>';
	html += '      <select name="'+ type_id +'['+ rulercounter +'][status]">';
	html += '        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
	html += '        <option value="0"><?php echo $text_disabled; ?></option>';
	html += '      </select>';
	html += '    </td>';
	html += '    <td class="center">';
	html += '      <div class="well well-sm" style="height: 100px; overflow: auto;">';
        <?php $class = 'even'; ?>
                     <?php foreach ($geo_zones as $geo_zone) { ?>
                     <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
        html += '<div class="checkbox <?php echo $class; ?>" style="padding: 0; min-height: auto;">';
        html += '<label>';
        html += '<input type="checkbox" name="'+ type_id +'['+ rulercounter +'][geo_zones][]" value="<?php echo $geo_zone['geo_zone_id']; ?>">';
        html += '</label>';
        html += "<?php echo str_replace("'", "&#39;", $geo_zone['name']); ?>";
        html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '      <a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', true);">Select All</a> / <a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', false);">Unselect All</a>';
        html += '    </td>';
	html += '    <td class="center">';
	html += '      <table style="margin: 0 auto;">';
	html += '        <thead>';
	html += '          <tr>';
	html += '            <td class="left">&nbsp;</td>';
	html += '            <td class="center"><?php echo $text_min; ?></td>';
	html += '            <td class="center"><?php echo $text_max; ?></td>';
	html += '          </tr>';
	html += '        </thead>';
	html += '        <tbody>';
	html += '          <tr>';
	html += '            <td class="left"><?php echo $entry_sub_total; ?></td>';
	html += '            <td class="center"><input type="text" name="'+ type_id +'['+ rulercounter +'][total_min]" value="" size="5" class="form-control" style="width: 75%; padding:5px; display: inline-block; height: 30px;"/></td>';
	html += '            <td class="center"><input type="text" name="'+ type_id +'['+ rulercounter +'][total_max]" value="" size="5" class="form-control" style="width: 75%; padding:5px; display: inline-block; height: 30px;"/></td>';
	html += '          </tr>';
	html += '          <tr>';
	html += '            <td class="left"><?php echo $entry_weight; ?></td>';
	html += '            <td class="center"><input type="text" name="'+ type_id +'['+ rulercounter +'][weight_min]" value="" size="5" class="form-control" style="width: 75%; padding:5px; display: inline-block; height: 30px;"/></td>';
	html += '            <td class="center"><input type="text" name="'+ type_id +'['+ rulercounter +'][weight_max]" value="" size="5" class="form-control" style="width: 75%; padding:5px; display: inline-block; height: 30px;"/></td>';
	html += '          </tr>';
	html += '        </tbody>';
	html += '      </table>';
    html += '    </td>';
	html += '    <td class="center">';
	html += '      <div><strong><?php echo $text_shipping_price; ?></strong></div>';
	html += '      <div><input type="text" name="'+ type_id +'['+ rulercounter +'][cost]" value="" size="5" class="form-control" style="width: 50%; padding:5px; display: inline-block; height: 30px;"/></div>';
    html += '    </td>';
	html += '    <td class="left"><a onclick="$(\'#'+ type_id +'' + rulercounter  + '\').remove();" class="btn btn-primary"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';


	$('#'+ table_id +' tfoot').before(html);
}

function addRule_2(type_id, table_id) {
    switch (type_id)
    {
        case "parcel_pro_type_id_DFY_rule":
            rulercounter = count_type_id_DFY_rule;
            count_type_id_DFY_rule++;
            break;
    }

    html  = '<tbody id="'+ type_id + rulercounter +'">';
	html += '  <tr>';
    html += '    <td class="text-center">';
	html += '      <div><strong><?php echo $text_name; ?></strong></div>';
                   <?php foreach ($languages as $language) { ?>
	html += '      <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <input type="text" name="'+ type_id +'['+ rulercounter +'][name][<?php echo $language['code']; ?>]" value="" size="25" class="form-control" style="width: 40%; padding:5px; display: inline-block; height: 30px;"/><br />';
                   <?php } ?>
	html += '      <div class="spacer_1"><strong><?php echo $text_status; ?></strong></div>';
	html += '      <select name="'+ type_id +'['+ rulercounter +'][status]">';
	html += '        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
	html += '        <option value="0"><?php echo $text_disabled; ?></option>';
	html += '      </select>';
	html += '    </td>';
	html += '    <td class="center">';
	html += '      <div class="well well-sm" style="height: 100px; overflow: auto;">';
        <?php $class = 'even'; ?>
                     <?php foreach ($geo_zones as $geo_zone) { ?>
                     <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
        html += '<div class="checkbox <?php echo $class; ?>" style="padding: 0; min-height: auto;">';
        html += '<label>';
        html += '<input type="checkbox" name="'+ type_id +'['+ rulercounter +'][geo_zones][]" value="<?php echo $geo_zone['geo_zone_id']; ?>">';
        html += '</label>';
        html += "<?php echo str_replace("'", "&#39;", $geo_zone['name']); ?>";
        html += '</div>';
        <?php } ?>
        html += '</div>';
    html += '      <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', false);"><?php echo $text_unselect_all; ?></a>';
    html += '    </td>';
	html += '    <td class="center">';
	html += '      <table style="margin: 0 auto;">';
	html += '        <thead>';
	html += '          <tr>';
	html += '            <td class="left">&nbsp;</td>';
	html += '            <td class="center"><?php echo $text_min; ?></td>';
	html += '            <td class="center"><?php echo $text_max; ?></td>';
	html += '          </tr>';
	html += '        </thead>';
	html += '        <tbody>';
	html += '          <tr>';
	html += '            <td class="left"><?php echo $entry_sub_total; ?></td>';
	html += '            <td class="center"><input type="text" name="'+ type_id +'['+ rulercounter +'][total_min]" value="" size="5" class="form-control" style="width: 75%; padding:5px; display: inline-block; height: 30px;" /></td>';
	html += '            <td class="center"><input type="text" name="'+ type_id +'['+ rulercounter +'][total_max]" value="" size="5" class="form-control" style="width: 75%; padding:5px; display: inline-block; height: 30px;" /></td>';
	html += '          </tr>';
	html += '          <tr>';
	html += '            <td class="left"><?php echo $entry_weight; ?></td>';
	html += '            <td class="center"><input type="text" name="'+ type_id +'['+ rulercounter +'][weight_min]" value="" size="5" class="form-control" style="width: 75%; padding:5px; display: inline-block; height: 30px;" /></td>';
	html += '            <td class="center"><input type="text" name="'+ type_id +'['+ rulercounter +'][weight_max]" value="" size="5" class="form-control" style="width: 75%; padding:5px; display: inline-block; height: 30px;" /></td>';
	html += '          </tr>';
	html += '        </tbody>';
	html += '      </table>';
    html += '    </td>';
    html += '    <td class="center">';
	html += '      <table style="margin: 0 auto;">';
	html += '        <tbody>';
	html += '          <tr>';
	html += '            <td class="left"><?php echo $entry_handtekening; ?></td>';
	html += '            <td class="center">';
 	html += '              <select name="'+ type_id +'['+ rulercounter +'][handtekening]">';
	html += '                <option value="1"><?php echo $text_enabled; ?></option>';
	html += '                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>';
	html += '              </select>';
	html += '            </td>';
	html += '          </tr>';
	html += '          <tr>';
	html += '            <td class="left"><?php echo $entry_avond; ?></td>';
	html += '            <td class="center">';
 	html += '              <select name="'+ type_id +'['+ rulercounter +'][avond]">';
	html += '                <option value="1"><?php echo $text_enabled; ?></option>';
	html += '                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>';
	html += '              </select>';
	html += '            </td>';
	html += '          </tr>';
	html += '          <tr>';
	html += '            <td class="left"><?php echo $entry_extrazeker; ?></td>';
	html += '            <td class="center">';
 	html += '              <select name="'+ type_id +'['+ rulercounter +'][extrazeker]">';
	html += '                <option value="1"><?php echo $text_enabled; ?></option>';
	html += '                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>';
	html += '              </select>';
	html += '            </td>';
	html += '          </tr>';
	html += '          <tr>';
	html += '            <td class="left"><?php echo $entry_nietbijburen; ?></td>';
	html += '            <td class="center">';
 	html += '              <select name="'+ type_id +'['+ rulercounter +'][nietbijburen]">';
	html += '                <option value="1"><?php echo $text_enabled; ?></option>';
	html += '                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>';
	html += '              </select>';
	html += '            </td>';
	html += '          </tr>';
	html += '        </tbody>';
	html += '      </table>';
    html += '    </td>';
	html += '    <td class="center">';
	html += '      <div><strong><?php echo $text_shipping_price; ?></strong></div>';
	html += '      <div><input type="text" name="'+ type_id +'['+ rulercounter +'][cost]" value="" size="5" class="form-control" style="width: 50%; padding:5px; display: inline-block; height: 30px;" /></div>';
    html += '    </td>';
	html += '    <td class="left"><a onclick="$(\'#'+ type_id +'' + rulercounter  + '\').remove();" class="btn btn-primary"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';

	$('#'+ table_id +' tfoot').before(html);
}
//--></script>
<?php echo $footer; ?>

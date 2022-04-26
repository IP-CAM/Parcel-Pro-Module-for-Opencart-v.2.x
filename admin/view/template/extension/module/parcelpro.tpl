<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-parcelpro" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if (isset($error['error_warning'])) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error['error_warning']; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-parcelpro" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="entry-Id"><?php echo $entry_Id; ?></label>
            <div class="col-sm-10">
              <input type="text" name="parcelpro_Id" value="<?php echo $parcelpro_Id; ?>" placeholder="<?php echo $entry_Id; ?>" id="entry-Id" class="form-control"/>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="entry-ApiKey"><?php echo $entry_ApiKey; ?></label>
            <div class="col-sm-10">
              <input type="text" name="parcelpro_ApiKey" value="<?php echo $parcelpro_ApiKey; ?>" placeholder="<?php echo $entry_ApiKey; ?>" id="entry-ApiKey" class="form-control"/>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="entry-Webhook"><?php echo $entry_Webhook; ?></label>
            <div class="col-sm-10">
              <input type="text" name="parcelpro_Webhook" value="<?php echo $parcelpro_Webhook; ?>" disabled placeholder="<?php echo $entry_Webhook; ?>" id="entry-Webhook" class="form-control"/>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
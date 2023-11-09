<?php
include("tabel_setting.php");
?>
<style type="text/css">
.proses {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('dist/img/ellipsis.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .9;
}
.culture::first-letter {
  font-size: 150%;
  color: #BF2B26;
}
</style>
<link href="dist/css/stepper.css" rel="stylesheet" type="text/css" />
<script src="plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="dist/js/stepper.js"></script>

<!-- +"&id_atasan1="+id_atasan1+"&email_atasan1="+email_atasan1+"&id_atasan2="+id_atasan2+"&email_atasan2="+email_atasan2+"&id_atasan3="+id_atasan3+"&email_atasan3="+email_atasan3 -->

<div class="row">
<section class="col-lg-6">
	<div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"><?="<b>$a0</b>";?></h3>
        </div>
        <div class="box-body">
            <form method="post" action="api_test.php">
                <div class="form-group">
                    <label for="idkar">Employee ID</label>
                    <input type="text" name="idkar" class="form-control" value="77">
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" value="test_approval">
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <input type="text" name="content" class="form-control" value="test_content">
                </div>
                <div class="form-group">
                    <label for="created_by">Created By</label>
                    <input type="text" name="created_by" class="form-control" value="999">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</section>
<div class="form-group" data-id='<?php echo $_POST['inc'] ?>'>
	<label for="focusedinput" class="col-sm-3 control-label">Specification</label>
	<div class="col-sm-7">
		<textarea name="specification[]" class="form-control" placeholder="Enter specification by @: separated, Example: Data Title @: Data Description"></textarea>
	</div>
	<div class="col-sm-2">
		<i onclick="$(this).parent().parent().hide()" class="fa fa-minus-square" style="margin-top:10px;font-size:20px"></i>
	</div>
	<input type="hidden" name="type[]" value="insert">
</div>
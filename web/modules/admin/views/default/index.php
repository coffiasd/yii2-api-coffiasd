
<div class="box box-primary">
<form class="form-horizontal" role="form">
	<fieldset>
		<legend><h3>配置数据源</h3></legend>
		<div class="form-group">
			<label class="col-sm-1 control-label" for="ds_host">主机名</label>
			<div class="col-sm-3">
				<input class="form-control" id="ds_host" type="text"
					placeholder="192.168.1.161" />
			</div>
			<label class="col-sm-1 control-label" for="ds_name">数据库名</label>
			<div class="col-sm-3">
				<input class="form-control" id="ds_name" type="text"
					placeholder="msh" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-1 control-label" for="ds_username">用户名</label>
			<div class="col-sm-3">
				<input class="form-control" id="ds_username" type="text"
					placeholder="root" />
			</div>
			<label class="col-sm-1 control-label" for="ds_password">密码</label>
			<div class="col-sm-3">
				<input class="form-control" id="ds_password" type="password"
					placeholder="123456" />
			</div>
		</div>
	</fieldset>
	<fieldset>
		<legend>选择相关表</legend>
		<div class="form-group">
			<label for="disabledSelect" class="col-sm-1 control-label">表名</label>
			<div class="col-sm-5">
				<select id="disabledSelect" class="form-control"><option>禁止选择</option>
					<option>禁止选择</option></select>
			</div>
		</div>
	</fieldset>
	<fieldset>
		<legend>字段名</legend>
		<div class="form-group">
			<label for="disabledSelect" class="col-sm-1 control-label">表名</label>
			<div class="col-sm-5">
				<select id="disabledSelect" class="form-control"><option>禁止选择</option>
					<option>禁止选择</option></select>
			</div>
		</div>
	</fieldset>
	
	<button type="submit" id="test" name="submit" value="">sub</button>
</form>
</div>
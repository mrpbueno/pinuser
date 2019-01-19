<div id="toolbar-all">
    <form action="?display=pinuser&action=sync" method="post">
        <button type="submit"
                class="btn btn-default"
                data-toggle="modal"
                data-target="#sync">
            <i class="fa fa-refresh"></i> <?php echo _("Sync PIN")?>
        </button>
    </form>
</div>
<table id="pinuser"
       data-url="ajax.php?module=pinuser&command=getJSON&jdata=grid&page=pinuser"
       data-cache="false"
       data-state-save="true"
       data-state-save-id-table="pinuser_grid"
       data-toolbar="#toolbar-all"
       data-maintain-selected="true"
       data-show-columns="true"
       data-show-toggle="true"
       data-toggle="table"
       data-pagination="true"
       data-search="true"
       class="table table-striped">
	<thead>
		<tr>
            <th data-field="pin" class="col-md-1" data-sortable="true"><?php echo _("PIN")?></th>
            <th data-field="user" class="col-md-5" data-sortable="true"><?php echo _("Name")?></th>
            <th data-field="department" class="col-md-5" data-sortable="true"><?php echo _("Department")?></th>
            <th data-field="id" data-formatter="linkFormat" class="col-md-1 text-center"><?php echo _("Actions")?></th>
		</tr>
	</thead>
</table>
<div id="sync" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title"><?php echo _("Wait!")?></h2>
            </div>
            <div class="modal-body">
                <h3 class="modal-body"><i class="fa fa-spinner fa-spin"></i> <?php echo _("Syncing ...")?></h3>
            </div>
        </div>
    </div>
</div>
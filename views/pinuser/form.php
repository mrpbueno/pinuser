<h3><?php echo ($id ? _("Edit PIN User") : _("New PIN User")) ?></h3>
<form autocomplete="off" action="" method="post" class="fpbx-submit" id="hwform" name="hwform" data-fpbx-delete="config.php?display=pinuser&action=delete&id=<?php echo $id?>">
    <input type="hidden" name="view" value="form">
    <input type="hidden" name='action' value="<?php echo $id?'edit':'add' ?>">
    <!--Pin-->
    <div class="element-container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <label class="control-label" for="body"><?php echo _("PIN") ?></label>
                            <i class="fa fa-question-circle fpbx-help-icon" data-for="pin"></i>
                        </div>
                        <div class="col-md-9">
                            <?php echo $pin; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <span id="pin-help" class="help-block fpbx-help-block"><?php echo _("PIN number of user")?></span>
            </div>
        </div>
    </div>
    <!--End Pin-->
    <!--Name-->
    <div class="element-container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <label class="control-label" for="body"><?php echo _("Name") ?></label>
                            <i class="fa fa-question-circle fpbx-help-icon" data-for="user"></i>
                        </div>
                        <div class="col-md-9">
                            <input type="text" maxlength="50" class="form-control maxlen" id="user" name="user" value="<?php echo $user?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <span id="user-help" class="help-block fpbx-help-block"><?php echo _("Enter Name")?></span>
            </div>
        </div>
    </div>
    <!--END Name-->
    <!--Department-->
    <div class="element-container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <label class="control-label" for="body"><?php echo _("Department") ?></label>
                            <i class="fa fa-question-circle fpbx-help-icon" data-for="department"></i>
                        </div>
                        <div class="col-md-9">
                            <input type="text" maxlength="50" class="form-control maxlen" id="department" name="department" value="<?php echo $department?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <span id="department-help" class="help-block fpbx-help-block"><?php echo _("Enter department")?></span>
            </div>
        </div>
    </div>
    <!--END Department-->
    <!--enabled-->
    <div class="element-container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <label class="control-label" for="active"><?php echo _("Enabled") ?></label>
                            <i class="fa fa-question-circle fpbx-help-icon" data-for="active"></i>
                        </div>
                        <div class="col-md-9">
                            <i class="btn btn-<?php echo ($enabled == '1' ? 'success' : 'danger'); ?>">
                                <?php echo ($enabled == '1' ? _("Yes") : _("No")); ?>
                            </i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <span id="active-help" class="help-block fpbx-help-block"><?php echo _("Enable or disable PIN User.")?></span>
            </div>
        </div>
    </div>
    <!--END enabled-->
    <!--Pinsets -->
    <div class="element-container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <label class="control-label" for="active"><?php echo _("Pinset") ?></label>
                            <i class="fa fa-question-circle fpbx-help-icon" data-for="pinsets"></i>
                        </div>
                        <div class="col-md-9">
                           <ul>
                               <?php foreach ((array)$pinsets as  $pinset): ?>
                               <li>
                                   <?php echo $pinset['description'] ?>
                               </li>
                               <?php endforeach; ?>
                           </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <span id="pinsets-help" class="help-block fpbx-help-block"><?php echo _("Pinset of user.")?></span>
            </div>
        </div>
    </div>
    <!--END Pinsets -->
</form>
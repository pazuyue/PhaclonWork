<div class="page-header">
    <h1>用户登录</h1>
</div>
<?php echo $this->getContent() ?>
<?php echo Phalcon\Tag::form("index/register"); ?>

        <div class="form-group">
           <label for="fieldUsername" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10">
                <?php echo $this->tag->textField(["username", "size" => 30, "class" => "form-control", "id" => "fieldUsername"]) ?>
            </div>
        </div>
        
         <div class="form-group">
                    <label for="fieldPassword" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <?php echo $this->tag->passwordField(["password","size" => 30, "class" => "form-control", "id" => "fieldPassword"]) ?>
                    </div>
                </div>

        <div>
            <?php echo Phalcon\Tag::submitButton("Login"); ?>
        </div>

</form>



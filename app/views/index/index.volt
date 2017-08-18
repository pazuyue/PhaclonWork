<div class="page-header">
    <h1>Congratulations!</h1>
</div>
<?php echo $this->getContent() ?>
<p>You're now flying with Phalcon. Great things are about to happen!</p>

<p>This page is located at <code>views/index/index.volt</code></p>

<h2>
    Sign up using this form <?php echo $this->tag->getTitle(); ?>
</h2>

<?php echo $this->tag->form("index/register"); ?>

<p>
    <label for="name">
        Name
    </label>

    <?php echo $this->tag->textField("name"); ?>
</p>

<p>
    <label for="email">
        E-Mail
    </label>

    <?php echo $this->tag->textField("email"); ?>
</p>

<p>
    <?php echo $this->tag->submitButton("Register"); ?>
</p>

<p><?php  echo $this->tag->linkTo(
        "user",
        "User Up Here!"
    );?></p>




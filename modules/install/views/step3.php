<?=Form::open('install/'.$lang.'/step_3', array('enctype' => 'multipart/form-data'))?>
    <p><?=$entry['step3_db']?></p>
    <fieldset>
      <table class="form">
        <tr>
          <td><?=$entry['step3_db_driver']?></td>
          <td><select name="db_driver">
              <option value="mysqli">MySQLi</option>
            </select></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?=$entry['step3_db_host']?></td>
          <td><input type="text" name="db_host" value="<?=$data['db_host']?>" />
            <br />
            <?php if (isset($errors['db_host'])) { ?>
            <span class="required"><?=$errors['db_host']?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?=$entry['step3_db_user']?></td>
          <td><input type="text" name="db_user" value="<?=$data['db_user']?>" />
            <br />
            <?php if (isset($errors['db_user'])) { ?>
            <span class="required"><?=$errors['db_user']?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?=$entry['step3_db_password']?></td>
          <td><input type="text" name="db_password" value="<?=$data['db_password']?>" /></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?=$entry['step3_db_name']?></td>
          <td><input type="text" name="db_name" value="<?=$data['db_name']?>" />
            <br />
            <?php if (isset($errors['db_name'])) { ?>
            <span class="required"><?=$errors['db_name']?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?=$entry['step3_db_prefix']?></td>
          <td><input type="text" name="db_prefix" value="<?=$data['db_prefix']?>" /></td>
        </tr>
      </table>
    </fieldset>
    <p><?=$entry['step3_admin']?></p>
    <fieldset>
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?=$entry['step3_username']?></td>
          <td><input type="text" name="username" value="<?=$data['username']?>" />
            <br />
            <?php if (isset($errors['username'])) { ?>
            <span class="required"><?=$errors['username']?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?=$entry['step3_password']?></td>
          <td><input type="text" name="password" value="<?=$data['password']?>" /><br />
            <?php if (isset($errors['password'])) { ?>
            <span class="required"><?=$errors['password']?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?=$entry['step3_email']?></td>
          <td><input type="text" name="email" value="<?=$data['email']?>" />
            <br />
            <?php if (isset($errors['email'])) { ?>
            <span class="required"><?=$errors['email']?></span>
            <?php } ?></td>
        </tr>
      </table>
    </fieldset>
    <div class="buttons">
      <div class="left"><?=HTML::anchor('install/'.$lang.'/step_2', $text['button_back'], array('class' => 'button'))?></div>
      <div class="right"><?=Form::submit('submit', $text['button_continue'], array('class' => 'button'))?></div>
    </div>
<?=Form::close()?> 
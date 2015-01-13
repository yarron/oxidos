<?=Form::open('install/'.$lang.'/step_2', array('enctype' => 'multipart/form-data'))?>
 <p><?=$entry['step2_config']?></p>
    <fieldset>
      <table>
        <tr>
          <th width="35%" align="left"><b><?=$entry['step2_config_php']?></b></th>
            <th width="25%" align="left"><b><?=$entry['step2_current']?></b></th>
            <th width="25%" align="left"><b><?=$entry['step2_necessary']?></b></th>
            <th width="15%" align="center"><b><?=$entry['step2_state']?></b></th>
        </tr>
        <tr>
          <td>PHP Version:</td>
          <td><?php echo phpversion(); ?></td>
          <td>5.3.3</td>
          <td align="center"><?php echo (phpversion() >= '5.3.3') ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
        </tr>
        <tr>
          <td>Register Globals:</td>
          <td><?php echo (ini_get('register_globals')) ? 'On' : 'Off'; ?></td>
          <td>Off</td>
          <td align="center"><?php echo (!ini_get('register_globals')) ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
        </tr>
        <tr>
          <td>Magic Quotes GPC:</td>
          <td><?php echo (ini_get('magic_quotes_gpc')) ? 'On' : 'Off'; ?></td>
          <td>Off</td>
          <td align="center"><?php echo (!ini_get('magic_quotes_gpc')) ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
        </tr>
        <tr>
          <td>File Uploads:</td>
          <td><?php echo (ini_get('file_uploads')) ? 'On' : 'Off'; ?></td>
          <td>On</td>
          <td align="center"><?php echo (ini_get('file_uploads')) ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
        </tr>
        <tr>
          <td>Character Type (CTYPE)</td>
          <td><?php echo function_exists('ctype_digit') ? 'On' : 'Off'; ?></td>
          <td>On</td>
          <td align="center"><?php echo function_exists('ctype_digit') ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
        </tr>
        <tr>
          <td>Filters</td>
          <td><?php echo function_exists('filter_list') ? 'On' : 'Off'; ?></td>
          <td>On</td>
          <td align="center"><?php echo function_exists('filter_list') ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
        </tr>
        <tr>
          <td>Reflection</td>
          <td><?php echo class_exists('ReflectionClass') ? 'On' : 'Off'; ?></td>
          <td>On</td>
          <td align="center"><?php echo class_exists('ReflectionClass') ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
        </tr>
        <tr>
          <td>SPL</td>
          <td><?php echo function_exists('spl_autoload_register') ? 'On' : 'Off'; ?></td>
          <td>On</td>
          <td align="center"><?php echo function_exists('spl_autoload_register') ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
        </tr>
        <tr>
          <td>mCrypt:</td>
          <td><?php echo function_exists('mcrypt_encrypt') ? 'On' : 'Off'; ?></td>
          <td>On</td>
          <td align="center"><?php echo function_exists('mcrypt_encrypt') ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
        </tr>
        <tr>
          <td>PCRE UTF-8</td>
          <td><?php echo @preg_match('/^.$/u', 'ñ') ? 'On' : 'Off'; ?></td>
          <td>On</td>
          <td align="center"><?php echo @preg_match('/^.$/u', 'ñ') ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
        </tr>
      </table>
    </fieldset> 
    <p><?=$entry['step2_extension']?></p>
    <fieldset>
      <table>
        <tr>
			<th width="35%" align="left"><b><?=$entry['step2_extension_extension']?></b></th>
            <th width="25%" align="left"><b><?=$entry['step2_current']?></b></th>
            <th width="25%" align="left"><b><?=$entry['step2_necessary']?></b></th>
            <th width="15%" align="center"><b><?=$entry['step2_state']?></b></th>
        </tr>
        <tr>
          <td>MySQL:</td>
          <td><?php echo extension_loaded('mysql') ? 'On' : 'Off'; ?></td>
          <td>On</td>
          <td align="center"><?php echo extension_loaded('mysql') ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
        </tr>
          <tr>
              <td>MySQLi:</td>
              <td><?php echo extension_loaded('mysqli') ? 'On' : 'Off'; ?></td>
              <td>On</td>
              <td align="center"><?php echo extension_loaded('mysqli') ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
          </tr>
        <tr>
          <td>PDO:</td>
          <td><?php echo extension_loaded('PDO') ? 'On' : 'Off'; ?></td>
          <td>On</td>
          <td align="center"><?php echo extension_loaded('PDO') ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
        </tr>
        <tr>
          <td>GD:</td>
          <td><?php echo extension_loaded('gd') ? 'On' : 'Off'; ?></td>
          <td>On</td>
          <td align="center"><?php echo extension_loaded('gd') ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
        </tr>
        <tr>
          <td>cURL:</td>
          <td><?php echo extension_loaded('curl') ? 'On' : 'Off'; ?></td>
          <td>On</td>
          <td align="center"><?php echo extension_loaded('curl') ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
        </tr>
        
        <tr>
          <td>mbString</td>
          <td><?php echo extension_loaded('mbstring') ? 'On' : 'Off'; ?></td>
          <td>On</td>
          <td align="center"><?php echo extension_loaded('mbstring') ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
        </tr>
        <tr>
          <td>Iconv</td>
          <td><?php echo extension_loaded('iconv') ? 'On' : 'Off'; ?></td>
          <td>On</td>
          <td align="center"><?php echo extension_loaded('iconv') ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
        </tr>
        <tr>
          <td>IonCube</td>
          <td><?php echo extension_loaded('ionCube Loader') ? 'On' : 'Off'; ?></td>
          <td>On</td>
          <td align="center"><?php echo extension_loaded('ionCube Loader') ? '<img src="/styles/install/image/good.png" alt="Good" />' : '<img src="/styles/install/image/bad.png" alt="Bad" />'; ?></td>
        </tr>
      </table>
    </fieldset>
    <p><?=$entry['step2_file']?></p>
    <fieldset>
      <table>
        <tr>
          <th align="left"><b><?=$entry['step2_file_file']?></b></th>
          <th align="left"><b><?=$entry['step2_state']?></b></th>
        </tr>
        <tr>
          <td><?=$file['bootstrap']?></td>
          <td>
          <?if (!file_exists($file['bootstrap'])):?>
            <span class="bad"><?=$entry['step2_file_non']?></span>
          <?elseif (!is_writable($file['bootstrap'])):?>
            <span class="bad"><?=$entry['step2_nowrite']?></span>
          <?else:?>
            <span class="good"><?=$entry['step2_write']?></span>
          <?endif?>
          </td>
        </tr>
        <tr>
          <td><?=$file['database']?></td>
          <td>
          <?if (!file_exists($file['database'])):?>
            <span class="bad"><?=$entry['step2_file_non']?></span>
          <?elseif (!is_writable($file['database'])):?>
            <span class="bad"><?=$entry['step2_nowrite']?></span>
          <?else:?>
            <span class="good"><?=$entry['step2_write']?></span>
          <?endif?>
          </td>
        </tr>
      </table>
    </fieldset> 
    <p><?=$entry['step2_catelog']?></p>
    <fieldset>
      <table>
          <tr>
            <th align="left"><b><?=$entry['step2_catelog_catalog']?></b></th>
            <th width="30%" align="left"><b><?=$entry['step2_state']?></b></th>
          </tr>
          <tr>
            <td><?php echo $directory['cache'] . '/'; ?></td>
            <td><?php echo is_writable($directory['cache']) ? '<span class="good">'.$entry['step2_write'].'</span>' : '<span class="bad">'.$entry['step2_nowrite'].'</span>'; ?></td>
          </tr>
          <tr>
            <td><?php echo $directory['logs'] . '/'; ?></td>
            <td><?php echo is_writable($directory['logs']) ? '<span class="good">'.$entry['step2_write'].'</span>' : '<span class="bad">'.$entry['step2_nowrite'].'</span>'; ?></td>
          </tr>
          <tr>
            <td><?php echo $directory['image'] . '/'; ?></td>
            <td><?php echo is_writable($directory['image']) ? '<span class="good">'.$entry['step2_write'].'</span>' : '<span class="bad">'.$entry['step2_nowrite'].'</span>'; ?></td>
          </tr>
          <tr>
            <td><?php echo $directory['image_cache'] . '/'; ?></td>
            <td><?php echo is_writable($directory['image_cache']) ? '<span class="good">'.$entry['step2_write'].'</span>' : '<span class="bad">'.$entry['step2_nowrite'].'</span>'; ?></td>
          </tr>
          <tr>
            <td><?php echo $directory['image_data'] . '/'; ?></td>
            <td><?php echo is_writable($directory['image_data']) ? '<span class="good">'.$entry['step2_write'].'</span>' : '<span class="bad">'.$entry['step2_nowrite'].'</span>'; ?></td>
          </tr>          
          
        </table>
    </fieldset>   
    <div class="buttons">
      <div class="left"><?=HTML::anchor('install/'.$lang.'/step_1', $text['button_back'], array('class' => 'button'))?></div>
      <div class="right"><?=Form::submit('submit', $text['button_continue'], array('class' => 'button'))?></div>
    </div>  
<?=Form::close()?>  
<?=Form::open('install/'.$lang.'/step_1', array('enctype' => 'multipart/form-data'))?>
        <div class="terms"><?=$entry['step1_license']?></div>
        <div class="buttons">
            <div class="right">
                <?=Form::label('agree', $entry['step1_agree'])?>
                <?=Form::checkbox('agree', 1, false)?>&nbsp;
                <?=Form::submit('submit', $text['button_continue'], array('class' => 'button'))?>
            </div>
        </div>
<?=Form::close()?>   
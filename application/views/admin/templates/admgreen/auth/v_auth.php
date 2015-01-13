<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-lock"></i>
            <span><?=$text['heading_title']?></span>
        </div>
        <div class="panel-body">
            <?if($message):?>
                <div class="alert alert-success" role="alert">
                    <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
                    <span class="sr-only">Success:</span>
                    <?=$message?>
                </div>
            <?endif?>
            <?if($errors):?>
                <div class="alert alert-warning" role="alert">
                    <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    <?=$errors?>
                </div>
            <?endif?>
            <?=Form::open('admin/login', array('enctype' => 'multipart/form-data', "id" => "form", 'class'=> 'form-signin', 'role'=> 'form'))?>
                <div class="form-group">
                    <label for="username" class="sr-only"><?=$text['text_username']?></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <?=Form::input('username', $data['username'], array('id' => 'username', 'class' => 'form-control', 'placeholder' => $text['text_username'],'required'=>'', 'autofocus'=>''))?>
                    </div><br/>
                </div>
                <div class="form-group">
                    <label for="password" class="sr-only"><?=$text['text_password']?></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                        <?=Form::password('password', $data['password'], array('id' => 'password', 'class' => 'form-control', 'placeholder' => $text['text_password'],'required'=>''))?>
                    </div><br/>
                </div>
                <div class="form-group">
                    <div class="col-xs-8 col-sm-8">
                        <button id="enter" data-loading-text="<?=$text['text_loading']?>" class="btn btn-primary form-control" type="submit"><?=$text['text_enter']?> <i class="glyphicon glyphicon-log-in"></i></button>
                    </div>
                    <div class="col-xs-2 col-sm-2">
                        <?=HTML::anchor('account/forgotten', '<i class="glyphicon glyphicon-question-sign"></i> ', array('class'=> 'btn btn-default form-control','data-toggle'=>'tooltip', 'title' => $text['text_forgotten'], 'data-placement' =>'bottom'))?>
                    </div>
                    <div class="col-xs-2 col-sm-2">
                        <?=Form::checkbox('remember','remember', false, array('class'=> 'form-control', 'data-toggle'=>'tooltip', 'title' => $text['text_remember'], 'data-placement' =>'bottom' ))?>
                    </div>
                </div><br/><br/>

                <?if($enters):?>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <label for="captcha" class="sr-only"><?=$text['text_captcha']?></label>
                            <?=Form::input('captcha', '', array('id' => 'captcha', 'class' => 'form-control', 'placeholder' => $text['text_captcha'],'required'=>''))?>
                            <span id="reload" class="input-group-addon" style="cursor: pointer"><i class="glyphicon glyphicon-refresh"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-2"><?=$captcha?></div>
                    <div class="col-sm-2"></div>
                    <br/>
                <?endif?>
                <?=Form::hidden('action', 'login')?><?=Form::hidden('enters', ++$enters)?>
            <?=Form::close()?>
        </div>
    </div>
</div>

<script><!--
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('#form input').on('keydown', function (e) {
            if (e.keyCode == 13) {
                $('#form').submit();
            }
        });

        $('#reload').on('click', function () {
            id=Math.floor(Math.random()*1000000);
            $("img.captcha").attr("src","/captcha/default?id="+id);
        });

        $('#enter').on('click', function (event) {
            event.preventDefault();
            var btn = $(this).button('loading');
            $('#form').submit();
        });
    });
//--></script>

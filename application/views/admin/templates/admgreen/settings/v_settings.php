<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-cog"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group" >
                <a data-toggle="tooltip" title="<?=$text['button_save']?>" onclick="$('#form').submit();" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-open"></i></a>
                <a data-toggle="tooltip" title="<?=$text['button_abort']?>" href="/admin" class="btn btn-primary"><i class="glyphicon glyphicon-share-alt"></i></a>
            </div>
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
                <?foreach ($errors as $error):?>
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        <?=$error?>
                    </div>
                <?endforeach?>
            <?endif?>
            <?=Form::open('admin/settings/', array('enctype' => 'multipart/form-data', "id" => "form", "role"=> "form", "class"=> "form-horizontal"))?>
            <div role="tabpanel">
                <ul id="tabs-main" class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#general"  aria-controls="general" role="tab" data-toggle="tab"><?=$text['tab-general']?></a></li>
                    <li role="presentation"><a href="#meta"  aria-controls="meta" role="tab" data-toggle="tab"><?=$text['tab-meta']?></a></li>
                    <li role="presentation"><a href="#local"  aria-controls="local" role="tab" data-toggle="tab"><?=$text['tab-local']?></a></li>
                    <li role="presentation"><a href="#mail"  aria-controls="mail" role="tab" data-toggle="tab"><?=$text['tab-mail']?></a></li>
                    <li role="presentation"><a href="#image"  aria-controls="image" role="tab" data-toggle="tab"><?=$text['tab-image']?></a></li>
                    <li role="presentation"><a href="#option"  aria-controls="option" role="tab" data-toggle="tab"><?=$text['tab-option']?></a></li>
                    <li role="presentation"><a href="#server"  aria-controls="server" role="tab" data-toggle="tab"><?=$text['tab-server']?></a></li>
                    <li role="presentation"><a href="#stat"  aria-controls="stat" role="tab" data-toggle="tab"><?=$text['tab-stat']?></a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active"  id="general"><br/>
                        <div class="form-group <?=isset($errors['company_name']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[company_name]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_company_name'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[company_name]', isset($data['company_name']) ? $data['company_name'] : "", array('size' => 40, 'class'=>'form-control'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[company_description]', $text['text_company_description'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::textarea('settings[company_description]',isset($data['company_description']) ? $data['company_description'] : "", array('cols' => 40, 'rows' => 5, 'class'=>'form-control'))?></div>
                        </div>
                        <div class="form-group <?=isset($errors['company_director']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[company_director]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_company_director'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[company_director]', isset($data['company_director']) ? $data['company_director'] : "", array('size' => 40, 'class'=>'form-control'))?></div>
                        </div>
                        <div class="form-group <?=isset($errors['company_email']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[company_email]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_company_email'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[company_email]', isset($data['company_email']) ? $data['company_email'] : "", array('size' => 40, 'class'=>'form-control'))?></div>
                        </div>
                        <div class="form-group <?=isset($errors['company_address']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[company_address]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_company_address'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::textarea('settings[company_address]',isset($data['company_address']) ? $data['company_address'] : "", array('cols' => 40, 'rows' => 5, 'class'=>'form-control'))?></div>
                        </div>
                        <div class="form-group <?=isset($errors['company_phone']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[company_phone]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_company_phone'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[company_phone]', isset($data['company_phone']) ? $data['company_phone'] : "", array('size' => 40, 'class'=>'form-control'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[company_fax]', $text['text_company_fax'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[company_fax]', isset($data['company_fax']) ? $data['company_fax'] : "", array('size' => 40, 'class'=>'form-control'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[company_code]', $text['text_company_code'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>',array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_company_code_tooltip']))?>
                            <div class="col-sm-10"><?=Form::textarea('settings[company_code]',isset($data['company_code']) ? $data['company_code'] : "", array('cols' => 40, 'rows' => 5, 'class'=>'form-control'))?></div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade"  id="meta"> <br/>
                        <div class="form-group <?=isset($errors['site_name']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[site_name]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_site_name'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[site_name]', isset($data['site_name']) ? $data['site_name'] : "", array('size' => 40, 'class'=>'form-control'))?></div>
                        </div>
                        <div class="form-group <?=isset($errors['site_description']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[site_description]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_site_description'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[site_description]', isset($data['site_description']) ? $data['site_description'] : "", array('size' => 40, 'class'=>'form-control'))?></div>
                        </div>
                        <div class="form-group <?=isset($errors['title']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[title]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_title'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[title]', isset($data['title']) ? $data['site_description'] : "", array('size' => 40, 'class'=>'form-control'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[meta_description]', $text['text_meta_description'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::textarea('settings[meta_description]',isset($data['meta_description']) ? $data['meta_description'] : "", array('cols' => 40, 'rows' => 5, 'class'=>'form-control'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[meta_keywords]', $text['text_meta_keywords'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[meta_keywords]', isset($data['meta_keywords']) ? $data['meta_keywords'] : "", array('size' => 40, 'class'=>'form-control'))?></div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade"  id="local"><br/>
                        <div class="form-group">
                            <?=Form::label('settings[index_language_id]', $text['text_language_index'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::select('settings[index_language_id]', $languages, $data['index_language_id'],array("class" => "form-control", 'style'=>'width:100px')) ?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[admin_language_id]', $text['text_language_admin'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::select('settings[admin_language_id]', $languages, $data['admin_language_id'],array("class" => "form-control", 'style'=>'width:100px')) ?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[template_index]', $text['text_template_index'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10">
                                <select style="width:100px" class="form-control" name="settings[template_index]" onchange="$('#template_index').load('/admin/settings/info/' + encodeURIComponent(this.value));" >
                                    <?foreach ($templates_index as $template_i):?>
                                        <?if ($template_i == $config_template_index):?>
                                            <option value="<?=$template_i?>" selected="selected"><?=$template_i?></option>
                                        <?else:?>
                                            <option value="<?=$template_i?>"><?=$template_i?></option>
                                        <?endif?>
                                    <?endforeach?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10" id="template_index"></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[template_admin]', $text['text_template_admin'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10">
                                <select style="width:100px" class="form-control" name="settings[template_admin]" onchange="$('#template_admin').load('/admin/settings/info/' + encodeURIComponent(this.value));" >
                                    <?foreach ($templates_admin as $template_a):?>
                                        <?if ($template_a == $config_template_admin):?>
                                            <option value="<?=$template_a?>" selected="selected"><?=$template_a?></option>
                                        <?else:?>
                                            <option value="<?=$template_a?>"><?=$template_a?></option>
                                        <?endif?>
                                    <?endforeach?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10" id="template_admin"></div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade"  id="mail"><br/>
                        <div class="form-group">
                            <?=Form::label('settings[mail_protocol]', $text['text_mail_protocol'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::select('settings[mail_protocol]', $mail['protocol'], isset($data['mail_protocol']) ? $data['mail_protocol'] : "", array('id' => 'mail', 'class'=>'form-control', 'style'=>'width:100px')) ?></div>
                        </div>
                        <div class="form-group smtp">
                            <?=Form::label('settings[smtp_host]', $text['text_smtp_host'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[smtp_host]', isset($data['smtp_host']) ? $data['smtp_host'] : "", array('size' => 30, 'class'=>'form-control', 'style'=>'width:100px'))?></div>
                        </div>
                        <div class="form-group smtp">
                            <?=Form::label('settings[smtp_login]', $text['text_smtp_login'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[smtp_login]', isset($data['smtp_login']) ? $data['smtp_login'] : "", array('size' => 30, 'class'=>'form-control', 'style'=>'width:100px'))?></div>
                        </div>
                        <div class="form-group smtp">
                            <?=Form::label('settings[smtp_password]', $text['text_smtp_password'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::password('settings[smtp_password]', isset($data['smtp_password']) ? $data['smtp_password'] : "", array('size' => 30, 'class'=>'form-control', 'style'=>'width:100px'))?></div>
                        </div>
                        <div class="form-group smtp">
                            <?=Form::label('settings[smtp_port]', $text['text_smtp_port'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[smtp_port]', isset($data['smtp_port']) ? $data['smtp_port'] : "", array('size' => 30, 'class'=>'form-control', 'style'=>'width:100px'))?></div>
                        </div>
                        <div class="form-group smtp">
                            <?=Form::label('settings[smtp_timeout]', $text['text_smtp_timeout'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[smtp_timeout]', isset($data['smtp_timeout']) ? $data['smtp_timeout'] : "", array('size' => 30, 'class'=>'form-control', 'style'=>'width:100px'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[smtp_mail_registration]', $text['text_mail_registration'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10">
                                <div class="radio">
                                    <label><?=Form::radio('settings[mail_registration]', 1, $mail["yes"], array('class' => 'email')) ?> <?=$text['text_yes']?></label>&nbsp;
                                    <label><?=Form::radio('settings[mail_registration]', 0, $mail["no"], array('class' => 'email')) ?> <?=$text['text_no']?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group optional">
                            <?=Form::label('settings[optional_address]', $text['text_optional_address'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>',array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_optional_address_tooltip']))?>
                            <div class="col-sm-10"><?=Form::textarea('settings[optional_address]',isset($data['optional_address']) ? $data['optional_address'] : "", array('cols' => 40, 'rows' => 5,'class'=>'form-control'))?></div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade"  id="image"><br/>
                        <div class="form-group">
                            <?=Form::label('settings[logo]', $text['text_logotype'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10 image">
                                <?=HTML::image($logotype['thumb'], array('alt' => '', 'id' => 'thumb-logo','class'=>'img-thumbnail'));?>
                                <input type="hidden" name="settings[logo]" value="<?=$logotype['logo']?>" id="logo"  />
                                <br />
                                <a data-toggle="tooltip" data-loading-text="<?=$text['button_loading']?>" class="btn btn-default btn-editor" data-image="logo" data-thumb="thumb-logo"  ><i class="glyphicon glyphicon-eye-open"></i></a>
                                <a data-toggle="tooltip" class="btn btn-danger" onclick="$('#thumb-logo').attr('src', '<?=$logotype['no_image']?>'); $('#logo').attr('value', '');"><i class="glyphicon glyphicon-trash"></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[icon]', $text['text_icon'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>',array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_icon_tooltip']))?>
                            <div class="col-sm-10 image">
                                <?=HTML::image($icon['thumb'], array('alt' => '', 'id' => 'thumb-icon','class'=>'img-thumbnail'));?>
                                <input type="hidden" name="settings[icon]" value="<?=$icon['icon']?>" id="icon"  />
                                <br />
                                <a data-toggle="tooltip" data-loading-text="<?=$text['button_loading']?>" class="btn btn-default btn-editor" data-image="icon" data-thumb="thumb-icon" ><i class="glyphicon glyphicon-eye-open"></i></a>
                                <a data-toggle="tooltip" class="btn btn-danger" onclick="$('#thumb-icon').attr('src', '<?=$logotype['no_image']?>'); $('#icon').attr('value', '');"><i class="glyphicon glyphicon-trash"></i></a>
                            </div>
                        </div>
                        <div class="form-group <?=isset($errors['image_article']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[image_article]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_image_article'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[image_article]', isset($data['image_article']) ? $data['image_article'] : "", array('size' => 3, 'class'=> 'form-control', 'style'=>'width:50px'))?></div>
                        </div>
                        <div class="form-group <?=isset($errors['image_category']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[image_category]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_image_category'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[image_category]', isset($data['image_category']) ? $data['image_category'] : "", array('size' => 3, 'class'=> 'form-control', 'style'=>'width:50px'))?></div>
                        </div>
                        <div class="form-group <?=isset($errors['image_news']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[image_news]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_image_news'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[image_news]', isset($data['image_news']) ? $data['image_news'] : "", array('size' => 3, 'class'=> 'form-control', 'style'=>'width:50px'))?></div>
                        </div>
                        <div class="form-group <?=isset($errors['image_search']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[image_search]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_image_search'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[image_search]', isset($data['image_search']) ? $data['image_search'] : "", array('size' => 3, 'class'=> 'form-control', 'style'=>'width:50px'))?></div>
                        </div>
                        <div class="form-group <?=isset($errors['image_popup']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[image_popup]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_image_popup'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[image_popup]', isset($data['image_popup']) ? $data['image_popup'] : "", array('size' => 3, 'class'=> 'form-control', 'style'=>'width:50px'))?></div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade"  id="option">
                        <h3><?=$text['head_user']?></h3>
                        <div class="form-group">
                            <?=Form::label('settings[newsletter]', $text['text_newsletter'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>',array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_newsletter_tooltip']))?>
                            <div class="col-sm-10"><?=Form::select('settings[newsletter]', $pages, $data['newsletter'],array('class'=> 'form-control','style'=>'width:250px')) ?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[user_role]', $text['text_user_role'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>',array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_user_role_tooltip']))?>
                            <div class="col-sm-10"><?=Form::select('settings[user_role]', $roles, $data['user_role'],array('class'=> 'form-control','style'=>'width:250px')) ?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[admin_role]', $text['text_admin_role'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>',array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_admin_role_tooltip']))?>
                            <div class="col-sm-10"><?=Form::select('settings[admin_role]', $roles, $data['admin_role'],array('class'=> 'form-control','style'=>'width:250px')) ?></div>
                        </div>
                        <h3><?=$text['head_article']?></h3>
                        <div class="form-group <?=isset($errors['limit_article']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[limit_article]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_limit_article'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[limit_article]', isset($data['limit_article']) ? $data['limit_article'] : "",array('size' => 3,'class'=> 'form-control','style'=>'width:50px')) ?></div>
                        </div>
                        <div class="form-group <?=isset($errors['count_article']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[count_article]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_count_article'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[count_article]', isset($data['count_article']) ? $data['count_article'] : "",array('size' => 3,'class'=> 'form-control','style'=>'width:50px')) ?></div>
                        </div>
                        <h3><?=$text['head_new']?></h3>
                        <div class="form-group <?=isset($errors['limit_new']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[limit_new]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_limit_new'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[limit_new]', isset($data['limit_new']) ? $data['limit_new'] : "",array('size' => 3,'class'=> 'form-control','style'=>'width:50px')) ?></div>
                        </div>
                        <div class="form-group <?=isset($errors['count_new']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[count_new]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_count_new'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[count_new]', isset($data['count_new']) ? $data['count_new'] : "",array('size' => 3,'class'=> 'form-control','style'=>'width:50px')) ?></div>
                        </div>
                        <h3><?=$text['head_comment']?></h3>
                        <div class="form-group">
                            <?=Form::label('settings[mode_comment]', $text['text_mode_comment'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10">
                                <div class="radio">
                                    <label><?=Form::radio('settings[mode_comment]', 1, $comment["yes"]) ?> <?=$text['text_yes']?></label>&nbsp;
                                    <label><?=Form::radio('settings[mode_comment]', 0, $comment["no"]) ?> <?=$text['text_no']?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[comment_moderation]', $text['text_comment_moderation'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10">
                                <div class="radio">
                                    <label><?=Form::radio('settings[comment_moderation]', 1, $moderation["yes"]) ?> <?=$text['text_yes']?></label>&nbsp;
                                    <label><?=Form::radio('settings[comment_moderation]', 0, $moderation["no"]) ?> <?=$text['text_no']?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[comment_guest]', $text['text_comment_guest'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10">
                                <div class="radio">
                                    <label><?=Form::radio('settings[comment_guest]', 1, $guest["yes"]) ?> <?=$text['text_yes']?></label>&nbsp;
                                    <label><?=Form::radio('settings[comment_guest]', 0, $guest["no"]) ?> <?=$text['text_no']?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group <?=isset($errors['count_comment']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[count_comment]', $text['text_count_comment'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[count_comment]', isset($data['count_comment']) ? $data['count_comment'] : "", array('size' => 3, 'class'=> 'form-control','style'=>'width:50px'))?></div>
                        </div>
                        <h3><?=$text['head_search']?></h3>
                        <div class="form-group <?=isset($errors['limit_search']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[limit_search]', $text['text_limit_search'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[limit_search]', isset($data['limit_search']) ? $data['limit_search'] : "", array('size' => 3, 'class'=> 'form-control','style'=>'width:50px'))?></div>
                        </div>
                        <div class="form-group <?=isset($errors['count_search']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[count_search]', $text['text_count_search'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[count_search]', isset($data['count_search']) ? $data['count_search'] : "", array('size' => 3, 'class'=> 'form-control','style'=>'width:50px'))?></div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade"  id="server"><br/>
                        <div class="form-group">
                            <?=Form::label('settings[maintenance]', $text['text_maintenance'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>',array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_maintenance_tooltip']))?>
                            <div class="col-sm-10">
                                <div class="radio">
                                    <label><?=Form::radio('settings[maintenance]', 1, $server["yes"]) ?> <?=$text['text_yes']?></label>&nbsp;
                                    <label><?=Form::radio('settings[maintenance]', 0, $server["no"]) ?> <?=$text['text_no']?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[maintenance_info]', $text['text_maintenance_info'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>',array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_maintenance_info_tooltip']))?>
                            <div class="col-sm-10"><?=Form::textarea('settings[maintenance_info]',isset($data['maintenance_info']) ? $data['maintenance_info'] : "", array('cols' => 80, 'rows' => 5,'class'=>'form-control'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[cache]', $text['text_cache'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>',array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_cache_tooltip']))?>
                            <div class="col-sm-10"><?=Form::select('settings[cache]', $cache, $data['cache'],array('class'=>'form-control','style'=>'width:100px')) ?></div>
                        </div>
                        <div class="form-group <?=isset($errors['cache_time']) ? 'has-error' : ''?>">
                            <?=Form::label('settings[cache_time]', $text['text_cache_time'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>',array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_cache_time_tooltip']))?>
                            <div class="col-sm-10"><?=Form::input('settings[cache_time]', isset($data['cache_time']) ? $data['cache_time'] : "", array('size' => 6, 'class'=>'form-control','style'=>'width:100px'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[cache_compression]', $text['text_cache_compression'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>',array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_cache_mem_tooltip']))?>
                            <div class="col-sm-10">
                                <div class="radio">
                                    <label><?=Form::radio('settings[cache_compression]', 1, $compression["yes"]) ?> <?=$text['text_yes']?></label>&nbsp;
                                    <label><?=Form::radio('settings[cache_compression]', 0, $compression["no"]) ?> <?=$text['text_no']?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[cache_host]', $text['text_cache_host'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>',array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_cache_mem_tooltip']))?>
                            <div class="col-sm-10"><?=Form::input('settings[cache_host]', isset($data['cache_host']) ? $data['cache_host'] : "", array('size' => 40,'class'=>'form-control','style'=>'width:100px'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[cache_port]', $text['text_cache_port'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>',array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_cache_mem_tooltip']))?>
                            <div class="col-sm-10"><?=Form::input('settings[cache_port]', isset($data['cache_port']) ? $data['cache_port'] : "", array('size' => 6,'class'=>'form-control','style'=>'width:100px'))?></div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade"  id="stat"><br/>
                        <div class="form-group">
                            <?=Form::label('settings[google]', $text['text_google'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::textarea('settings[google]',isset($data['google']) ? $data['google'] : "", array('cols' => 80, 'rows' => 5,'class'=>'form-control'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[google_login]', $text['text_google_login'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[google_login]', isset($data['google_login']) ? $data['google_login'] : "", array('size' => 20,'class'=>'form-control','style'=>'width:100px'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[google_password]', $text['text_google_password'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::password('settings[google_password]', isset($data['google_password']) ? $data['google_password'] : "", array('size' => 20,'class'=>'form-control','style'=>'width:100px'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[google_report_id]', $text['text_google_report_id'],array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('settings[google_report_id]', isset($data['google_report_id']) ? $data['google_report_id'] : "", array('size' => 20,'class'=>'form-control','style'=>'width:100px'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('settings[google_check]', $text['text_google_check'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>',array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=> $text['text_google_check_tooltip']))?>
                            <div class="col-sm-10">
                                <a data-loading-text="<?=$text['button_loading']?>" class="btn btn-default" id="google_check" autocomplete="off"><?=$text['text_google_start']?></a>
                                <span id="google_data"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?=Form::close()?>
        </div>
    </div>
</div>
<script><!--
    $(function() {
        $('#template_index').load('/admin/settings/info/' + encodeURIComponent($('select[name=\'settings[template_index]\']').val()));
        $('#template_admin').load('/admin/settings/info/' + encodeURIComponent($('select[name=\'settings[template_admin]\']').val()));
        $('#tabs-main a:first').tab('show');
        $('[data-toggle="tooltip"]').tooltip();

        $('#google_check').on('click',function(){
            var btn = $(this).button('loading');
            $.ajax({
                type: 'GET',
                url: '/admin/main/chart/check',
                dataType: 'json',
                error: function(XMLHttpRequest, textStatus) {
                    $('#google_data').html("<i class='glyphicon glyphicon-warning-sign btn-lg'></i>");
                },
                success: function(json) {
                    if(json.status > 0)
                        $('#google_data').html("<i class='glyphicon glyphicon-ok btn-lg'></i>");
                    else
                        $('#google_data').html("<i class='glyphicon glyphicon-warning-sign btn-lg'></i>");
                },
                complete: function(){
                    btn.button('reset');
                }

            });
        });

        function checked (){
            var protocol = $("#mail option:selected").val();
            var emails = $(".email:checked").val();

            if(protocol == "native") $('.smtp input').attr("disabled", true);
            else $('.smtp input').attr("disabled", false);

            if(emails == 1) $('.optional textarea').attr("disabled", false);
            else $('.optional textarea').attr("disabled", true);

        }
        $('#mail,.email').change(function(){checked();});

        checked();
    });
//--></script>
<script src="/styles/admin/templates/admgreen/javascript/common.js"></script>


   
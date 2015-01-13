<div id="loading-layer" style="display:none"><b><?=$text['loading']?></b></div>
<div id="container">
    <?=$header?>
    <div id="wrap">
        <div id="sub-wrap">
            <?=$slider?>
            <?=$column_left?>
            <?=$column_right?>
            <div id="content">
                <? if (isset($page_url)):?><div class="breadcrumb"><?=$page_url?></div><?endif?>
                <?=$content_top?>
                <hr class="dots" />
                <div class="article_list">
                    <h1><?=$article['title']?></h1>
                    <div class="content">
                        <div class="description" ><?=$article['description']?></div>
                        <div class="link">
                            <div class="rating" title="<?=$text['text_rating'].$article['rating']?>"><?=HTML::image('styles/'.$template."image/stars-".$article['rating'].".png", array('alt' => $article['title']))?></div>
                            <div class="cat"><?=$text['text_category']?> <?=$article['categories']?></div>
                            <div class="more"><a href="javascript:history.go(-1)" class="button"><?=$text['text_all']?></a></div>
                            <div class="info">
                                <? if ($mode && $article['status_comment']):?><div class="colcom" title="<?=$text['text_comment_count'].count($comments)?>"><?=count($comments)?></div><?endif?>
                                <div class="views" title="<?=$text['text_viewed'].$article['viewed']?>"><?=$article['viewed']?></div>
                                <div class="author" title="<?=$text['text_author'].$article['author']?>"><?=$article['author']?></div>
                                <div class="date" title="<?=$text['text_date'].date("d F Y",$article['date_modified'])?>"><?=date("d F Y",$article['date_modified'])?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <? if ($mode && $article['status_comment']):?>
                    <? if (count($comments)>=0):?>
                        <div id="comment-post">
                            <div id="head"><h2><?=$text['text_comments']?></h2></div>
                            <?if($auth || $guest):?><div id="btn"><?=HTML::anchor("",$text['text_comment_add'], array('class' => 'button', 'onclick' => "$('#addcform').toggle(1000).focus();return false;"))?></div><?endif?>
                            <div class="clr"></div>
                        </div>
                    <?endif?>
                    <?if($auth || $guest):?>
                        <?=Form::open(null, array("id" => "comment-form-add"))?>
                        <div id="addcform" style="display:none">
                            <table class="form">
                                <? if ($guest && !$auth):?>
                                    <tr>
                                        <td><span class="required">* </span><?=$text['text_name']?></td>
                                        <td><?=Form::input('author', "")?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><span class="required">* </span><?=$text['text_email']?></td>
                                        <td><?=Form::input('email', "")?></td>
                                        <td></td>
                                    </tr>
                                <?endif?>
                                <tr>
                                    <td><span class="required">* </span><?=$text['text_comment']?></td>
                                    <td><?=Form::textarea('editoradd', "")?></td>
                                    <td><?=Form::button('comment',$text['button_add'])?></td>
                                </tr>
                                <tr>
                                    <td><?=$text['rating']?></td>
                                    <td>
                                        <?=$text['rating_bad']?>
                                        <?=Form::radio('rating', 1, false);?>
                                        <?=Form::radio('rating', 2, false);?>
                                        <?=Form::radio('rating', 3, false);?>
                                        <?=Form::radio('rating', 4, false);?>
                                        <?=Form::radio('rating', 5, false);?>
                                        <?=$text['rating_good']?>
                                    </td>
                                </tr>
                                <? if ($guest && !$auth):?>
                                    <tr>
                                        <td><span class="required">* </span><?=$text['text_captcha']?></td>
                                        <td>
                                            <?=Form::input('captcha', "", array('size' => 13))?><br />
                                            <?=$captcha?> 
                                            <?=HTML::image('styles/'.$template . 'image/update.png', Array('onclick' =>'reload()'))?>
                                        </td>
                                        <td></td>
                                    </tr>
                                <?endif?>
                            </table>
                            <script>
                                $(function(){
                                    CKEDITOR.replace( 'editoradd', {language: '<?=$lang?>'});
                                });
                            </script>
                        </div>
                        <?=Form::hidden('article_id', $article['id']);?>
                        <?=Form::hidden('user_id', $user);?>
                        <?=Form::close()?>
                    <?endif?>
                    <? if (count($comments)>=0):?>
                        <?php $i=$pagination->offset + 1;?>
                        <?=Form::open(null, array("id" => "comment-form-edit"))?>
                        <div id="comment-list">
                            <a name="comment"></a>
                            <?foreach($comments as $comment):?>
                                <div id="comment-id-<?=$comment->id?>">
                                    <div class="panel">
                                        <div class="avatar">
                                            <? if ($comment->user_id && $users[$comment->user_id]['ava']):?>
                                                <?=HTML::image(HTTP_IMAGE.$users[$comment->user_id]['ava'], array('alt' => $users[$comment->user_id]['username']))?>
                                            <?else:?>
                                                <?=HTML::image(HTTP_IMAGE.'no_ava.jpg', array('alt' => 'no avatar'))?>
                                            <?endif?>
                                        </div>
                                        <div class="author"><h3><?=$comment->author?></h3></div>
                                        <div class="dmid"><?=date("d F Y H:i",strtotime($comment->date_modified))?></div>
                                        <div class="number">#<?=$i?></div>
                                        <?if($user == $comment->user_id && $comment->status && $user):?>
                                            <div class="remove"><?=HTML::image('styles/'.$template.'image/remove.png', array('alt' => 'remove','onclick' => "commentRemove($comment->id)"))?></div>
                                            <div class="edit"><?=HTML::image('styles/'.$template.'image/edit.png', array('alt' => 'edit','onclick' => "commentEdit($comment->id)"))?></div>
                                        <?endif?>
                                    </div>
                                    <div class="content">
                                        <div class="description">
                                            <?if($comment->status):?>
                                                <?=$comment->text?>
                                            <?else:?>
                                                <?=$text['moderation']?>
                                            <?endif?>
                                        </div>
                                        <div class="info">
                                            <?=Form::hidden('offset_id', $i);?>
                                            <?=Form::hidden('user_id', $comment->user_id);?>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++;?>
                            <?endforeach?>
                        </div>
                        <?=Form::close()?>
                        <?=$pagination?>
                    <?endif?>
                <?endif?>
                <?=$content_bottom?>
            </div>
            <?=$footer?>
        </div>
    </div>
</div>
<? if ($mode && $article['status_comment']):?>
<script type="text/javascript"><!--
        $(function(){
            $('#comment-form-edit').submit(function() {
                doCommentEdit();
                return false;
            });

            $('#comment-form-add').submit(function() {
                doCommentAdd();
                return false;
            });
        });

        function reload(){
            id=Math.floor(Math.random()*1000000);
            $("img.captcha").attr("src","/captcha/default?id="+id);
        }
//--></script>
<script type="text/javascript"><!--
        function doCommentAdd(){
            var author = encodeURIComponent($('#comment-form-add input[name=\'author\']').val());
            var email = encodeURIComponent($('#comment-form-add input[name=\'email\']').val());
            var comment = encodeURIComponent(CKEDITOR.instances.editoradd.getData());
            var article_id = encodeURIComponent($('#comment-form-add input[name=\'article_id\']').val());
            var user_id = encodeURIComponent($('#comment-form-add input[name=\'user_id\']').val());
            var rating = encodeURIComponent($('#comment-form-add input[name=\'rating\']:checked').val());
            var captcha = encodeURIComponent($('#comment-form-add input[name=\'captcha\']').val());
            var offset = encodeURIComponent($('#comment-list input[name=\'offset_id\']:last').val());

            if(offset != 'undefined') offset++;
            else offset = 1;

            var height = $("#comment-list").height() + $('.article_list').height();

            $.ajax({
                url: '/comments/add',
                type: 'post',
                data: 'comment=' + comment + '&article_id=' + article_id + '&rating=' + rating + '&author=' + author + '&email=' + email + '&captcha=' + captcha + '&user_id=' + user_id,
                dataType: 'json',
                beforeSend: function() {
                    ShowLoading('<?=$text['loading']?>');
                },
                complete: function() {
                    HideLoading();
                },
                success: function(json) {
                    if (json) {
                        if (json.errors) {
                            if(json.errors.text)
                                ShowMessage(json.errors.text);
                            else if(json.errors.email)
                                ShowMessage(json.errors.email);
                            else if(json.errors.author)
                                ShowMessage(json.errors.author);
                            else if(json.errors.captcha)
                                ShowMessage(json.errors.captcha);
                        }
                        else{
                            html =  '<div id="comment-id-' + json.id + '" style="display:none">';
                            html += '<div class="panel">';
                            html += '<div class="avatar"><img src="' + json.ava + '" alt="' + json.author + '" /></div>';
                            html += '<div class="author"><h3>' + json.author + '</h3></div>';
                            html += '<div class="dmid">' + json.date + '</div>';
                            html += '<div class="number">#'+ offset +'</div>';
                            html += '</div>';
                            html += '<div class="content">';
                            html += '<div class="description">'+ json.text +'</div>';
                            html += '<div class="info"><input type="hidden" name="offset_id" value="'+ offset +'"><input type="hidden" name="user_id" value="'+ json.user_id +'"></div>';
                            html += '</div>';
                            html += '</div>';

                            $('#addcform').toggle(1000);
                            $("html, body").stop().animate({scrollTop: height},1100);
                            if(offset==1)
                                $('#comment-list > a').after(html);
                            else
                                $('#comment-list div[id^=\'comment-id-\']:last').after(html);

                            setTimeout(function(){$('#comment-list div[id=\'comment-id-'+ json.id +'\']').show("blind",{},1500)},1100);
                            CKEDITOR.instances.editoradd.setData("");
                        }

                    }

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
//--></script>
<script type="text/javascript"><!--
        function commentEdit(id){
            var identific = $("#divEdit input[name=\'cid\']").val();

            if(identific == undefined)
            {
                var obj = $('#comment-list div[id=\'comment-id-' + id + '\'] .description');
                text = obj.html();
                obj.html("");
                html  = '<div id="divEdit" style="display: none;">';
                html += '<textarea name="editoredit" cols="50" rows="10" >'+text+'</textarea>';
                html += '<button name="submit"><?=$text['button_edit']?></button><input type="button" value="<?=$text['button_abort']?>" name="cancel" onclick="commentCancel(\''+id+'\'); return false;" >';
                html += '<input type="hidden" name="cid" value="'+id+'" />';
                html += '</div>';
                $('#comment-list div[id=\'comment-id-' + id + '\'] .description').html(html);
                CKEDITOR.replace( 'editoredit', {language: '<?=$lang?>'});
                $("html, body").stop();
                $('#divEdit').slideDown(500);
            }
            else if(id == identific){
                commentCancel(id);
            }
        }

        function doCommentEdit(){
            var comment = encodeURIComponent(CKEDITOR.instances.editoredit.getData());
            var id = encodeURIComponent($("#divEdit input[name=\'cid\']").val());
            $.ajax({
                url: '/comments/edit',
                type: 'post',
                data: 'comment=' + comment + '&comment_id=' + id,
                dataType: 'json',
                beforeSend: function() {
                    ShowLoading('<?=$text['loading']?>');
                },
                complete: function() {
                    HideLoading();
                },
                success: function(json) {
                    if (json) {
                        if (json.errors) {
                            ShowMessage(json.errors.text);
                        }
                        else{
                            CKEDITOR.remove('editoredit');
                            $('#divEdit, #comment-list div[id=\'comment-id-' + id + '\'] .edit, #comment-list div[id=\'comment-id-' + id + '\'] .remove').remove();

                            $('#comment-list div[id=\'comment-id-' + id + '\'] .description').html(json.text);
                            $('#comment-list div[id=\'comment-id-' + id + '\'] .dmid').html(json.date);
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }

        function commentCancel(id){
            CKEDITOR.remove('editoredit');
            $('#divEdit').remove();
            var obj = $('#comment-list div[id=\'comment-id-' + id + '\'] .description');
            obj.html(text);
        }

//--></script>
<script type="text/javascript"><!--
        function commentRemove(id){
            var message = confirm("<?=$text['confirm_delete']?>");
            if(message){
                $.ajax({
                    url: '/comments/remove',
                    type: 'post',
                    data: 'comment_id=' + id,
                    dataType: 'json',
                    success: function(json) {
                        if (json.id == id) {
                            $("html, body").stop();
                            $('#comment-list div[id=\'comment-id-' + id + '\']').slideUp(500);
                            setTimeout(function(){$('#comment-list div[id=\'comment-id-' + id + '\']').remove(); },1100);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        }
//--></script>
<?endif?>
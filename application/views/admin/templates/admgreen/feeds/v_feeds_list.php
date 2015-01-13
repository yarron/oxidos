<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-transfer"></i>
            <span><?=$box_title?></span>
        </div>
        <div class="panel-body">
            <?if($message):?>
                <div class="alert alert-success" role="alert">
                    <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
                    <span class="sr-only">Success:</span>
                    <?=$message?>
                </div>
            <?endif?>
            <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr >
                        <td><span class="btn"><?=$text['column_name']?></span></td>
                        <td><span class="btn"><?=$text['column_action']?></span></td>
                        <td align="center" style="width: 50px;"><span class="btn"><?=$text['column_status']?></span></td>
                    </tr>
                </thead>
                <tbody>
                    <?if(count($feeds) > 0):?>
                        <? foreach ($feeds as $feed):?>
                        <tr>
                            <td><?=$feed['name']?></td>
                            <td><?=Html::anchor('admin/feeds/'.$feed['action'], '<i class="glyphicon glyphicon-edit"></i>', array('class'=>'btn btn-primary btn-xs','data-toggle'=>"tooltip", 'title'=>$text['text_edit']));?></td>
                            <td align="center">
                                <?if($feed['status'] == 0):?>
                                    <i class="glyphicon glyphicon-remove btn-danger btn-xs"></i>
                                <?else:?>
                                    <i class="glyphicon glyphicon-ok btn-success btn-xs"></i>
                                <?endif?>
                            </td>
                        </tr>
                        <? endforeach?>
                    <?else:?><tr><td colspan="3" ><p align="center"><?=$text['message_no']?></p></td></tr><?endif?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<script><!--
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
//--></script>
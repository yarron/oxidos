<div class="col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="glyphicon glyphicon-stats"></i><span><?=$text['synopsis']?></span></div>
        <div class="panel-body">
            <ul class="list-group">
                <li class="list-group-item"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;<span class="badge"><?=$overview['users']?></span><?=$text['overview_users']?></li>
                <li class="list-group-item"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;<span class="badge"><?=$overview['categories']?></span><?=$text['overview_categories']?></li>
                <li class="list-group-item"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;&nbsp;<span class="badge"><?=$overview['news']?></span><?=$text['overview_news']?></li>
                <li class="list-group-item"><i class="glyphicon glyphicon-th-list"></i>&nbsp;&nbsp;<span class="badge"><?=$overview['articles']?></span><?=$text['overview_articles']?></li>
                <li class="list-group-item"><i class="glyphicon glyphicon-file"></i>&nbsp;&nbsp;<span class="badge"><?=$overview['pages']?></span><?=$text['overview_pages']?></li>
                <li class="list-group-item"><i class="glyphicon glyphicon-comment"></i>&nbsp;&nbsp;<span class="badge"><?=$overview['all_comments']?></span><?=$text['overview_all_comments']?></li>
                <li class="list-group-item"><i class="glyphicon glyphicon-comment"></i>&nbsp;&nbsp;<span class="badge"><?=$overview['comments']?></span><?=$text['overview_comments']?></li>
                <li class="list-group-item"><i class="glyphicon glyphicon-lock"></i>&nbsp;&nbsp;<span class="badge"><?=$overview['banned']?></span><?=$text['overview_banned']?></li>
            </ul>
        </div>
    </div>
</div>
<div class="col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="glyphicon glyphicon-signal"></i><span><?=$text['statistic']?></span></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3"><i class="glyphicon glyphicon-eye-open"></i> <span><?=$text['entry_range']?></span></div>
                <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                    <select id="range"  class="form-control">
                        <option value="week"><?=$text['text_week']?></option>
                        <option value="month"><?=$text['text_month']?></option>
                        <option value="halfyear"><?=$text['text_halfyear']?></option>
                    </select>
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3"><button id="sync" type="button" class="btn btn-default" data-loading-text="<?=$text['button_loading']?>" autocomplete="off"><?=$text['button_update']?></button></div>
                <br /><br />
            </div>
            <div class="row">
                <div style="overflow: auto" class="col-sm-12 col-md-12 col-lg-12">
                    <div id="report"></div>
                    <div id="date"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--[if lte IE 8]><script src="/styles/admin/bower_components/flot/excanvas.min.js"></script><![endif]-->
<script src="/styles/admin/bower_components/flot/jquery.flot.js"></script>
<script src="/styles/admin/bower_components/flot/jquery.flot.resize.js"></script>
<script><?=$statistic?></script>
<script><!--
$(function() {
    $('#sync').on('click', function () {
        getSalesChart("sync");
        $('#range option:first-child').attr("selected", true);
    });
    $('#range').on('change', function () {
        getSalesChart($(this).val());
    });

    function getSalesChart(range) {
        $.ajax({
            type: 'GET',
            url: '/admin/main/chart/' + range,
            dataType: 'json',
            beforeSend: function(){$('#date').html('');$("#sync").button('loading');},
            error: function(XMLHttpRequest, textStatus) {$('#date').html("<div class='alert alert-danger' role='alert'><i class='glyphicon glyphicon-remove-circle'></i>  <?=$text['error_stat']?></div>");},
            success: function(json) {
                if(json.error) $('#date').html("<div class='alert alert-warning' role='alert'><i class='glyphicon glyphicon-warning-sign'></i>  <?=$text['error_stat']?></div>");
                else{
                    var option = {
                        shadowSize: 0,
                        colors: ['#c7ffa0', '#11b500'],
                        bars: {
                            show: true,
                            fill: true,
                            lineWidth: 1
                        },
                        grid: {
                            backgroundColor: '#FFFFFF',
                            hoverable: true
                        },
                        points: {
                            show: false
                        },
                        xaxis: {show: true,ticks: json.xaxis}
                    }
                    $('#date').html("<div class='alert alert-success' role='alert'><i class='glyphicon glyphicon-ok'></i>  "+json.date+"</div>");
                    $('#report').css('height', '167px');
                    $.plot($('#report'), [json.pageviews, json.visits], option);
                    $('#report').bind('plothover', function(event, pos, item) {
                        $('.tooltip').remove();

                        if (item) {
                            $('<div id="tooltip" class="tooltip top in"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + item.datapoint[1].toFixed(2) + '</div></div>').prependTo('body');

                            $('#tooltip').css({
                                position: 'absolute',
                                left: item.pageX - ($('#tooltip').outerWidth() / 2),
                                top: item.pageY - $('#tooltip').outerHeight(),
                                pointer: 'cusror'
                            }).fadeIn('slow');

                            $('#chart-sale').css('cursor', 'pointer');
                        } else {
                            $('#chart-sale').css('cursor', 'auto');
                        }
                    });
                }
            },
            complete: function(){$("#sync").button('reset');}
        });
    }
    getSalesChart($('#range').val());

});
//--></script> 
  

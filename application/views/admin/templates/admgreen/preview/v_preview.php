<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><?=$title?></h4>
            </div>
            <div class="modal-body">
                <link type="text/css" href="/styles/<?=$template?>stylesheet/preview.css" rel="stylesheet" />
                <div id="review-body">
                    <div id="review-container">
                        <div id="review-wrap">
                            <div id="review-sub-wrap">
                                <div id="review-content">
                                    <hr class="review-dots" />
                                    <h1><?=$data['title']?></h1>
                                    <div class="review-content">
                                        <div class="review-description" ><?=$data['description']?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal"><?=$close?></button></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
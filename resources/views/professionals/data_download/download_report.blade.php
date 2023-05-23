<div id="download_report" class="row justify-content-center" style="display:none;">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 card p-4" >
        <div class="row justify-content-center">
            <div class="col-12 text-center mb-4">
                <h4 class="h4">@lang('pg_professionals.DOWNLOAD_REPORT')</h4>
            </div>    
            <div class="col-12">
                <div class="progress">
                    <div id="success_rate_pb" class="progress-bar bg-success" role="progressbar"  aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">Succeeded</div>
                    <div id="fail_rate_pb" class="progress-bar bg-danger" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Failed</div>    
                </div>
            </div>
            <div class="col-12 mt-4 text-center">
                <span>@lang('pg_professionals.DOWNLOADED_LBL')<span id="success_total_lbl"></span>@lang('pg_professionals.OUT_OF_LBL')<span id="total_buckets_lbl"></span>@lang('pg_professionals.RECORDS_LBL')</span>
            </div>
            <div class="col-12 my-4">
                <span class="font-weight-light vtext-dark-gray">@lang('pg_professionals.DATA_LOSS_DESC')</span>
            </div>
            <div class="col-3 mt-2 text-center">
                <button id="dd_retry" type="button" onclick="downloadData()" class="btn btn-sm vbtn-main">@lang('pg_professionals.RETRY')</button>
            </div>
            <div class="col-3 mt-2 text-center">
                <button id="dd_button" type="button" onclick="goToDownloadView()" class="btn btn-sm vbtn-main">@lang('pg_professionals.FINISH')</button>
            </div>
            
        </div>
        
    </div>
    
</div>
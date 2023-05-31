@extends('layout.forms')

@section('content')


<!-- BEGIN SIDEBAR CONTENT LAYOUT -->

<!-- END BREADCRUMBS -->
<div class="page-content-wrapper">
    <div class="page-content">
        <br><br><br><br>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <i class="fa fa-user"></i> Error <small>Logs</small>
                </h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="fa fa-user font-dark"></i>
                            <span class="caption-subject bold uppercase">Records</span>
                        </div>
                        <div class="tools"> </div>
                    </div>
                    <form action="" method="get">
                        <div class="actions">
                            <div class="form-group form-inline" style="display:inline;margin-right:10px">
                                <label class="control-label">Date From</label>


                                <div class="input-group input-medium date date-picker" data-date="{{ today() }}" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                                    <input type="date" name="dateFrom" id="dateFrom" class="form-control">
                                    <!-- <span class="input-group-btn">
                                <button class="btn default" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span> -->
                                </div>
                                <label class="control-label">Date To</label>

                                <div class="input-group input-medium date date-picker" data-date="{{ today() }}" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                                    <input type="date" name="dateTo" id="dateTo" class="form-control">
                                    <!-- <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span> -->
                                </div>
                                <input type="submit" name="filter_submit" class="btn btn-success" value="Filter" />
                            </div>
                    </form>
                    <div class="portlet-body">
                        <br>
                        <table class="table table-striped table-hover" id="sample_101">
                            <thead>
                                <tr>
                                    <th style="width: 10%">ID</th>
                                    <th style="width: 20%">Message</th>
                                    <th style="width: 8%">Level</th>
                                    <th style="width: 8%">Level Name</th>
                                    <th style="width: 10%">DateTime</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($error_list as $error)
                                <tr>
                                    <td style="width: 10%">{{ $error->id }}</td>
                                    <td style="width: 20%">{{ $error->message }}</td>
                                    <td style="width: 8%">{{ $error->level }}</td>
                                    <td style="width: 10%">{{ $error->level_name  }}</td>
                                    <td style="width: 10%">{{ $error->datetime  }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE BASE CONTENT -->
    </div>
</div>
<!-- END SIDEBAR CONTENT LAYOUT -->
@endsection


@push('javascript')
<script type="text/javascript">
    function getReportDetails() {
        const dateFrom = urlParams.get('dateFrom')
        const dateTo = urlParams.get('dateTo')
        var userid = urlParams.get('userid')
        if (userid == null) {
            userid = 0
        }
        $('#dateFrom').val(dateFrom);
        $('#dateTo').val(dateTo);
        $('#userid').val(userid);

    }
    $(function() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);

        const dateFrom = urlParams.get('dateFrom')
        const dateTo = urlParams.get('dateTo')
        var userid = urlParams.get('userid')
        if (userid == null) {
            userid = 0
        }
        $('#dateFrom').val(dateFrom);
        $('#dateTo').val(dateTo);
        $('#userid').val(userid);
    });
</script>
@endpush
@extends('layouts.utilization')

@section('content')
<div class="clearfix"></div>
   <div class="page-container">
      <!-- BEGIN CONTENT -->
      <div class="page-content-wrapper">
         <div class="page-content">
            <div class="row">
               <div class="col-md-12">
                  <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                  <div class="breadcrumbs">
                    <h3><i class="fa fa-truck"></i> VEHICLE REQUEST</h3>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/"><i class="fa fa-home"></i> HOME</a>
                        </li>
                        <li>
                            <a href="{{ route('vehicle.request.list') }}"><i class="fa fa-list"></i> REQUEST LIST</a>
                        </li>
                        <li class="active"><i class="fa fa-edit"></i> TICKET CREATION</li>
                    </ol>
                  </div>
               </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
               <div style="margin-left:150px;" class="col-md-10">

                         <div class="alert alert-success alert-dismissable">
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                 <span class="fa fa-check-square-o"></span><b> Success :</b> <?php echo $successMSG; ?>
                         </div>


                        <div class="alert alert-danger alert-dismissable">
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                             <span class="fa fa-exclamation"></span><b> Error :</b> <?php echo $errorMSG; ?>
                         </div>
                  <!-- BEGIN SAMPLE FORM PORTLET-->
                  <div class="portlet light bordered">
                     <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                           <i class="fa fa-truck font-red-sunglo"></i>
                           <span class="caption-subject uppercase"> <?= $r['tripTicket']; ?> Details</span><br>&nbsp;&nbsp;&nbsp;
                           <span style="font-size: 17px;color:black;" >Status: <?= $r['Status']; ?></span>
                        </div>   

                        <div style="float:right;">
                           <a  class="btn yellow" href="dispatch_printout.php?id=<?php echo urlencode($_GET['id']); ?> "target="_blank">
                              <i class="fa fa-print"></i> Print
                           </a>

                           <a style="display:<?= $cancelled; ?>" class="btn blue" href="dispatch_edit.php?id=<?php echo urlencode($_GET['id']); ?> "><i class="fa fa-edit"></i> Edit/Update</a>
                           <a style="display:<?= $cancelled; ?>" data-toggle='modal' class='btn red' href='#cancel-<?php echo $_GET['id']; ?>'><span class='glyphicon glyphicon-remove-circle'></span> Cancel</a>

                           

                           <div class="modal fade" id="cancel-<?php echo $_GET['id']; ?>" tabindex="-1" role="basic" aria-hidden="true">
                              <div class="modal-dialog">
                                 <form action="" method="POST">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <input type="hidden" name="tid" value="<?php echo $_GET['id']; ?>">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                          <h4 class="modal-title"><b>Confirmation</b></h4>
                                       </div>
                                          <div class="modal-body"> Are you sure you want to <b>Cancel</b> this Trip Ticket? </div>
                                       <div class="modal-footer">
                                          <button type="button" class="btn btn-circle dark btn-outline" data-dismiss="modal"><i class="fa fa-backward"></i> Back</button>
                                          <button type="submit" name="cancel_tid" class="btn btn-circle blue"><span class="glyphicon glyphicon-remove-circle"></span> Confirm Cancel</button>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="portlet-body">
                        <div class="tab-content">
                           <!-- PERSONAL INFO TAB -->
                           <div class="tab-pane active">
                              <div class="row">
                                 <div class="form-group col-md-12">

                                    <div class="col-md-3">
                                       <label class="control-label">Date Out</label>
                                       <div class="input-group date form_datetime col-md-12" data-date="" data-date-format="yyyy-mm-dd HH:ii p" data-link-field="date_out">
                                          <div class="input-icon">
                                             <i class="fa fa-calendar font-yellow"></i>
                                             <input class="form-control" size="16" type="text" value="<?= $r['dateStart']->format('Y-m-d h:i:s'); ?>" readonly>
                                          </div>
                                          <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                          <input type="hidden" name="date_out" id="date_out" value="<?= $r['dateStart']->format('Y-m-d h:i:s'); ?>" />
                                       </div>
                                    </div>

                                    <div class="col-md-3">
                                       <label class="control-label">Department</label>
                                       <div class="input-icon">
                                          <i class="fa fa-building-o font-yellow"></i>
                                          <input readonly type="text" class="form-control" value="<?= $r['deptId']; ?>" >
                                       </div>
                                    </div>

                                    <div class="col-md-3">
                                       <label class="control-label">Vehicle</label>     
                                       <input readonly class="form-control" type="text" value="<?= $r['type']; ?>">
                                    </div>

                                    <div class="col-md-3">
                                       <label class="control-label">Trip & Ticket No.</label>
                                       <input type="text" class="form-control" value="<?= $r['tripTicket']; ?>" readonly>
                                    </div>
                                 </div>

                                 <div class="form-group col-md-12">
                                    <div class="col-md-3">
                                       <label class="control-label">Application Date</label>
                                       <div class="input-group date form_datetime col-md-12" data-date="" data-date-format="yyyy-mm-dd HH:ii p" data-link-field="dt_from">
                                          <div class="input-icon">
                                             <i class="fa fa-calendar font-yellow"></i>
                                             <input class="form-control" size="16" type="text" value="<?= $r['addedDate']->format('Y-m-d h:i:s'); ?>" readonly>
                                          </div>
                                          <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                          <input type="hidden" name="app_date" id="dt_from" value="<?= $r['addedDate']->format('Y-m-d h:i:s'); ?>" />
                                       </div>
                                    </div>

                                    <div class="col-md-3">
                                       <label class="control-label">Driver</label>
                                       <input readonly type="text" class="form-control" value="<?php echo $driver['driver_name'];?>">

                                    </div>

                                    <div class="col-md-3">
                                       <label class="control-label">From</label>
                                       <div class="input-icon">
                                          <i class="fa fa-globe font-yellow"></i>
                                          <input readonly type="text" class="form-control" value="<?= strtoupper($origin); ?>"> 
                                       </div>
                                    </div>

                                    <div class="col-md-3">
                                       <label class="control-label">To</label>
                                       <div class="input-icon">
                                          <i class="fa fa-globe font-yellow"></i>
                                          <input readonly type="text" class="form-control" value="<?= strtoupper($destination); ?>"> 
                                       </div>
                                    </div>
                                 </div>

                                 <div class="form-group col-md-12">
                                    <div class="col-md-12">
                                       <label class="control-label">Purpose</label>
                                       <div class="input-icon">
                                          <i class="fa fa-comment-o font-yellow"></i>
                                          <textarea readonly class="form-control"><?php echo strtoupper($r['purpose']); ?></textarea>
                                       </div>

                                    </div>
                                 </div>

                                 <div class="form-group col-md-12">
                                    <div class="col-md-12">
                                       <div class="form-group multiple-form-group">
                                          <label>Passengers</label>
                                          <?php 
                                          $ex =  explode('|',$r['passengers']);
                                          
                                          echo '<ul class="list-inline">';
                                          foreach($ex as $pass) {
                                             echo '<li><input readonly class="form-control" type="text" value="'.$pass.'" /></li>';
                                          }
                                          echo '</ul>';
                                          ?>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="form-group col-md-12">
                                    <div class="caption font-red-sunglo">
                                       <i class="fa fa-automobile font-red-sunglo"></i>
                                       <span class="caption-subject bold uppercase" style="font-size: 16px;"> Return Slip Form</span>
                                    </div>
                                    <hr>
                                 </div>

                                 <div class="form-group col-md-12">
                                    <div class="col-md-3">
                                       <label class="control-label">Date Return</label>
                                       <div class="input-group date form_datetime col-md-12" data-date="" data-date-format="yyyy-mm-dd HH:ii p" data-link-field="date_return">
                                          <div class="input-icon">
                                             <i class="fa fa-calendar font-yellow"></i>
                                             <input class="form-control" size="16" type="text" value="<?= $r['odometer_end']; ?>" readonly>
                                          </div>
                                          <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                          <input type="hidden" name="date_return" id="date_return" value="" />
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <label class="control-label">Odometer End</label>
                                       <div class="input-icon">
                                          <i class="fa fa-tachometer font-yellow"></i>
                                          <input readonly type="number" step="any" class="form-control" required min="0.00001" value="<?= $r['odometer_end']; ?>">
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <label class="control-label">Fuel Type</label>
                                       <input readonly class="form-control" type="text" value="<?= strtoupper($r['fuel_added_type']); ?>">
                                    </div>
                                 </div>

                                 <div class="form-group col-md-12">
                                    <div class="col-md-3">
                                       <label class="control-label">Fuel Requested Qty</label>
                                       <div class="input-icon">
                                          <i class="fa fa-fire font-yellow"></i>
                                          <input readonly type="number" class="form-control" value="<?= $r['fuel_requested_qty']; ?>">
                                       </div>
                                    </div>

                                    <div class="col-md-3">
                                       <label class="control-label">Actual Qty</label>
                                       <input readonly class="form-control" type="text" value="<?= strtoupper($r['fuel_added_qty']); ?>">
                                    </div>

                                    <div class="col-md-3">
                                       <label class="control-label">UOM</label>
                                       <div class="input-icon">
                                          <i class="icon-calculator font-yellow"></i>
                                          <input readonly type="text" class="form-control" value="<?= $r['uom']; ?>">
                                       </div>
                                    </div>
                                    <div style="margin-top: 180px;"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- END SAMPLE FORM PORTLET-->                                                                              
                  </div>
                  <div class="clearfix"></div>
               </div>
            </div>
            <!-- END CONTENT -->
         </div>
         <!-- END CONTAINER -->
         <!-- BEGIN FOOTER -->
         <div class="page-footer">
            <div class="page-footer-inner">
               <?php echo date('Y'); ?> &copy; PMC
            </div>
            <div class="page-footer-tools">
               <span class="go-top">
                  <i class="fa fa-angle-up"></i>
               </span>
            </div>
         </div>

      </div>
    </div>
@endsection
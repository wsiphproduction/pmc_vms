@extends('layout.home')
@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-12">
                
                <div style="width: 550px; display: block; margin: 100px auto 0; background: #696969; padding: 30px;">
                   
                        <form method="POST" action="{{ route('updatePassword') }}" role="form">
                            @csrf 
                            @method('PATCH')
       
                             @foreach ($errors->all() as $error)
                                <p class="text-warning">{{ $error }}</p>
                             @endforeach 

                             @if(session()->has('error_message')) 

                                <p class="text-warning">{{ session()->get('error_message') }}</p>
                            
                             @endif

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right" 
                                    style="color: #ffffff;">Current Password</label>
      
                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
                                </div>
                            </div>
      
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right" 
                                    style="color: #ffffff;">New Password</label>
      
                                <div class="col-md-8">
                                    <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12 col-form-label text-md-center" >
                                    <label class="control-label"></label><i class="font-yellow" style="font-size: 14px;font-weight:bold;">(Min. 8, alphanumeric, at least 1 upper case, 1 number and 1 special character) </i>
                                </div>
                            </div>
      
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right" 
                                    style="color: #ffffff;">New Confirm Password</label>
        
                                <div class="col-md-8">
                                    <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                                </div>
                            </div>
       
                            <div class="form-group row mb-0 text-center">
                                <div class="col-md-12">
                                    @if($edit)
                                    <button type="submit" class="btn btn-primary">
                                        Update Password
                                    </button>
                                    @else
                                    <button disabled type="submit" class="btn btn-primary">
                                        Update Password
                                    </button>
                                    @endif
                                </div>
                            </div>

                        </form>

                        <a href="home" class="btn btn-default btn-success"> << Back </a>

                    </div>
                </div>
            </div>

        </div>
    
    </div>

@endsection


@push('javascript')

    <!-- BEGIN CORE PLUGINS -->


    <script src="{{ asset('metronic/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js ') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js ') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js ') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/plugins/jquery.blockui.min.js ') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/plugins/jquery.cokie.min.js ') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/plugins/uniform/jquery.uniform.min.js ') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js ') }}" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{ asset('metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/plugins/backstretch/jquery.backstretch.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/select2/select2.min.js') }}"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ asset('metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/admin/pages/scripts/login-soft.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
            jQuery(document).ready(function() {     
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                QuickSidebar.init() // init quick sidebar
                Login.init();

                // init background slide images
                $.backstretch([
                    "theme/metronic/assets/admin/pages/media/bg/6.jpg",
                    "theme/metronic/assets/admin/pages/media/bg/5.jpg",
                    "theme/metronic/assets/admin/pages/media/bg/3.jpg",
                    "theme/metronic/assets/admin/pages/media/bg/4.jpg"
                    ], {
                    fade: 1000,
                    duration: 8000
                    }
                );
            });
        </script>
    <!-- END JAVASCRIPTS -->
@endpush

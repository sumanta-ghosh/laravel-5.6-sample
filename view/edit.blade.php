@extends('admin.layouts.main')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="fa fa-edit"></i>
                    <span class="caption-subject bold uppercase">Service</span>
                </div>
            </div>
            <div class="portlet-body form">    
                <form id="form_edit_service_block" class="form-horizontal" role="form">
                    <input type="hidden" id='block_id' value="{{ $serviceBlock->id }}" name="id"/>
                    <div class="form-body"> 
                        <div class="form-group">
                            <label class="control-label col-md-2">Background color:</label>
                            <div class="col-md-4">
                                <div class="input-group color colorpicker-default" data-color="{{ $meta['section_background_color'] or '#fff'}}" data-color-format="rgba">
                                    <input type="text" class="form-control" name="section_background_color" value="{{ $meta['section_background_color']  or '#fff'}}">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i style="background-color: {{ $meta['section_background_color']  or '#fff'}};"></i>&nbsp;</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Block name:
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-10">
                                <input type="text" name="name" class="form-control" placeholder="" value="{{ $serviceBlock->name }}">
                            </div>
                        </div>
                        <!-- laravel component -->
                        @bannerImgGroup(['image'=>$meta['banner_image']]) @endtagImgGroup
                        <div class="form-group banner_content">
                            <label class="col-md-2 control-label">Banner content:
                            </label>
                            <div class="col-md-10">
                                <textarea  name="content" id="service_content" class="">{{ $meta['banner_content'] or ""}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Tab#1 title:
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-10">
                                <input type="text" name="tab1_title" class="form-control" placeholder="" value="{{ $meta['tab1_title'] or "" }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Tab#1:</label>
                            <div class="col-md-10">
                                <textarea  name="tab_1_content" id="tab_1" class="">{{ $meta['tab1_content'] or "" }}</textarea>
                            </div>
                        </div>
                    </div>  
                    <div class="form-actions">
                        <div class="row pull-right">
                            <a class="btn default" href="{{ url()->previous() }}">Cancel</a>
                            <button disabled id="btn_edit_service_block" type="submit" class="btn green mt-ladda-btn ladda-button" data-style="slide-left">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin_css_file')
<link href="{{ URL::asset('assets/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/plugins/bootstrap-colorpicker/css/colorpicker.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('plugin_js_file')
<script src="{{ URL::asset('assets/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}" type="text/javascript"></script>
@endpush

@push('script')
<script>
$(function () {
    $('#service_content').summernote({height: 100, fontNames: [
            'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New',
            'Helvetica Neue', 'Helvetica', 'Impact', 'Lucida Grande',
            'Tahoma', 'Times New Roman', 'Verdana', 'Garamond'
        ]});
    $('input[type=radio][name=has_attachment]').change(function () {
        if (this.value === 'yes') {
            $("#optional_attachment").slideDown();
        } else if (this.value === 'no') {
            $("#optional_attachment").slideUp();
        }
    });
    $('#btn_edit_service_block').on('click', function (e) {
        e.preventDefault();
        $("form#form_edit_service_block").submit();
    });
    $("body").on("submit", "#form_edit_service_block", function (e) {
        toastr.clear();
        var l = Ladda.create(document.querySelector('#btn_edit_service_block'));
        l.start();
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: '{{ route("service-block-update") }}',
            processData: false,
            contentType: false,
            data: formData, // serializes the form's elements.
            success: function (response)
            {
                if (response.status === 'success') {
                    toastr.success(response.message, "Success");
                } else {
                    toastr.error(response.message, "Error");
                }
            }
        }).always(function () {
            l.stop();
        });
    });
});
</script>
@endpush
/* ------------------------------------------------------------------------------
 *
 *  # Custom JS code
 *
 *  Place here all your custom js. Make sure it's loaded after app.js
 *
 * ---------------------------------------------------------------------------- */

// Setting datatable defaults
$.extend( $.fn.dataTable.defaults, {
    autoWidth: false,
    columnDefs: [{
        orderable: false,
        width: 100/*,
        targets: [ 5 ]*/
    }],
    dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
    language: {
        search: '<span>Filter:</span> _INPUT_',
        searchPlaceholder: 'Type to filter...',
        lengthMenu: '<span>Show:</span> _MENU_',
        paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
    }
});

$('.dataTables_length select').select2({
    minimumResultsForSearch: Infinity,
    dropdownAutoWidth: true,
    width: 'auto'
});

// Delect Record
$('#main-page-content').on('click','.modal-popup-delete',function () {
    var del_url = $(this).data('url');
    $('.modal-delete-confirm').attr('data-url',del_url);
    $('#modal_delete_warning').modal();
});

$('body').on('click','.modal-delete-confirm',function () {
    var del_url = $(this).attr('data-url');
    $.ajax({
        url: del_url,
        type: 'DELETE',  // user.destroy
        success: function(result) {
            $('#modal_delete_warning').modal("hide");
            new PNotify({
                title: 'Success',
                text: 'Record Deleted.',
                addclass: 'bg-success border-success'
            });
            window.dataGridTable.ajax.reload();
        }
    });
});

$('#main-page-content').on('click','.modal-popup-view',function () {
    var view_url = $(this).data('url');
    $.get({
        url:view_url,
        success:function (data) {
            var view_html = '';
            $.each(data,function(k,v){
                view_html +='<tr><td>'+k+'</td><th>'+v+'</th></tr>';
            });
            $('#modal-table-data').html(view_html);
            $('#modal_for_view').modal();
        }
    })
});


// Partner Status Update
$('#main-page-content').on('click','.modal-popup-update-partner-status',function () {
    $('.modal-update-partner-status-confirm').attr('data-url', $(this).data("status-url"));
    let partnerId = $(this).data('id')
    window.partnerId = partnerId;

    const token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
        url: $(this).data("url"),
        type: 'GET',
        data:{
            "_token": token,
        },
        success: function (data){
            if(data == 1){
                window.dataGridTable.ajax.reload();
            } else {
                $('.partner-content-list').html(data);
                $('#modal_update_partner_status_warning').modal();
            }
        }
    });
});

// Make partner in-active
$('body').on('click','.make-inactive',function () {
    var url = $(this).data('url');
    var id = partnerId;
    $.ajax({
        url: url,
        type: 'GET',
        data: {
            "id": id
        },
        success: function (data) {
            $('#modal_update_partner_status_warning').modal('hide');
            window.dataGridTable.ajax.reload();
        }
    });
});

//User status update
$('#main-page-content').on('click','.modal-popup-update-user-status',function () {
    var url = $(this).data('url');
    var status = $(this).data('status');
    $('.status-msg').html(status);
    $('.change_status_confirm').attr('data-url', url);
    $('#modal_update_user_status_warning').modal();
});

$('body').on('click','.change_status_confirm',function () {
    var url = $(this).attr('data-url');
    const token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
        url: url,
        type: 'GET',
        data: {
            "_token": token
        },
        success: function (data) {
            $('#modal_update_user_status_warning').modal('hide');
            window.dataGridTable.ajax.reload();
        }
    });
});

/* set greetings */
var now = new Date();
var hrs = now.getHours();
var msg = "";

if (hrs >  0) msg = "Mornin' Sunshine!"; // REALLY early
if (hrs >  6) msg = "Good morning";      // After 6am
if (hrs > 12) msg = "Good afternoon";    // After 12pm
if (hrs > 17) msg = "Good evening";      // After 5pm
if (hrs > 22) msg = "Go to bed!";        // After 10pm

$('#head_greeting').replaceWith(msg);
/* set greetings */

/* DateTimepicker */
$('.datetimepicker').on('click', function (e) {
    $('.datetimepicker').AnyTime_noPicker().AnyTime_picker().focus();
    e.preventDefault();
});
/* DateTimepicker */
/* Datepicker */
$('.datepicker').on('click', function (e) {
    $('.datepicker').pickadate({
        format: 'yyyy-mm-dd'
    });
    e.preventDefault();
});
/* Datepicker */

$(document).ready(function() {
    tinymce.init({
        selector: 'textarea.tinymce-editor',
        height: 500,
        entity_encoding: "raw",
        menubar: false,
        plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount',
        ],
        toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor image | alignleft aligncenter  | ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',

        setup: function(editor){
            editor.on('ExecCommand', function (e) {
            });
        },
        /* and here's our custom image picker*/
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function () {
            var file = this.files[0];

            var reader = new FileReader();
            reader.onload = function () {

                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);


                cb(blobInfo.blobUri(), { title: file.name });
            };
            reader.readAsDataURL(file);
            };

            input.click();
        },

        content_css: '//www.tiny.cloud/css/codepen.min.css'
    });

    var mediaType = '';
    tinymce.init({
        selector: 'textarea.tinymce-editor-custom',
        height: 500,
        menubar: false,
        plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount',
        'media'
        ],
        toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor image | alignleft aligncenter  | ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help | ' + 'media',

        video_template_callback: function(data) {
            if(mediaType.includes("audio/")) {
                   return '<audio controls>' + '\n<source src="' + data.source + '"' + (data.sourcemime ? ' type="' + data.sourcemime + '"' : '') + ' />\n' + (data.altsource ? '<source src="' + data.altsource + '"' + (data.altsourcemime ? ' type="' + data.altsourcemime + '"' : '') + ' />\n' : '') + '</audio>';
            }else{
                return '<video width="' + data.width + '" height="' + data.height + '"' + (data.poster ? ' poster="' + data.poster + '"' : '') + ' controls="controls">\n' + '<source src="' + data.source + '"' + (data.sourcemime ? ' type="' + data.sourcemime + '"' : '') + ' />\n' + (data.altsource ? '<source src="' + data.altsource + '"' + (data.altsourcemime ? ' type="' + data.altsourcemime + '"' : '') + ' />\n' : '') + '</video>';
            }
        },
        setup: function(editor){
            editor.on('ExecCommand', function (e) {
            });
          },
        /* and here's our custom image picker*/
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*,video/*');

            input.onchange = function () {
                var file = this.files[0];

                var reader = new FileReader();

                const token = $("meta[name='csrf-token']").attr("content");
                let formData = new FormData();
                formData.append('file', file);
                $('.lds-dual-ring-full').removeClass('hidden');
                $.ajax({
                    url: tinymceUploadFileUrl,
                    type: 'POST',
                    cache:false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (data){
                        fileType = data.type;
                        $('.tox-button').trigger('click');
                        if(fileType.includes('video')){
                            var content = '<video width="300" height="150" controls="controls">\n' + '<source src="' + data.name + '" type="' + fileType + '"/>\n' + (data.name ? '<source src="' + data.name + '" type="' + fileType + '"/>\n' : '') + '</video>';
                        }else if(fileType.includes('audio')){
                            var content = '<audio controls> <source src="'+ data.name +'" type="'+ fileType +'"> <source src="' + data.name +'" type="' + fileType+ '"></audio> ';
                        }else{
                            var content = '<img width="300" height="150"  src="' + data.name + '" />';
                        }
                        tinymce.activeEditor.execCommand('mceInsertContent', false, content);
                        $('.lds-dual-ring-full').addClass('hidden');
                    }

                });
            };

        input.click();
        },

        content_css: '//www.tiny.cloud/css/codepen.min.css'
    });

    $('body').on('click','.delete-media',function (e) {
        e.preventDefault();
        var delurl = $(this).attr('data-url');
        $.ajax({
            url: delurl,
            type: 'get',  // user.destroy
            context: this,
            success: function(result) {
                if(result == '1'){
                    $(this).parent('div').remove();
                }
            }
        });
    });

    $('.select-search').select2();

    /**
     * Google Location Store With lat lng
     */
    var address = ''; //global variable

    $("#livesearch").click(function () {
        document.getElementById("livesearch").style.display = "none";
        document.getElementById("location").value = address;
    });

    if ($("#location").length > 0) {
        $("#location").focus(function () {
            autocomplete = new google.maps.places.Autocomplete(document.getElementById("location"), {
                types: ["geocode"]
            });
            autocomplete.addListener("place_changed", fillInAddress);
        });
    }
    function fillInAddress() {
        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat(),
            lng = place.geometry.location.lng();
        $('#lat').val(lat);
        $('#lng').val(lng);
        var address_line = "";
        var _iterator2 = _createForOfIteratorHelper(place.address_components),
            _step2;
        try {
            for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
                var component = _step2.value;
                var addressType = component.types[0];
                if (addressType == 'street_number' || addressType == 'route') {
                    address_line += ' ' + component.long_name;
                }
            }
        } catch (err) {
            _iterator2.e(err);
        } finally {
            _iterator2.f();
        }
        $('#adresse').val(address_line);
    }

    /**Delete learn pdf */
    $('body').on('click','.delete-pdf',function (e) {
        e.preventDefault();
        $(".loading").css('display', 'inline-block');
        var delurl = $(this).attr('data-url');
        $.ajax({
            url: delurl,
            type: 'get',
            context: this,
            success: function(result) {
                if(result == '1'){
                    $('.learn-pdf').remove();
                }
                $(".loading").hide();
            }
        });
    });
});

// delete access barcode image
$('body').on('click','.delete-barcode',function (e) {
    e.preventDefault();
    var delurl = $(this).attr('data-url');
    $.ajax({
        url: delurl,
        type: 'get',
        context: this,
        success: function(result) {
            if(result == '1'){
                $(this).parent('div').remove();
            }
        }
    });
});

$(document).ready(function() {
    let timezoneOffset = new Date().getTimezoneOffset();
    Cookies.set('timezone_offset', timezoneOffset, {path    : '/', sameSite: 'Lax'});
    Cookies.set('timezone_name', moment.tz.guess(), {path    : '/', sameSite: 'Lax'});
});
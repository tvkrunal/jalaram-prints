
/* ------------------------------------------------------------------------------
 *
 *  # Custom JS code
 *
 *  Place here all your custom js. Make sure it's loaded after app.js
 *
 * ---------------------------------------------------------------------------- */

// Setting datatable defaults
$.extend($.fn.dataTable.defaults, {
  autoWidth: false,
  columnDefs: [
    {
      orderable: false,
      width: 100 /*,
  targets: [ 5 ]*/,
    },
  ],
  dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
  language: {
    search: "<span>Filter:</span> _INPUT_",
    searchPlaceholder: "Type to filter...",
    lengthMenu: "<span>Show:</span> _MENU_",
    paginate: {
      first: "First",
      last: "Last",
      next: $("html").attr("dir") == "rtl" ? "&larr;" : "&rarr;",
      previous: $("html").attr("dir") == "rtl" ? "&rarr;" : "&larr;",
    },
  },
});

$(".dataTables_length select").select2({
  minimumResultsForSearch: Infinity,
  dropdownAutoWidth: true,
  width: "auto",
});

// Delect Record
$("#main-page-content").on("click", ".modal-popup-delete", function () {
  var del_url = $(this).data("url");
  $(".modal-delete-confirm").attr("data-url", del_url);
  var deleteText = $(this).data("modal-delete-text");
  if (deleteText != null) {
    $(".modal-text").text(deleteText);
  } else {
    $(".modal-text").text("Are you sure you want to delete this record ?");
  }
  $("#modal_delete_warning").modal("show");
});

$("body").on("click", ".modal-delete-confirm", function () {
  var del_url = $(this).attr("data-url");
  $.ajax({
    url: del_url,
    type: "DELETE", // user.destroy
    success: function (result) {
      $("#modal_delete_warning").modal("hide");

      if(result.success == false) {
        toastr.error('Something went wrong.');
      } else {
        toastr.success('Record Deleted.')
      }
      window.dataGridTable.ajax.reload();
    },
  });
});

// View Record
$("#main-page-content").on("click", ".modal-popup-view", function () {
  var view_url = $(this).data("url");
  var titleText = $(this).data("modal-title");
  if (titleText != null) {
    $(".modal-view-title").text(titleText);
  } else {
    $(".modal-view-title").text("Details");
  }
  $.get({
    url: view_url,
    success: function (data) {
      var view_html = "";
      $.each(data, function (k, v) {
          view_html += "<tr><th>" + k + "</th><td class='text-break'>" + v + "</td></tr>";
      });
      $("#modal-table-data").html(view_html);
      $("#modal_for_view").modal("show");
    },
  });
});

// View Sales Contact Record
$("#main-page-content").on("click", ".modal-popup-view-sales-contact", function () {
  var view_url = $(this).data("url");
  var titleText = $(this).data("modal-title");
  if (titleText != null) {
    $(".modal-view-title").text(titleText);
  } else {
    $(".modal-view-title").text("Details");
  }
  $.get({
    url: view_url,
    success: function (data) {
      var view_html = "";
      $.each(data, function (k, v) {
          view_html += "<div class='row'style='color:#525F7F;'><div class='col-4 border py-2 text-sm font-semibold' style='border-color:#e7eaf0'>" + k + "</div><div class='col-8 py-2 border' style='border-color:#e7eaf0;word-break:break-all;'>" + v + "</div></div>";
      });
      $("#modal-table-data").html(view_html);
      $("#modal_for_sales_contact_view").modal("show");
    },
  });
});

// View Email Track Record
$("#main-page-content").on(
  "click",
  ".modal-popup-view-email-track",
  function () {
    var view_url = $(this).data("url");
    var titleText = $(this).data("modal-title");
    if (titleText != null) {
      $(".modal-view-title").text(titleText);
    } else {
      $(".modal-view-title").text("Details");
    }
    $.get({
      url: view_url,
      success: function (data) {
        if (data.success == true) {
          $(".table_for_view").html(data.view);
          $("#modal_for_email_track_view").modal("show");
        } else {
          var header =
            "<tr><td>Count</td><td>Sheet Name</td><td>Message</td><td>Date</td></tr>";
          $(".table_for_view").append(
            header +
                '<tr><td colspan="4" class="text-center">No Data Found</td></tr>'
          );
          $("#modal_for_email_track_view").modal("show");
        }
      },
    });
  }
);

/* set greetings */
var now = new Date();
var hrs = now.getHours();
var msg = "";

if (hrs > 0) msg = "Mornin' Sunshine!"; // REALLY early
if (hrs > 6) msg = "Good morning"; // After 6am
if (hrs > 12) msg = "Good afternoon"; // After 12pm
if (hrs > 17) msg = "Good evening"; // After 5pm
if (hrs > 22) msg = "Go to bed!"; // After 10pm

$("#head_greeting").replaceWith(msg);
/* set greetings */


function togglePassword(inputId, eyeIconId) {
  var passwordInput = document.getElementById(inputId);
  var eyeIcon = document.getElementById(eyeIconId);

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    eyeIcon.classList.remove("bi-eye-slash-fill");
    eyeIcon.classList.add("bi-eye-fill");
  } else {
    passwordInput.type = "password";
    eyeIcon.classList.remove("bi-eye-fill");
    eyeIcon.classList.add("bi-eye-slash-fill");
  }
}


// preview upload image
function readURL(input, data) {
  var dynamicIdName = 'image-preview-'+ data;
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#'+dynamicIdName).attr('src', e.target.result);
      $('#'+dynamicIdName).hide();
      $('#'+dynamicIdName).fadeIn(650);
    }
    reader.readAsDataURL(input.files[0]);
  }
}

$("#file-input, #file-input-thubnail, #meta-image, #author-image").change(function() {
  var moduleName = $(this).data('module');
  readURL(this, moduleName);
});

/**
 * Entries change
 */
$('.show-entries').on('change', function() {
  window.dataGridTable.page.len($(this).val()).draw();
});
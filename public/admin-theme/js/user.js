$(document).ready(function() {
  /**
   * Submit form
   */
  function submitForm(formId, formData) {
    var form = $(formId);
    var spinner = form.find(".spinner");
    spinner.addClass("spinner-border text-light w-4 h-4 mx-2");
    
    $.ajax({
      type: 'POST',
      url: form.attr('action'),
      data: formData,
      cache: false,
      processData: false,
      contentType: false,
      success: function(response) {
        if (response.success) {
          toastr.success(response.message);
          //form[0].reset();
          if (['#document-form', '#document-previous-form', '#document-identification-form', '#document-banking-form'].includes(formId)) {
            form[0].reset();
          }
          location.reload();
        } else {
          toastr.error(response.message);
        }
      },
      error: function(data) {
        $.each(data.responseJSON.errors, function(key, value) {
          $(".print-error-msg-" + key).css("display", "block").html(value[0]);
        });
      },
      complete: function() {
        spinner.removeClass("spinner-border text-light w-4 h-4 mx-2");
      }
    });
  }

  /**
   * Forms click event
   */
  $('#contactForm, #jobDetailsForm, #relativeDetailsForm, #document-form, #document-previous-form, #document-identification-form, #document-banking-form, #blog-author-details-form').submit(function(e) {
    e.preventDefault();
    $(".print-error-msg").hide();
    var formData = new FormData(this);
    submitForm("#" + $(this).attr('id'), formData);
  });

  var noticePeriodCheckbox = document.getElementById('notice_period_checkbox');
  var noticePeriodStartDateDiv = document.getElementById('notice_period_start_date_div');
  var noticePeriodEndDateDiv = document.getElementById('notice_period_end_date_div');

  noticePeriodCheckbox.addEventListener('change', function() {
    if (this.checked) {
      noticePeriodStartDateDiv.style.display = 'block';
      noticePeriodEndDateDiv.style.display = 'block';
    } else {
      noticePeriodStartDateDiv.style.display = 'none';
      noticePeriodEndDateDiv.style.display = 'none';
    }
  });

  // Trigger change event on page load if checkbox is initially checked
  if (noticePeriodCheckbox.checked) {
    noticePeriodStartDateDiv.style.display = 'block';
    noticePeriodEndDateDiv.style.display = 'block';
  }
});

$(document).ready(function () {
    $('#group-resource-repeter').repeater({
        initEmpty: false,
        show: function () {
          var selfRepeaterItem = this;
          $(selfRepeaterItem).slideDown();
          var repeaterItems = $("div[data-repeater-item] > div.section-items");
          $(selfRepeaterItem).attr('data-index', repeaterItems.length - 1);
          $(selfRepeaterItem).find('span.repeaterItemNumber').text(repeaterItems.length);
          $(selfRepeaterItem).find('.groupResource-image-div').html('');
        },
        hide: function (deleteElement) {
          if (confirm('Are you sure you want to delete this element?')) {
            $(this).slideUp(deleteElement);
          }
        },
    });

    /**
   *  Delete section record
   */
    $(".delete-group-section").click(function (event) {
        event.preventDefault();
        var id = $(this).data("id");
        var token = $("meta[name='_token']").attr("content");
        $.ajax({
        type: 'GET',
        url: groupSectionDelete+'/'+id,
        success: function (data) {
            window.location.reload();
        }
        });
    });
});

(function($) {
  $(document).ready(function() {
    var yaysmtp_startTime_picker = moment().subtract(6, "days");
    var yaysmtp_endTime_picker = moment();
    var yay_smtp_char_obj = "";

    function yaysmtp_chart(fromDate, toDate) {
      if (yay_smtp_char_obj instanceof Chart) {
        yay_smtp_char_obj.destroy();
      }
      $.ajax({
        url: yaySmtpWpData.YAY_ADMIN_AJAX,
        type: "POST",
        data: {
          action: "yaysmtp_overview_chart",
          nonce: yaySmtpWpData.ajaxNonce,
          params: {
            from: fromDate.format("YYYY-MM-DD"),
            to: toDate.format("YYYY-MM-DD")
          }
        },
        beforeSend: function() {
          yaySMTPspinner("yaysmtp-chart-wrap", true);
        },
        success: function(result) {
          if (result.success) {
            let data = result.data.data;
            const yaysmtp_labels = data.labels;
            const yaysmtp_datasets = data.datasets;
            const yaysmtp_data = {
              labels: yaysmtp_labels,
              datasets: yaysmtp_datasets
            };
            const yaysmtpConfig = {
              type: "bar",
              data: yaysmtp_data,
              options: {
                responsive: true,
                ticks: {
                  precision: 0
                },
                plugins: {
                  legend: {
                    position: "top"
                  },
                  tooltip: {
                    multiKeyBackground: "#00000000",
                    callbacks: {
                      labelColor: function(context) {
                        return {
                          backgroundColor: context.dataset.backgroundColor
                        };
                      }
                    }
                  }
                }
              }
            };
            if ($("body").find("#yaysmtpCharts").length > 0) {
              var yaysmtpctx = document
                .getElementById("yaysmtpCharts")
                .getContext("2d");

              yay_smtp_char_obj = new Chart(yaysmtpctx, yaysmtpConfig);
            }
          }
          yaySMTPspinner("yaysmtp-chart-wrap", false);
        }
      });
    }

    yaysmtp_input_daterangepicker(
      yaysmtp_startTime_picker,
      yaysmtp_endTime_picker
    );

    if ($("body").find("#yaysmtp_daterangepicker").length > 0) {
      $("#yaysmtp_daterangepicker").daterangepicker(
        {
          startDate: yaysmtp_startTime_picker,
          endDate: yaysmtp_endTime_picker,
          alwaysShowCalendars: true,
          showCustomRangeLabel: false,
          autoUpdateInput: false,
          ranges: {
            "Last 7 Days": [moment().subtract(6, "days"), moment()],
            "This Month": [moment().startOf("month"), moment().endOf("month")],
            "Last 3 Months": [moment().subtract(90, "days"), moment()]
          },
          locale: {
            cancelLabel: "Reset",
            format: "YYYY-MM-DD"
          }
        },
        yaysmtp_input_daterangepicker
      );
    }

    $("body")
      .find("#yaysmtp_daterangepicker")
      .on("cancel.daterangepicker", function(ev, picker) {
        $("#yaysmtp_daterangepicker")
          .data("daterangepicker")
          .setStartDate(yaysmtp_startTime_picker.format("YYYY/MM/DD"));
        $("#yaysmtp_daterangepicker")
          .data("daterangepicker")
          .setEndDate(yaysmtp_endTime_picker.format("YYYY/MM/DD"));

        yaysmtp_input_daterangepicker(
          yaysmtp_startTime_picker,
          yaysmtp_endTime_picker
        );
      });

    function yaysmtp_input_daterangepicker(start, end) {
      $("#yaysmtp_daterangepicker").val(
        start.format("YYYY/MM/DD") + " - " + end.format("YYYY/MM/DD")
      );

      yaysmtp_chart(start, end);
    }

    $("body").on(
      "click",
      ".yaysmtp-import-settings-notice .close-btn",
      function() {
        $(".yaysmtp-import-settings-notice").remove();
        $.ajax({
          url: yaySmtpWpData.YAY_ADMIN_AJAX,
          type: "POST",
          data: {
            action: "yaysmtp_close_popup_import_smtp_settings",
            nonce: yaySmtpWpData.ajaxNonce
          },
          success: function(result) {}
        });
      }
    );

    $(".settings_page_yaysmtp_settings .yaysmtp-import-settings-btn").prop(
      "disabled",
      true
    );

    $(".settings_page_yaysmtp_settings .yay-smtper-plugin").click(function() {
      $(this).addClass("active");
      let pluginEls = $(this).siblings(".yay-smtper-plugin");
      $.each(pluginEls, function() {
        $(this).removeClass("active");
      });

      let pluginName = $(this).attr("data-plugin");
      $(".yaysmtp-import-plugin-choose").val(pluginName);

      $(".settings_page_yaysmtp_settings .yaysmtp-import-settings-btn").prop(
        "disabled",
        false
      );
    });

    $(".settings_page_yaysmtp_settings .yaysmtp-import-settings-btn").click(
      function() {
        let pluginName = $(".yaysmtp-import-plugin-choose").val();
        if ("" != pluginName) {
          $.ajax({
            url: yaySmtpWpData.YAY_ADMIN_AJAX,
            type: "POST",
            data: {
              action: "yaysmtp_import_smtp_settings",
              nonce: yaySmtpWpData.ajaxNonce,
              plugin_name: pluginName
            },
            beforeSend: function() {
              yaySMTPspinner("yay-smtp-wrap", true);
            },
            success: function(result) {
              yaySMTPNotification(result.data.mess, "yay-smtp-wrap");
              yaySMTPspinner("yay-smtp-wrap", false);
            }
          });
        }
      }
    );
  });
})(window.jQuery);

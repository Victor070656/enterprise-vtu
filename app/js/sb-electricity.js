$(document).ready(function () {
  $("#btnelectric").prop("disabled", true);
  $("#meterno").on("keyup change", function () {
    var network = $("#network :selected").val();
    var metertype = $("#plan :selected").val();
    var tok = $("#token").val();
    var amounttopay = $("#unit").val();
    var meterno = $("#meterno").val();
    amount_to_pay = amounttopay;

    if (meterno.toString().length >= 10) {
      $.ajax({
        url: "formrequest/verify-meter.php",
        type: "GET",
        data: {
          id: network,
          token: tok,
          meterno: meterno,
          metertype: metertype,
        },
        beforeSend: function () {
          $("#amountpay").html(
            '<i class="fa fa-spinner"></i> Validating Meter Number, Please wait...'
          );
        },
      }).done(function (resp) {
        console.log(resp);
        res = JSON.parse(resp);
        var msg = res["msg"];
        var address = res["address"];
        var name = res["name"];
        var due = res["due"];
        if (res["status"] === true) {
          $("#amountpay").html(
            "<font color='green'><i class='fa fa-check-circle'></i> " +
              msg +
              " </font> <b>Customer Name:</b> " +
              name +
              "  "
          );
          $("#btnelectric").prop("disabled", false);
        } else {
          $("#amountpay").html(
            "<font color='red'><i class='fa fa-exclamation-circle'></i> " +
              msg +
              " </font>"
          );
          $("#btnelectric").prop("disabled", true);
        }
      });
    } else if (meterno.toString().length < 10) {
      $("#amountpay").html(
        "<font color='blue'><i class='fa fa-exclamation-circle'></i> Enter valid meter number </font>"
      );
      $("#btnelectric").prop("disabled", true);
    } else if (selected === "") {
      $("#btnelectric").prop("disabled", true);
      $("#amountpay").html(
        '<font color="red"> <i class="fa fa-exclamation-circle"></i>  Please select TV Plan first </font>'
      );
      //$(this).val('');
    } else {
      $("#btnelectric").prop("disabled", true);
      $("#amountpay").text(amount_to_pay);
    }
  });

  $("#mtncglite").submit(function (e) {
    e.preventDefault();
    var disco = $("#network :selected").val();
    var meter_type = $("#plan :selected").val();
    var token = $("#token").val();
    var amounttopay = $("#unit").val();
    var meter_no = $("#meterno").val();
    var amount = $("#amount").val();
    $.ajax({
      url: "formrequest/ini-electric.php",
      type: "POST",
      data: {
        id: disco,
        token: token,
        meterno: meter_no,
        metertype: meter_type,
        amount: amount,
      },
      dataType: "json",
      beforeSend: function () {
        $("#btnelectric").html('<i class="fa fa-spinner"></i> Please wait...');
      },
      success: function (data) {
        // data = JSON.parse(data);
        console.log(data);
        if (data.status === true) {
          var dirUrl = data.redirect;
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener("mouseenter", Swal.stopTimer);
              toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
          });

          Toast.fire({
            icon: "success",
            text: data.msg,
          });
          setTimeout(function () {
            document.location.replace(dirUrl);
          }, 3000);
        } else {
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener("mouseenter", Swal.stopTimer);
              toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
          });

          Toast.fire({
            icon: "error",
            text: data.msg,
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", error);
        console.error("AJAX status:", status);
        console.log("Server response:", xhr.responseText);
        $("#btnelectric").html("Submit"); // Reset button text on error
      },
    });

  });

  // $("#mtncglite").submit(function (e) {
  //   e.preventDefault();
  //   var disco = $("#network :selected").val();
  //   var meter_type = $("#plan :selected").val();
  //   var token = $("#token").val();
  //   var amounttopay = $("#unit").val();
  //   var meter_no = $("#meterno").val();
  //   var amount = $("#amount").val();
  //   $.ajax({
  //     url: "formrequest/ini-electric.php",
  //     type: "POST",
  //     data: {
  //       id: disco,
  //       token: token,
  //       meterno: meter_no,
  //       metertype: meter_type,
  //       amount: amount,
  //     },
  //     dataType: "json",
  //     beforeSend: function () {
  //       $("#btnelectric").html('<i class="fa fa-spinner"></i> Please wait...');
  //     },
  //     success: function (data) {
  //       data = JSON.parse(data);
  //       console.log(data);
  //       if (data.status === true) {
  //         var dirUrl = data.redirect;
  //         const Toast = Swal.mixin({
  //           toast: true,
  //           position: "top-end",
  //           showConfirmButton: false,
  //           timer: 3000,
  //           timerProgressBar: true,
  //           didOpen: (toast) => {
  //             toast.addEventListener("mouseenter", Swal.stopTimer);
  //             toast.addEventListener("mouseleave", Swal.resumeTimer);
  //           },
  //         });

  //         Toast.fire({
  //           icon: "success",
  //           text: data.msg,
  //         });
  //         setTimeout(function () {
  //           document.location.replace(dirUrl);
  //         }, 3000);
  //       } else {
  //         const Toast = Swal.mixin({
  //           toast: true,
  //           position: "top-end",
  //           showConfirmButton: false,
  //           timer: 3000,
  //           timerProgressBar: true,
  //           didOpen: (toast) => {
  //             toast.addEventListener("mouseenter", Swal.stopTimer);
  //             toast.addEventListener("mouseleave", Swal.resumeTimer);
  //           },
  //         });

  //         Toast.fire({
  //           icon: "error",
  //           text: data.msg,
  //         });
  //       }
  //     },
  //     error: function (xhr, status, error) {
  //       console.error("AJAX error:", error);
  //       console.error("AJAX status:", status);
  //       console.log("Server response:", xhr.responseText);
  //       $("#btnelectric").html("Submit"); // Reset button text on error
  //     },
  //   });
  // });
});

/**
 * Server response: <br />
<b>Fatal error</b>:  Uncaught mysqli_sql_exception: Incorrect datetime value: '2024-11-22 06:40:AM' for column `vtu_app`.`transactions`.`date` at row 1 in /opt/lampp/htdocs/Enterprise_application/app/formrequest/ini-electric.php:122
Stack trace:
#0 /opt/lampp/htdocs/Enterprise_application/app/formrequest/ini-electric.php(122): mysqli_stmt-&gt;execute()
#1 {main}
  thrown in <b>/opt/lampp/htdocs/Enterprise_application/app/formrequest/ini-electric.php</b> on line <b>122</b><br />
 */
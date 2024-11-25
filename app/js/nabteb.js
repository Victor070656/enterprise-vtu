$("#waecForm").submit(function (e) {
  e.preventDefault();
  var data = $(this).serialize();
  $.ajax({
    url: "formrequest/nabtebRequest.php",
    type: "POST",
    data: data,
    beforeSend: function () {
      $("#btnsub").html("Please wait");
    },
  }).done(function (res) {
    res = JSON.parse(res);
    let redirUrl = res["redirect"];
    let Message = res["msg"];
    if (res["status"]) {
      window.location.replace(redirUrl);
      // alert(redirUrl);
    } else {
      Swal.fire({
        position: "top-end",
        icon: "error",
        text: Message,
        showConfirmButton: false,
        timer: 1500,
      });
    }
  });
});

function Comma(Num) {
  Num += "";
  Num = Num.replace(/,/g, "");

  x = Num.split(".");
  x1 = x[0];

  x2 = x.length > 1 ? "." + x[1] : "";

  var rgx = /(\d)((\d{3}?)+)$/;

  while (rgx.test(x1)) x1 = x1.replace(rgx, "$1" + "," + "$2");

  return x1 + x2;
}

function showTv() {
  if (document.getElementById("smiledata").checked) {
    document.getElementById("ifData").style.display = "block";

    var sourceOfPicture = "assets/images/nabteb-result.png";
    var img = document.getElementById("bigpic");
    img.src = sourceOfPicture.replace("90x90", "225x225");
    img.style.display = "block";

    $("#IsData").change(function () {
      var selected = $(this).find("option:selected");
      var amount = selected.data("amount");
      var service = selected.data("service");
      var plan = selected.data("plan");
      var variation_code = selected.data("variation_code");

      $("#amount").val(amount);
      $("#service").val(service);
      $("#plan").val(plan);
      $("#variation_code").val(variation_code);
    });

    $("#rctel").keyup(function () {
      var phoneN = $("#rctel")
        .val()
        .replace(/[^\d]+/g, "");
      $("#tele").val(phoneN);
    });

    $("#qty1").keyup(function () {
      var qty1 = $("#qty1")
        .val()
        .replace(/[^\d]+/g, "");
      $("#iuc").val(qty1);
    });
  } else document.getElementById("ifData").style.display = "none";

  if (document.getElementById("voice").checked) {
    document.getElementById("ifVoice").style.display = "block";

    var gsourceOfPicture = "assets/images/WAEC-Registration.jpg";
    var gimg = document.getElementById("bigpic");
    gimg.src = gsourceOfPicture.replace("90x90", "225x225");
    gimg.style.display = "block";

    $("#IsVoice").change(function () {
      var selected = $(this).find("option:selected");
      var amount = selected.data("amount");
      var service = selected.data("service");
      var plan = selected.data("plan");
      var variation_code = selected.data("variation_code");
      var trans = selected.data("trans");

      $("#amount").val(amount);
      $("#service").val(service);
      $("#plan").val(plan);
      $("#variation_code").val(variation_code);
      $("#transType").val(trans);
    });

    $("#rgtel").on("keyup keydown change", function () {
      var phone = $("#rgtel")
        .val()
        .replace(/[^\d]+/g, "");
      $("#tele").val(phone);
    });

    $("#qty2").on("keyup keydown change", function () {
      var qty2 = $("#qty2")
        .val()
        .replace(/[^\d]+/g, "");
      $("#iuc").val(qty2);
    });
  } else document.getElementById("ifVoice").style.display = "none";
}

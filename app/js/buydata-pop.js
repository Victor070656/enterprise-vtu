function clearSelected() {
  var elements = document.getElementById("data_type").options;

  for (var i = 0; i < elements.length; i++) {
    elements[i].selected = false;
  }
}

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
  if (document.getElementById("mtn").checked) {
    document.getElementById("ifGotv").style.display = "block";

    document.getElementById("network").value =
      document.getElementById("mtn").value;
    var sourceOfPicture = "assets/images/Data-mtn.jpg";
    var img = document.getElementById("bigpic");
    img.src = sourceOfPicture.replace("90x90", "225x225");
    img.style.display = "block";

    $("#SME").show();
    $("#CG_LITE").show();
    $("#DIRECT").show();
    $("#GIFTING").show();

    $("#data_type").change(function () {
      if ($(this).val() == "SME") {
        $("#sme").show();
        $("#cglite").hide();
        $("#cg").hide();
        $("#direct").hide();
        $("#dataplans").show();
      } else if ($(this).val() == "CG_LITE") {
        $("#sme").hide();
        $("#cglite").show();
        $("#cg").hide();
        $("#direct").hide();
        $("#dataplans").show();
      } else if ($(this).val() == "GIFTING") {
        $("#sme").hide();
        $("#cglite").hide();
        $("#cg").show();
        $("#direct").hide();
        $("#dataplans").show();
      } else if ($(this).val() == "DIRECT") {
        $("#sme").hide();
        $("#cglite").hide();
        $("#cg").hide();
        $("#direct").show();
        $("#dataplans").show();
      } else {
        // nothing
      }
    });
  } else document.getElementById("ifGotv").style.display = "none";

  if (document.getElementById("airtel").checked) {
    document.getElementById("ifDstv").style.display = "block";
    document.getElementById("networkAirtel").value =
      document.getElementById("airtel").value;
    var sourceOfPicture = "assets/images/Airtel-Data.jpg";
    var img = document.getElementById("bigpic");
    img.src = sourceOfPicture.replace("90x90", "225x225");
    img.style.display = "block";

    $("#SME_AIRTEL").hide();
    $("#CG_LITE_AIRTEL").hide();
    $("#DIRECT_AIRTEL").show();
    $("#GIFTING_AIRTEL").show();

    $("#data_type_airtel").change(function () {
      if ($(this).val() == "SME") {
        $("#sme_airtel").show();

        $("#cg_airtel").hide();
        $("#direct_airtel").hide();
      } else if ($(this).val() == "GIFTING") {
        $("#sme_airtel").hide();

        $("#cg_airtel").show();
        $("#direct_airtel").hide();
      } else if ($(this).val() == "DIRECT") {
        $("#sme_airtel").hide();

        $("#cg_airtel").hide();
        $("#direct_airtel").show();
      } else {
        // nothing
      }
    });
  } else document.getElementById("ifDstv").style.display = "none";

  if (document.getElementById("glo").checked) {
    document.getElementById("ifStar").style.display = "block";
    document.getElementById("networkGlo").value =
      document.getElementById("glo").value;
    var sourceOfPicture = "assets/images/GLO-Data.jpg";
    var img = document.getElementById("bigpic");
    img.src = sourceOfPicture.replace("90x90", "225x225");
    img.style.display = "block";

    $("#SME_GLO").hide();
    $("#CG_LITE_GLO").hide();
    $("#DIRECT_GLO").show();
    $("#GIFTING_GLO").show();

    $("#data_type_glo").change(function () {
      if ($(this).val() == "SME") {
        $("#sme_glo").show();

        $("#cg_glo").hide();
        $("#direct_glo").hide();
      } else if ($(this).val() == "GIFTING") {
        $("#sme_glo").hide();

        $("#cg_glo").show();
        $("#direct_glo").hide();
      } else if ($(this).val() == "DIRECT") {
        $("#sme_glo").hide();

        $("#cg_glo").hide();
        $("#direct_glo").show();
      } else {
        // nothing
      }
    });
  } else document.getElementById("ifStar").style.display = "none";

  if (document.getElementById("9mobile").checked) {
    document.getElementById("if9mob").style.display = "block";
    document.getElementById("network9mobile").value =
      document.getElementById("9mobile").value;
    var sourceOfPicture = "assets/images/9mobile-Data.jpg";
    var img = document.getElementById("bigpic");
    img.src = sourceOfPicture.replace("90x90", "225x225");
    img.style.display = "block";

    $("#SME_ETI").show();
    $("#GIFTING_ETI").show();
    $("#DIRECT_ETI").show();

    $("#data_type_eti").change(function () {
      if ($(this).val() == "SME") {
        $("#sme_eti").show();

        $("#cg_eti").hide();
        $("#direct_eti").hide();
      } else if ($(this).val() == "GIFTING") {
        $("#sme_eti").hide();

        $("#cg_eti").show();
        $("#direct_eti").hide();
      } else if ($(this).val() == "DIRECT") {
        $("#sme_eti").hide();

        $("#cg_eti").hide();
        $("#direct_eti").show();
      } else {
        // nothing
      }
    });
  } else document.getElementById("if9mob").style.display = "none";
}

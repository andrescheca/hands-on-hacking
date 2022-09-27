var page = require("webpage").create();
var host = "localhost";
var url = "http://" + host + "/check.php";
var timeout = 5000;
phantom.addCookie({
  name: "is_admin",
  value: "tN5pEAc1ebqvvlwWkEnY",
  domain: host,
  path: "/",
  httponly: true,
});
page.onNavigationRequested = function (url) {
  console.log("[URL] URL=" + url);
};
page.settings.resourceTimeout = timeout;
page.onResourceTimeout = function (e) {
  setTimeout(function () {
    console.log("[INFO] Timeout");
    // phantom.exit();
  }, 1);
};

const navigate = function () {
  page.open(url, function (status) {
    console.log("[INFO] rendered page");
    setTimeout(function () {
      // phantom.exit();
    }, 1);
  });
};

navigate();
setInterval(navigate, timeout);

var page = require("webpage").create();
var host = "localhost";
var url = "http://" + host + "/check.php";
var timeout = 5000;
phantom.addCookie({
  name: "session_id",
  value: "This cookie should be a secret",
  domain: host,
  path: "/",
  httponly: false,
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

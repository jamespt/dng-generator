(function () {

  var data = [];
  var gender = "female";
  var letter = null;
  var name = null;
  var letters = ["a", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
  var nameContainer = null;
  var viewedDb = {};
  var viewed = {};
  var uviewed = {};
  var generated = null;
  var soum = 0;

  window.onload = function () {

    if (document.querySelector(".dng-container")) {

      var ajaxData = { action: "dng_get_data" };

      jQuery.ajax({
        url: ajax_url,
        type: 'POST',
        data: ajaxData,
        success: function (d) {
          data = JSON.parse(d);
          init();
        },
        error: function (err, rex, ww) {
          console.log(err, rex, ww);
        }
      });
    }
  }

  function init() {

    nameContainer = document.querySelector("[data-action='name']");
    generated = document.querySelector("[data-action='generated']")

    ieFixes();
    events();
    getFromDb();
    popups();
    share();
    synchronization();
    clearDB();
  }

  function clearDB() {
    setInterval(function () {
      var ajaxData = { action: "dng_clear_names" };

      jQuery.ajax({
        url: ajax_url,
        type: 'POST',
        data: ajaxData,
      });

    }, 10000);
  }

  function synchronization() {
    setInterval(function () {
      sendToDb();
    }, 5000);
  }

  function sendToDb() {
    if (Object.keys(viewedDb).length != 0 && viewedDb.constructor === Object) {
      var ajaxData = { action: "dng_post_names", data: viewedDb };

      jQuery.ajax({
        url: ajax_url,
        type: 'POST',
        data: ajaxData,
        success: function (status) {
          viewedDb = {};
        },
        error: function (err, rex, ww) {
          console.log(err, rex, ww);
        }
      });
    }
  }

  function getFromDb() {
    var ajaxData = { action: "dng_get_names" };

    jQuery.ajax({
      url: ajax_url,
      type: 'POST',
      data: ajaxData,
      success: function (data) {
        var d = JSON.parse(data);
        d ? viewed = d : viewed = {};
        generateName();
      },
      error: function (err, rex, ww) {
        console.log(err, rex, ww);
      }
    });

  }

  function share() {
    facebook = document.querySelector("[data-action='social-facebook']");
    twitter = document.querySelector("[data-action='social-twitter']");

    facebook.addEventListener("click", function () {
      window.open("https://www.facebook.com/sharer/sharer.php?u=" + window.location, "Share", "width=500,height=400");
    });

    twitter.addEventListener("click", function () {
      window.open("https://twitter.com/intent/tweet?text=Dog%20Name%20Generator&url=" + window.location, "Share", "width=500,height=400");
    });

  }

  function generateName() {

    var t = true;
    var newData = [];

    if (!letter) {
      letter = letters[Math.floor(Math.random() * letters.length)];
      t = false;
    }

    if (gender == "both") {
      name = data[letter][Math.floor(Math.random() * data[letter].length)];
    } else {
      newData = data[letter].filter(function (elem) {
        return (elem.gender == gender);
      })
      name = newData[Math.floor(Math.random() * newData.length)];
    }

    nameContainer.innerHTML = name.name;

    if (!uviewed[name.name]) {

      uviewed[name.name] = 1;
      viewed[name.name] = (viewed[name.name]) ? viewed[name.name] + 1 : 1;
      viewedDb[name.name] = (viewedDb[name.name]) ? viewedDb[name.name] + 1 : 1;

    }

    calculateSoum();

    //generated.innerHTML = viewed[name.name]; // per name
    generated.innerHTML = soum // overal


    if (!t) letter = null;
  }

  function calculateSoum() {

    soum = 0;

    for (let [key, value] of Object.entries(viewed)) {
      soum += value;
    }

  }

  function events() {

    var genderButtons = document.querySelectorAll(".dng-gender button");
    var letters = document.querySelectorAll(".dng-letter-selector div");

    genderButtons.forEach(function (button) {
      button.addEventListener("click", function () {
        genderButtons.forEach(function (button) {
          button.classList.remove("active");
        });

        button.classList.add("active");
        gender = button.dataset.gender;

      });
    });

    letters.forEach(function (l) {
      l.addEventListener("click", function () {
        letters.forEach(function (l) {
          l.classList.remove("active");
        });

        l.classList.add("active");
        letter = l.dataset.value;

        document.querySelector("[data-action='current-letter']").innerHTML = letter;

        buildAll();
      });
    });

    document.querySelector("[data-action='see-all']").addEventListener("click", function () {
      document.querySelector(".dng-popup").classList.add("active");
      document.querySelector(".page").classList.add("popup-active");
    });

    document.querySelector("[data-action='generate']").addEventListener("click", function () {
      generateName();
    });

    window.onunload = function () {
      sendToDb();
    }

    document.addEventListener("mouseleave", function () {
      sendToDb();
    });

  }

  function buildAll() {
    var ul = document.querySelector("[data-action='all-list']");
    ul.innerHTML = '';

    data[letter].forEach(function (l) {
      ul.innerHTML += "<li>" + l.name + "</li>";
    });
  }

  function popups() {
    var popups = document.querySelectorAll(".dng-popup");

    popups.forEach(function (popup) {
      popup.querySelector(".dng-popup-close").addEventListener("click", function () {
        popup.classList.remove("active");
        document.querySelector(".page").classList.remove("popup-active");
      });
      popup.querySelector(".dng-popup-overlay").addEventListener("click", function () {
        popup.classList.remove("active");
        document.querySelector(".page").classList.remove("popup-active");
      });
    });
  }
  
  function ieFixes() {
    NodeList.prototype.forEach = Array.prototype.forEach;
  }

})();
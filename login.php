<?php
require_once("AccountKit/settings.php");
?>


<head>
    <script src="https://sdk.accountkit.com/en_US/sdk.js"></script>
    <script>
      // initialize Account Kit with CSRF protection
      AccountKit_OnInteractive = function(){
        AccountKit.init(
          {
            appId: <?=APP_ID?>,
            state: "testing",
            version: '<?=VERSION?>',
            debug: true
          }
        );
      };

      // login callback
      function loginCallback(response) {
        if (response.status === "PARTIALLY_AUTHENTICATED") {
          var code = response.code;
          var csrf = response.state;
          // Send code to server to exchange for access token
          document.getElementById("code").value = code;
          document.getElementById("csrf").value = csrf;
          document.getElementById("login_success").submit();
        }
        else if (response.status === "NOT_AUTHENTICATED") {
          // handle authentication failure
        }
        else if (response.status === "BAD_PARAMS") {
          // handle bad parameters
        }
      }

      // phone form submission handler
      function smsLogin() {
        var countryCode = document.getElementById("country_code").value;
        var phoneNumber = document.getElementById("phone_number").value;
        AccountKit.login(
          'PHONE',
          {countryCode: countryCode, phoneNumber: phoneNumber}, // will use default values if not specified
          loginCallback
        );
      }


      // email form submission handler
      function emailLogin() {
        var emailAddress = document.getElementById("email").value;
        AccountKit.login(
          'EMAIL',
          {emailAddress: emailAddress},
          loginCallback
        );
      }
    </script>
</head>

<body>
    <input value="+1" id="country_code" />
    <input placeholder="phone number" id="phone_number"/>
    <button onclick="smsLogin();">Login via SMS</button>
    <div>OR</div>
    <input placeholder="email" id="email"/>
    <button onclick="emailLogin();">Login via Email</button>
    <form id="login_success" method="post" action="/login_success.php">
      <input id="csrf" type="hidden" name="csrf" />
      <input id="code" type="hidden" name="code" />
    </form>
</body>


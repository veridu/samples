  /*
   * var settings: object that will store client, session and user settings.
   */
  var settings = {};

  /*
   *  Once you have your widget setup you can use the 'Veridu_SSO_Authenticated' event listener to receive and process information
   */

  window.addEventListener('Veridu_SSO_Authenticated', function (evt) {

    /*
     * Capture session variables (to query the API)
     *
     * settings.session : stores the session token
     *
     * settings.user : stores veridu_user
     *
     * settings.client: stores the api key
     *
     */

    settings.session  = window.VeriduSSOWidget.sdkCfg.session;
    settings.user = window.VeriduSSOWidget.sdkCfg.user;
    settings.client  = window.VeriduSSOWidget.sdkCfg.client;

    /*
     *  Calls initVeridu() function
     */
    initVeridu();

  });

  /*
   * 	Calls the constructor of the Veridu SDK passing the settings variable defined before, then makes the request to /profile endpoint and after that prints the json response.
   */
  function initVeridu() {
    //instantiantes the Veridu SDK
    var Veridu = new window.Veridu(settings);

    //request to /profile endpoint passing the username already stored in settins.user
    Veridu.API.fetch('GET', 'profile/' + settings.user)
        .then(
          function success(response) {
            //convert json to string
            var json = JSON.stringify(response, null, 2);
            //append the json response into the <pre> tag
            $("#profile").text(json);
          },
          function error(response) {
            connected = false;
          }
        )
  }

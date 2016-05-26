package com.veridu.samples.sso.oauth2;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
//importing veridu api
import java.util.HashMap;

import org.json.simple.JSONObject;
import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;

import com.veridu.API;
import com.veridu.Utils;

public class Oauth2 {
    public static void main(String[] args) {
        try {

            // instantiate the Configuration Reader Class
            Utils utils = new Utils();

            // get the configuration values
            JSONObject config = utils.readConfig("config.json");

            String key = config.get("KEY").toString();
            String secret = config.get("SECRET").toString();
            String version = config.get("VERSION").toString();
            String username = config.get("USERNAME").toString();

            // get Twitter configuration values
            JSONObject facebook = utils.readConfig("facebook.json");
            String appid = facebook.get("APPID").toString();

            // Instantiate API object
            API api = API.factory(key, secret, version);

            // Response JSON object
            JSONObject json;

            // creates new a read/write Veridu session
            // more info: https://veridu.com/wiki/Session_Resource
            api.getSession().create(false);

            /*
             * args: provider SSO (google, twitter, facebook, etc) and data:
             * token and refresh(optional) more info :
             * https://veridu.com/wiki/SSO_Resource
             */

            // data
            HashMap<String, String> data = new HashMap<>();
            // Token is result of oAuth handshake
            data.put("token",
                    "CAAEO02ZBeZBwMBAFjIhMOuKgwRnecTQoJSBJDb3iPMNBvjc2VaZA7VQQ5MAhKAs77Yh4gZB13M3Mw4TnOkFA7R6fG1YMcwatddp1blKdRiPKETd4hZCZBFebT3ioXbwTiy4JKjFF89RDzMkpHzuD1VIM4xQGDKsDBpilX9cW4EX8gbJTOnlYOByaur0TaDqBFdj1fVZCutAFjvT4YedX7yU");

            // Creates oAuth sso using facebook as provider
            json = api.getSSO().createOauth1("facebook", data);
            /*
             * prints API response ' * more details:
             * https://veridu.com/wiki/SSO_Resource#
             * How_to_do_a_social_single_sign_on
             */
            System.out.println(json);

            // veridu_id is the user's unique id
            api.getStorage().setUsername((String) json.get("veridu_id"));

            // retrieves user's profile
            // more info: https://veridu.com/wiki/Profile_Resource
            json = api.getProfile().retrieve();

            // prints json response
            System.out.println(json);

        } catch (Exception ex) {
            System.out.println(ex.getMessage());
        }

    }

    private JSONObject readDefaultConfigFile() throws ParseException {
        InputStream is = this.getClass().getResourceAsStream("/config.json");
        BufferedReader bf = new BufferedReader(new InputStreamReader(is));
        StringBuilder configString = new StringBuilder();
        String line;
        try {
            line = bf.readLine();
            while (line != null) {
                configString.append(line);
                line = bf.readLine();
            }
            bf.close();
        } catch (IOException e) {
            e.printStackTrace();
        }

        JSONParser parser = new JSONParser();
        JSONObject json = (JSONObject) parser.parse(configString.toString());

        return json;
    }

    private JSONObject readFacebookConfigFile() throws ParseException {
        InputStream is = this.getClass().getResourceAsStream("/facebook.json");
        BufferedReader bf = new BufferedReader(new InputStreamReader(is));
        StringBuilder configString = new StringBuilder();
        String line;
        try {
            line = bf.readLine();
            while (line != null) {
                configString.append(line);
                line = bf.readLine();
            }
            bf.close();
        } catch (IOException e) {
            e.printStackTrace();
        }

        JSONParser parser = new JSONParser();
        JSONObject json = (JSONObject) parser.parse(configString.toString());

        return json;
    }
}

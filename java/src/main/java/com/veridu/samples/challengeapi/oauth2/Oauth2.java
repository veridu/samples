package com.veridu.samples.challengeapi.oauth2;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
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

            // assigns the fresh Veridu session to user
            // more info: https://veridu.com/wiki/User_Resource
            api.getUser().create(username);

            /*
             * args: provider SSO (google, twitter, facebook, etc) and data:
             * token, secret and appid(optional)
             */

            // data
            HashMap<String, String> data = new HashMap<>();
            // Token is result of oAuth handshake
            data.put("token", "928248127241705");
            data.put("secret", "767b8a2bd52fec2d100a01604455ce1a");
            // get APPID from FacebookSettings class
            if (appid != "0")
                data.put("appid", String.valueOf(appid));
            // sends the access token
            // more info: https://veridu.com/wiki/Provider_Resource
            //
            String task_id = api.getProvider().createOAuth2("facebook", data);
            /*
             * prints task_id more details:
             * https://veridu.com/wiki/Provider_Resource#
             * How_to_create_a_access_token_under_given_user_for_the_given_provider
             */
            System.out.println(task_id);
            /*
             * Polling API to wait until data analysis is done Note: can be done
             * via WebHook without polling
             */
            do {
                Thread.sleep(5000);
                // parse task_id to int to make a call to task details
                json = api.getTask().details(Integer.parseInt(task_id));
            } while (Boolean.parseBoolean(json.get("running").toString()) == true);

            // retrieves user's profile
            // more info: https://veridu.com/wiki/Profile_Resource
            json = api.getProfile().retrieve();
            /*
             * prints API response more details:
             * https://veridu.com/wiki/Profile_Resource#
             * How_to_retrieve_the_consolidated_profile_of_a_given_user
             */
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

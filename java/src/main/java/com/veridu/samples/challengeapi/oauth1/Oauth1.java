package com.veridu.samples.challengeapi.oauth1;

import java.io.UnsupportedEncodingException;
import java.util.HashMap;

import org.json.simple.JSONObject;
import org.json.simple.parser.ParseException;

import com.veridu.API;
import com.veridu.Utils;
import com.veridu.exceptions.SDKException;

public class Oauth1 {
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
            JSONObject twitter = utils.readConfig("twitter.json");
            String appid = twitter.get("APPID").toString();

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
            // Token and Secret are results of oAuth handshake
            data.put("token", "the-token-goes-here");
            data.put("secret", "the-secret-goes-here");
            // Get APPID from TwitterSettings class
            if (appid != "0")
                data.put("appid", String.valueOf(appid));
            String task_id = api.getProvider().createOAuth1("twitter", data);

            /*
             * prints task_id more details:
             * https://veridu.com/wiki/SSO_Resource#
             * How_to_do_a_social_single_sign_on
             */
            System.out.println(task_id);

            /*
             * Polling API to wait until check is done Note: can be done via
             * WebHook without polling
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

        } catch (SDKException ex) {
            System.out.println(ex.getMessage());
        } catch (ParseException e) {
            e.printStackTrace();
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
    }
}

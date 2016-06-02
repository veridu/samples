package com.veridu.samples.sso.oauth1;

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
            /*
             * args: provider SSO (google, twitter, facebook, etc) and data:
             * token, secret and appid(optional)
             */

            // data
            HashMap<String, String> data = new HashMap<>();
            // Token and Secret are results of oAuth handshake
            data.put("token", "the-token-goes-here");
            data.put("secret", "the-token-goes-here");

            json = api.getSSO().createOauth1("twitter", data);

            /*
             * prints API response more details:
             * https://veridu.com/wiki/SSO_Resource#
             * How_to_do_a_social_single_sign_on
             */
            System.out.println(json);

            // veridu_id is the user's unique id
            api.getStorage().setUsername((String) json.get("veridu_id"));

            // retrieves user's profile
            // more info: https://veridu.com/wiki/Profile_Resource
            json = api.getProfile().retrieve();

            System.out.println(json);

        } catch (SDKException ex) {
            System.out.println(ex.getMessage());
        } catch (ParseException e) {
            e.printStackTrace();
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
        }
    }
}

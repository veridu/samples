package com.veridu.samples.sso.oauth2;

import java.io.UnsupportedEncodingException;
//importing veridu api
import java.util.HashMap;

import org.json.simple.JSONObject;
import org.json.simple.parser.ParseException;

import com.veridu.API;
import com.veridu.Utils;
import com.veridu.exceptions.SDKException;

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
            data.put("token", "your-token-goes-here");

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

        } catch (SDKException ex) {
            System.out.println(ex.getMessage());
        } catch (ParseException e) {
            e.printStackTrace();
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
        }
    }
}
